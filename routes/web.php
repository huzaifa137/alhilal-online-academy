<?php

use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Teacher\TeacherLessonController;
use App\Http\Controllers\Teacher\SettingsController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\Admin\SectionController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Session;

Route::get('/all-sessions', function () {
    dd(Session::all());
});

Route::controller(TeacherController::class)->group(function () {
    Route::group(['middleware' => ['AdminAuth']], function () {

        Route::get('/teacher/dashboard', 'teacherDashboard')->name('teacher.dashboard');
    });
});

Route::controller(UserController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {
        Route::get('/user-profile', 'userProfile')->name('user.profile');
        Route::post('/profile/update', 'updateProfile')->name('profile.update');
    });

    Route::group(['prefix' => '/users'], function () {

        Route::get('/user-logout', 'userLogout')->name('user-logout');
        Route::get('/student-logout', 'studentLogout')->name('student-logout');
        Route::get('/teacher-logout', 'teacherLogout')->name('teacher-logout');

        Route::post('auth-user-check', 'checkUser')->name('auth-user-check');
        Route::post('user-account-creation', 'userAccountCreation')->name('user-account-creation');
        Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
        Route::post('user-generate-forgot-password-link', 'generateForgotPasswordLink')->name('user-generate-forgot-password-link');
        Route::post('user-store-new-password', 'store_new_password')->name('user-store-new-password');

        // Admin protected routes
        Route::group(['middleware' => ['AdminAuth']], function () {

            Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
            Route::get('/users-profile', 'userProfile')->name('users-profile');
            Route::get('/users-information', 'userInformation')->name('users.user-information');
            Route::get('user-account-information/{id}', 'userAccountInformation');
            Route::get('delete-user/{id}', 'deleteUser');
            Route::get('/home-page', 'homePage')->name('home.page');
            Route::get('/home-page', 'homePage')->name('home');
            Route::get('/edit-user-information', 'editUserInformation');
            Route::get('/edit-specific-user/{userid}', 'editSpecificUser');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
        });

        Route::post('store-internal-user', 'storeInternalUser')->name('store-internal-user');
        Route::post('update-internal-user', 'storeUpdatedInternalUser')->name('update-internal-user');
        Route::post('save-role', 'saveUserRole')->name('save-role');
        Route::post('store-role-update', 'storeRoleUpdate')->name('store-role-update');
        Route::post('store-updated-information', 'storeUpdatedInformation')->name('store-updated-information');

    });

    Route::get('password/reset/{id}', 'createNewPassword')->name('password/reset');
    Route::get('reload-captcha', 'reload_captcha')->name('reload-captcha');
});

Route::controller(MasterDataController::class)->group(function () {

    Route::group(['prefix' => 'master-data'], function () {

        Route::get('master-code-to-data', 'masterCodeToData')->name('master-code-to-data');

        Route::get('/load-data', 'loadData')->name('load.data');
        Route::get('master-table', 'master_table')->name('master-table');
        Route::get('master-code', 'master_code')->name('master-code');

        Route::get('edit-record/{id}', 'editRecord');
        Route::get('add-record', 'addRecord')->name('add-record');
        Route::get('add-code', 'addMasterCode')->name('add-code');
        Route::get('edit-code/{id}', 'editMasterCode');
        Route::get('master-code-list/{id}', 'masterCodeList')->name('master-code-list');
        Route::get('master-code-list', 'masterCodeList');

    });

    Route::post('update-master-record', 'updateMasterrecord')->name('update-master-record');
    Route::post('update-master-code', 'updateMasterCode')->name('update-master-code');
    Route::post('send-master-code', 'sendMasterCode')->name('send-master-code');
    Route::post('add-new-record', 'addNewRecord')->name('add-new-record');

    Route::get('delete-record/{id}', 'deleteRecord');
    Route::get('delete-code/{id}', 'deleteCode');

});

Route::controller(StudentController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {

        Route::get('/', 'homePage');

        Route::group(['prefix' => '/users'], function () {
            Route::get('/login', 'login')->name('users.login');
            Route::get('/login', 'login')->name('login');
            Route::get('/register', 'register')->name('users.register');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
        });

        Route::group(['prefix' => '/student'], function () {
            Route::get('/dashboard', 'studentDashboard')->name('student.dashboard');
            Route::get('/lessons-lists', 'studentLessonList')->name('student.lessons.lists');
        });

    });
});


Route::prefix('admin')->name('admin.')->group(function () {

    // Sections Routes
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

});

// routes/web.php
Route::get('/admin/sections/{section}/levels', [LevelController::class, 'index'])->name('admin.levels.index');
Route::get('/admin/levels/create', [LevelController::class, 'create'])->name('admin.levels.create');
Route::post('/admin/levels', [LevelController::class, 'store'])->name('admin.levels.store');
Route::get('/admin/levels/{level}/edit', [LevelController::class, 'edit'])->name('admin.levels.edit');
Route::put('/admin/levels/{level}', [LevelController::class, 'update'])->name('admin.levels.update');


// Teacher Lesson Routes
Route::middleware(['AdminAuth'])->prefix('teacher')->name('teacher.')->group(function () {

    Route::get('/dashboard', [TeacherController::class, 'teacherDashboard'])->name('dashboard');

    Route::prefix('lessons')->name('lessons.')->controller(TeacherLessonController::class)->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/lists', 'lessonList')->name('lists');
        Route::get('/create', 'createLesson')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{lesson}', 'showLesson')->name('show');
        Route::post('/process-payment', 'processPayment')->name('process-payment');

        Route::get('/classes/list', 'getAvailableClasses')->name('classes.list');
        Route::get('/classes/{classId}/subjects', 'getAvailableClassSubjects')->name('class.subjects');
        Route::get('/classes/{classId}/subjects/{subjectId}/topics', 'getSubjectTopics')->name('subject.topics');


        Route::prefix('progress')->name('progress.')->controller(\App\Http\Controllers\Teacher\StudentProgressController::class)->group(function () {
            Route::post('/mark-completed', 'markCompleted')->name('mark-completed');
            Route::post('/update', 'updateProgress')->name('update');
            Route::get('/{lessonId}/{studentId}', 'getProgress')->name('get');
            Route::get('/lesson/{lessonId}', 'getLessonProgress')->name('lesson');
        });
    });

    Route::prefix('enrollments')->name('enrollments.')->group(function () {
        Route::get('/', [TeacherLessonController::class, 'enrollmentManagement'])->name('index');
        Route::post('/enroll', [TeacherLessonController::class, 'enrollStudent'])->name('enroll');
        Route::put('/{enrollmentId}', [TeacherLessonController::class, 'updateEnrollment'])->name('update');
        Route::delete('/{enrollmentId}', [TeacherLessonController::class, 'removeEnrollment'])->name('remove');
        Route::get('/class/{classId}', [TeacherLessonController::class, 'getEnrolledStudents'])->name('class-students');
    });
});


Route::middleware(['AdminAuth'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [TeacherController::class, 'teacherDashboard'])
            ->name('dashboard');

        // Lessons
        Route::prefix('lessons')
            ->name('lessons.')
            ->controller(TeacherLessonController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('/lists', 'lessonList')->name('lists');
            Route::get('/create', 'createLesson')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{lesson}', 'showLesson')->name('show');
            Route::post('/process-payment', 'processPayment')->name('process-payment');

            // New routes for edit, publish, unpublish, delete
            Route::get('/{lesson}/edit', 'edit')->name('edit');
            Route::put('/{lesson}', 'update')->name('update');
            Route::patch('/{lesson}/publish', 'publish')->name('publish');
            Route::patch('/{lesson}/unpublish', 'unpublish')->name('unpublish');
            Route::delete('/{lesson}', 'destroy')->name('destroy');
        });


        // Settings
        Route::prefix('settings')
            ->name('settings.')
            ->controller(SettingsController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');

            // Sections
            Route::get('/sections', 'getSections')->name('sections');
            Route::post('/sections', 'storeSection')->name('sections.store');
            Route::put('/sections/{section}', 'updateSection')->name('sections.update');
            Route::delete('/sections/{section}', 'destroySection')->name('sections.destroy');

            // Levels
            Route::get('/levels', 'getLevels')->name('levels');
            Route::post('/levels', 'storeLevel')->name('levels.store');
            Route::put('/levels/{level}', 'updateLevel')->name('levels.update');
            Route::delete('/levels/{level}', 'destroyLevel')->name('levels.destroy');

            // Classes
            Route::get('/classes', 'getClasses')->name('classes');
            Route::post('/classes', 'storeClass')->name('classes.store');
            Route::put('/classes/{class}', 'updateClass')->name('classes.update');
            Route::delete('/classes/{class}', 'destroyClass')->name('classes.destroy');

            // Subjects
            Route::get('/subjects', 'getSubjects')->name('subjects');
            Route::post('/subjects', 'storeSubject')->name('subjects.store');
            Route::put('/subjects/{subject}', 'updateSubject')->name('subjects.update');
            Route::delete('/subjects/{subject}', 'destroySubject')->name('subjects.destroy');

            // Topics
            Route::get('/topics', 'getTopics')->name('topics');
            Route::post('/topics', 'storeTopic')->name('topics.store');
            Route::put('/topics/{topic}', 'updateTopic')->name('topics.update');
            Route::delete('/topics/{topic}', 'destroyTopic')->name('topics.destroy');
        });


        // Quiz Management Routes
        Route::prefix('quizzes')->name('quizzes.')->controller(QuizController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{examId}/add-questions', 'addQuestions')->name('add-questions');
            Route::post('/{examId}/save-questions', 'saveQuestions')->name('save-questions');
            Route::get('/{examId}/edit', 'edit')->name('edit');
            Route::put('/{examId}', 'update')->name('update');
            Route::delete('/{examId}', 'destroy')->name('destroy');
            Route::get('/{examId}/statistics', 'statistics')->name('statistics');
        });

    });

// Exam/Quiz Routes
Route::middleware(['AdminAuth'])->prefix('exams')->name('exams.')->controller(ExamController::class)->group(function () {
    Route::get('/create-lesson-quiz/{lessonId}', 'createLessonQuiz')->name('create-lesson-quiz');
    Route::post('/store', 'store')->name('store');
    Route::get('/{examId}/add-questions', 'addQuestions')->name('add-questions');
    Route::post('/{examId}/store-questions', 'storeQuestions')->name('store-questions');
    Route::get('/{examId}/take', 'takeQuiz')->name('take');
    Route::post('/{examId}/submit', 'submitQuiz')->name('submit');
    Route::get('/{examId}/results', 'showResults')->name('results');
    Route::get('/lesson/{lessonId}/quizzes', 'getLessonQuizzes')->name('lesson-quizzes');
    Route::get('/class/{classId}/quizzes', 'getClassQuizzes')->name('class-quizzes');
});