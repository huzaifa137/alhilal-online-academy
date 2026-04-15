<?php

use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\SectionController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (if using Laravel Breeze/Jetstream)
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Redirect based on user role after login
// Route::get('/dashboard', function () {
//     $user = auth()->user();
    
//     if ($user->hasRole('admin')) {
//         return redirect()->route('admin.dashboard');
//     } elseif ($user->hasRole('teacher')) {
//         return redirect()->route('teacher.dashboard');
//     } elseif ($user->hasRole('student')) {
//         return redirect()->route('student.dashboard');
//     }
    
//     return redirect('/');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

// Route::middleware('web')->group(base_path('routes/admin.php'));
// Route::middleware('web')->group(base_path('routes/teacher.php'));
// Route::middleware('web')->group(base_path('routes/student.php'));

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

