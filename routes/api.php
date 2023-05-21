<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Registration;
use App\Http\Controllers\QuestionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ------- Registration -------
Route::post('/registration', [Registration::class,'Registrations']);

// ------- Login -------



// ------- Feedback -------
Route::get('/feedbacks', [FeedbackController::class,'showFeedbacks']);
Route::post('/createFeedback', [FeedbackController::class,'createFeedback']);
Route::get('/showSingleFeedback/{id}', [FeedbackController::class,'showSingleFeedback']);
Route::post('/updateFeedback', [FeedbackController::class,'updateFeedback']);
Route::get('/deactivateFeedback/{id}', [FeedbackController::class,'deactivateFeedback']);
Route::get('/activateFeedback/{id}', [FeedbackController::class,'activateFeedback']);
Route::get('/removeSingleFeedback/{id}', [FeedbackController::class,'removeSingleFeedback']);
Route::get('/removeAllFeedbacks', [FeedbackController::class,'removeAllFeedback']);

// ------- Question -------
Route::get('/questions', [QuestionController::class,'showQuestions']);
Route::post('/createQuestion', [QuestionController::class,'createQuestion']);
Route::get('/showSingleQuestion/{id}', [QuestionController::class,'showSingleQuestion']);
Route::post('/updateQuestion', [QuestionController::class,'updateQuestion']);
Route::get('/deactivateQuestion/{id}', [QuestionController::class,'deactivateQuestion']);
Route::get('/activateQuestion/{id}', [QuestionController::class,'activateQuestion']);
Route::get('/removeSingleQuestion/{id}', [QuestionController::class,'removeSingleQuestion']);
Route::get('/removeAllQuestions', [QuestionController::class,'removeAllQuestion']);
