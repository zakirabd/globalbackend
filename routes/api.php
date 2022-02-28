<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\loginController;

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ExamChildQuestionsController;
use App\Http\Controllers\ExamParentQuestionsController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeacherEnrollController;
use App\Http\Controllers\UnitControllers;
use App\Http\Controllers\UserController;
use App\Models\ExamParentQuestions;
use App\Models\Exams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () {
    Route::resource('role', RoleController::class);
    Route::post('/login', [loginController::class, 'login']);

    Route::group(['middleware'=> ['auth:sanctum']], function(){
        Route::post('/logout', [loginController::class, 'logOut']);
        Route::resource('users', UserController::class);
        Route::get('user', [UserController::class, 'getCurrentUser']);
        Route::post('student-lock/{id}', [UserController::class, 'lockUnlockStudent']);

        Route::resource('categories', CategoriesController::class);
        Route::resource('courses', CoursesController::class);
        Route::resource('units', UnitControllers::class);
        Route::resource('lessons', LessonsController::class);
        Route::resource('exams', ExamsController::class);
        Route::resource('exams-parent-questions', ExamParentQuestionsController::class);
        Route::resource('exams-child-questions', ExamChildQuestionsController::class);
        Route::resource('teacher-enroll', TeacherEnrollController::class);

        Route::resource('messages', MessagesController::class);
        Route::get('messages-students', [MessagesController::class, 'getStudentsList']);

        Route::resource('schedules', ScheduleController::class);
        Route::get('messages-count', [MessagesController::class, 'getMessageCount']);
        Route::post('reset-message', [MessagesController::class, 'resetMessages']);
        Route::post('reset-new-message', [MessagesController::class, 'resetNewMessages']);
        Route::get('public-level-exams', [ExamsController::class, 'getLevelExams']);
        Route::post('level-exams-submit', [ExamsController::class, 'submitExams']);
        Route::post('set-password', [UserController::class, 'setPassword']);
        Route::get('exam-result', [ExamsController::class, 'getExamResults']);
        Route::post('add-personal-info', [UserController::class, 'addStudentPersonalInformation']);
        Route::get('get-personal-info', [UserController::class, 'getStudentPersonalInformation']);
        // addStudentPersonalInformation

        Route::resource('image', ImageController::class);
        // reset-new-message
    });
    Route::post('register-as-student', [UserController::class, 'registerStudent']);
    Route::get('public-categories', [CategoriesController::class, 'index']);
    Route::get('public-categories/{id}', [CategoriesController::class, 'getCategoryById']);
    Route::get('public-courses/{id}', [CoursesController::class, 'getCoursesById']);
    Route::get('public-other-courses/{id}', [CoursesController::class, 'getOtherCourses']);
    // public-courses
    Route::get('/login_social/{provider}', [AuthController::class,'redirectToProvider']);
    Route::get('/login_social/{provider}/callback', [AuthController::class,'handleProviderCallback']);
});
