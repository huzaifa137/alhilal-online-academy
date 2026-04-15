// routes/admin.php
<?php

use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All admin routes are prefixed with /admin and named admin.*
| Middleware: auth, admin
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // =====================================================
    // DASHBOARD
    // =====================================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    
    // =====================================================
    // ACADEMIC STRUCTURE MANAGEMENT
    // =====================================================
    
    // Sections
    Route::resource('sections', SectionController::class);
    Route::post('sections/{section}/toggle-status', [SectionController::class, 'toggleStatus'])
         ->name('sections.toggle-status');
    
    // Levels
    Route::resource('levels', LevelController::class);
    Route::post('levels/{level}/toggle-status', [LevelController::class, 'toggleStatus'])
         ->name('levels.toggle-status');
    Route::get('sections/{section}/levels', [LevelController::class, 'bySection'])
         ->name('sections.levels');
    
    // Classes
    Route::resource('classes', ClassController::class);
    Route::post('classes/{class}/toggle-status', [ClassController::class, 'toggleStatus'])
         ->name('classes.toggle-status');
    Route::get('levels/{level}/classes', [ClassController::class, 'byLevel'])
         ->name('levels.classes');
    Route::post('classes/{class}/assign-teacher', [ClassController::class, 'assignTeacher'])
         ->name('classes.assign-teacher');
    Route::post('classes/{class}/enroll-students', [ClassController::class, 'enrollStudents'])
         ->name('classes.enroll-students');
    Route::get('classes/{class}/students', [ClassController::class, 'students'])
         ->name('classes.students');
    Route::get('classes/{class}/timetable', [ClassController::class, 'timetable'])
         ->name('classes.timetable');
    
    // =====================================================
    // SUBJECT MANAGEMENT
    // =====================================================
    Route::resource('subjects', SubjectController::class);
    Route::post('subjects/{subject}/toggle-status', [SubjectController::class, 'toggleStatus'])
         ->name('subjects.toggle-status');
    Route::post('subjects/assign-to-class', [SubjectController::class, 'assignToClass'])
         ->name('subjects.assign-to-class');
    Route::delete('subjects/{classSubject}/remove-from-class', [SubjectController::class, 'removeFromClass'])
         ->name('subjects.remove-from-class');
    Route::post('subjects/{classSubject}/assign-teacher', [SubjectController::class, 'assignTeacher'])
         ->name('subjects.assign-teacher');
    
    // =====================================================
    // TOPIC MANAGEMENT
    // =====================================================
    Route::resource('topics', TopicController::class);
    Route::post('topics/{topic}/toggle-status', [TopicController::class, 'toggleStatus'])
         ->name('topics.toggle-status');
    Route::get('subjects/{subject}/topics', [TopicController::class, 'bySubject'])
         ->name('subjects.topics');
    Route::get('classes/{class}/subjects/{subject}/topics', [TopicController::class, 'byClassAndSubject'])
         ->name('classes.subjects.topics');
    Route::post('topics/reorder', [TopicController::class, 'reorder'])
         ->name('topics.reorder');
    
    // =====================================================
    // LESSON MANAGEMENT
    // =====================================================
    Route::resource('lessons', LessonController::class);
    Route::post('lessons/{lesson}/toggle-publish', [LessonController::class, 'togglePublish'])
         ->name('lessons.toggle-publish');
    Route::get('topics/{topic}/lessons', [LessonController::class, 'byTopic'])
         ->name('topics.lessons');
    Route::post('lessons/{lesson}/resources', [LessonController::class, 'addResource'])
         ->name('lessons.add-resource');
    Route::delete('lessons/resources/{resource}', [LessonController::class, 'deleteResource'])
         ->name('lessons.delete-resource');
    Route::post('lessons/reorder', [LessonController::class, 'reorder'])
         ->name('lessons.reorder');
    Route::get('lessons/{lesson}/preview', [LessonController::class, 'preview'])
         ->name('lessons.preview');
    
    // =====================================================
    // EXAM MANAGEMENT
    // =====================================================
    Route::resource('exams', ExamController::class);
    Route::post('exams/{exam}/toggle-publish', [ExamController::class, 'togglePublish'])
         ->name('exams.toggle-publish');
    Route::post('exams/{exam}/close', [ExamController::class, 'close'])
         ->name('exams.close');
    Route::get('classes/{class}/exams', [ExamController::class, 'byClass'])
         ->name('classes.exams');
    Route::get('subjects/{subject}/exams', [ExamController::class, 'bySubject'])
         ->name('subjects.exams');
    
    // Questions Management
    Route::prefix('exams/{exam}/questions')->name('exams.questions.')->group(function () {
        Route::get('/', [ExamController::class, 'questions'])->name('index');
        Route::get('/create', [ExamController::class, 'createQuestion'])->name('create');
        Route::post('/', [ExamController::class, 'storeQuestion'])->name('store');
        Route::get('/{question}/edit', [ExamController::class, 'editQuestion'])->name('edit');
        Route::put('/{question}', [ExamController::class, 'updateQuestion'])->name('update');
        Route::delete('/{question}', [ExamController::class, 'deleteQuestion'])->name('destroy');
        Route::post('/reorder', [ExamController::class, 'reorderQuestions'])->name('reorder');
        Route::post('/import', [ExamController::class, 'importQuestions'])->name('import');
    });
    
    // Exam Results
    Route::get('exams/{exam}/results', [ExamController::class, 'results'])
         ->name('exams.results');
    Route::get('exams/{exam}/attempts/{attempt}', [ExamController::class, 'viewAttempt'])
         ->name('exams.attempts.show');
    Route::post('exams/attempts/{attempt}/grade', [ExamController::class, 'gradeAttempt'])
         ->name('exams.attempts.grade');
    Route::get('exams/{exam}/export-results', [ExamController::class, 'exportResults'])
         ->name('exams.export-results');
    
    // =====================================================
    // STUDENT PROGRESS TRACKING
    // =====================================================
    Route::prefix('progress')->name('progress.')->group(function () {
        Route::get('/', [ProgressController::class, 'index'])->name('index');
        Route::get('/students/{student}', [ProgressController::class, 'studentProgress'])
             ->name('student');
        Route::get('/classes/{class}', [ProgressController::class, 'classProgress'])
             ->name('class');
        Route::get('/subjects/{subject}', [ProgressController::class, 'subjectProgress'])
             ->name('subject');
        Route::get('/lessons/{lesson}', [ProgressController::class, 'lessonProgress'])
             ->name('lesson');
        Route::get('/export/{class}', [ProgressController::class, 'export'])
             ->name('export');
    });
    
    // =====================================================
    // CERTIFICATE MANAGEMENT
    // =====================================================
    Route::resource('certificates', CertificateController::class)->except(['edit', 'update']);
    Route::post('certificates/{certificate}/issue', [CertificateController::class, 'issue'])
         ->name('certificates.issue');
    Route::post('certificates/{certificate}/revoke', [CertificateController::class, 'revoke'])
         ->name('certificates.revoke');
    Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])
         ->name('certificates.download');
    Route::get('certificates/{certificate}/preview', [CertificateController::class, 'preview'])
         ->name('certificates.preview');
    Route::post('certificates/generate-bulk', [CertificateController::class, 'generateBulk'])
         ->name('certificates.generate-bulk');
    Route::get('certificates/templates', [CertificateController::class, 'templates'])
         ->name('certificates.templates');
    Route::post('certificates/templates', [CertificateController::class, 'storeTemplate'])
         ->name('certificates.templates.store');
    
    // =====================================================
    // ACADEMIC YEAR MANAGEMENT
    // =====================================================
    Route::resource('academic-years', AcademicYearController::class);
    Route::post('academic-years/{year}/set-current', [AcademicYearController::class, 'setCurrent'])
         ->name('academic-years.set-current');
    Route::post('academic-years/{year}/promote-students', [AcademicYearController::class, 'promoteStudents'])
         ->name('academic-years.promote');
    
    // =====================================================
    // REPORTS
    // =====================================================
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/academic', [ReportController::class, 'academic'])->name('academic');
        Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
        Route::get('/performance', [ReportController::class, 'performance'])->name('performance');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('/generate/{type}', [ReportController::class, 'generate'])->name('generate');
    });
    
});