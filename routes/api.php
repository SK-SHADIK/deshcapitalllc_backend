<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Registration;
use App\Http\Controllers\Login;

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ContactusController;
use App\Http\Middleware\APIAuth;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ------- Registration -------
Route::post('/registration', [Registration::class,'Registrations']);

// ------- Login -------
Route::post('/login', [Login::class,'login']);
Route::post('/logout', [Login::class,'logout'])->middleware('APIAuth');


// ------- Feedback -------
Route::get('/feedbacks', [FeedbackController::class,'showFeedbacks'])->middleware('APIAuth');
Route::post('/createFeedback', [FeedbackController::class,'createFeedback'])->middleware('APIAuth');
Route::get('/showSingleFeedback/{id}', [FeedbackController::class,'showSingleFeedback'])->middleware('APIAuth');
Route::post('/updateFeedback', [FeedbackController::class,'updateFeedback'])->middleware('APIAuth');
Route::get('/deactivateFeedback/{id}', [FeedbackController::class,'deactivateFeedback'])->middleware('APIAuth');
Route::get('/activateFeedback/{id}', [FeedbackController::class,'activateFeedback'])->middleware('APIAuth');
Route::get('/removeSingleFeedback/{id}', [FeedbackController::class,'removeSingleFeedback'])->middleware('APIAuth');
Route::get('/removeAllFeedbacks', [FeedbackController::class,'removeAllFeedback'])->middleware('APIAuth');
Route::post('/searchFeedbackByName', [FeedbackController::class,'searchFeedbackByName'])->middleware('APIAuth');


// ------- Question -------
Route::get('/questions', [QuestionController::class,'showQuestions'])->middleware('APIAuth');
Route::post('/createQuestion', [QuestionController::class,'createQuestion'])->middleware('APIAuth');
Route::get('/showSingleQuestion/{id}', [QuestionController::class,'showSingleQuestion'])->middleware('APIAuth');
Route::post('/updateQuestion', [QuestionController::class,'updateQuestion'])->middleware('APIAuth');
Route::get('/deactivateQuestion/{id}', [QuestionController::class,'deactivateQuestion'])->middleware('APIAuth');
Route::get('/activateQuestion/{id}', [QuestionController::class,'activateQuestion'])->middleware('APIAuth');
Route::get('/removeSingleQuestion/{id}', [QuestionController::class,'removeSingleQuestion'])->middleware('APIAuth');
Route::get('/removeAllQuestions', [QuestionController::class,'removeAllQuestion'])->middleware('APIAuth');
Route::post('/searchQuestionByName', [QuestionController::class,'searchQuestionByName'])->middleware('APIAuth');


// ------- Contactus -------
Route::get('/contactuss', [ContactusController::class,'showContactuss'])->middleware('APIAuth');
Route::post('/createContactus', [ContactusController::class,'createContactus'])->middleware('APIAuth');
Route::get('/showSingleContactus/{id}', [ContactusController::class,'showSingleContactus'])->middleware('APIAuth');
Route::post('/updateContactus', [ContactusController::class,'updateContactus'])->middleware('APIAuth');
Route::get('/deactivateContactus/{id}', [ContactusController::class,'deactivateContactus'])->middleware('APIAuth');
Route::get('/activateContactus/{id}', [ContactusController::class,'activateContactus'])->middleware('APIAuth');
Route::get('/removeSingleContactus/{id}', [ContactusController::class,'removeSingleContactus'])->middleware('APIAuth');
Route::get('/removeAllContactus', [ContactusController::class,'removeAllContactus'])->middleware('APIAuth');
Route::post('/searchContactusByName', [ContactusController::class,'searchContactusByName'])->middleware('APIAuth');