<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Registration;
use App\Http\Controllers\Login;

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\BanglaFaqsController;
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
Route::post('/create-feedback', [FeedbackController::class,'createFeedback'])->middleware('APIAuth');
Route::get('/show-single-feedback/{id}', [FeedbackController::class,'showSingleFeedback'])->middleware('APIAuth');
Route::post('/update-feedback', [FeedbackController::class,'updateFeedback'])->middleware('APIAuth');
Route::get('/deactivate-feedback/{id}', [FeedbackController::class,'deactivateFeedback'])->middleware('APIAuth');
Route::get('/activate-feedback/{id}', [FeedbackController::class,'activateFeedback'])->middleware('APIAuth');
Route::get('/remove-single-feedback/{id}', [FeedbackController::class,'removeSingleFeedback'])->middleware('APIAuth');
Route::get('/remove-all-feedbacks', [FeedbackController::class,'removeAllFeedback'])->middleware('APIAuth');
Route::post('/search-feedback-by-name', [FeedbackController::class,'searchFeedbackByName'])->middleware('APIAuth');


// ------- Question -------
Route::get('/questions', [QuestionController::class,'showQuestions'])->middleware('APIAuth');
Route::post('/create-question', [QuestionController::class,'createQuestion'])->middleware('APIAuth');
Route::get('/show-single-question/{id}', [QuestionController::class,'showSingleQuestion'])->middleware('APIAuth');
Route::post('/update-question', [QuestionController::class,'updateQuestion'])->middleware('APIAuth');
Route::get('/deactivate-question/{id}', [QuestionController::class,'deactivateQuestion'])->middleware('APIAuth');
Route::get('/activate-question/{id}', [QuestionController::class,'activateQuestion'])->middleware('APIAuth');
Route::get('/remove-single-question/{id}', [QuestionController::class,'removeSingleQuestion'])->middleware('APIAuth');
Route::get('/remove-all-questions', [QuestionController::class,'removeAllQuestion'])->middleware('APIAuth');
Route::post('/search-question-by-name', [QuestionController::class,'searchQuestionByName'])->middleware('APIAuth');


// ------- FAQs -------
Route::get('/faqs', [FaqsController::class,'showFAQs'])->middleware('APIAuth');
Route::post('/create-faqs', [FaqsController::class,'createFAQs'])->middleware('APIAuth');
Route::get('/show-single-faqs/{id}', [FaqsController::class,'showSingleFAQs'])->middleware('APIAuth');
Route::post('/update-faqs', [FaqsController::class,'updateFAQs'])->middleware('APIAuth');
Route::get('/deactivate-faqs/{id}', [FaqsController::class,'deactivateFAQs'])->middleware('APIAuth');
Route::get('/activate-faqs/{id}', [FaqsController::class,'activateFAQs'])->middleware('APIAuth');
Route::get('/remove-single-faqs/{id}', [FaqsController::class,'removeSingleFAQs'])->middleware('APIAuth');
Route::get('/remove-all-faqs', [FaqsController::class,'removeAllFAQs'])->middleware('APIAuth');
Route::post('/search-faqs-by-name', [FaqsController::class,'searchFAQsByName'])->middleware('APIAuth');


// ------- Bangla FAQs -------
Route::get('/bangla-faqs', [BanglaFaqsController::class,'showBanglaFAQs'])->middleware('APIAuth');
Route::post('/create-bangla-faqs', [BanglaFaqsController::class,'createBanglaFAQs'])->middleware('APIAuth');
Route::get('/show-single-bangla-faqs/{id}', [BanglaFaqsController::class,'showSingleBanglaFAQs'])->middleware('APIAuth');
Route::post('/update-bangla-faqs', [BanglaFaqsController::class,'updateBanglaFAQs'])->middleware('APIAuth');
Route::get('/deactivate-bangla-faqs/{id}', [BanglaFaqsController::class,'deactivateBanglaFAQs'])->middleware('APIAuth');
Route::get('/activate-bangla-faqs/{id}', [BanglaFaqsController::class,'activateBanglaFAQs'])->middleware('APIAuth');
Route::get('/remove-single-bangla-faqs/{id}', [BanglaFaqsController::class,'removeSingleBanglaFAQs'])->middleware('APIAuth');
Route::get('/remove-all-bangla-faqs', [BanglaFaqsController::class,'removeAllBanglaFAQs'])->middleware('APIAuth');
Route::post('/search-bangla-faqs-by-name', [BanglaFaqsController::class,'searchBanglaFAQsByName'])->middleware('APIAuth');


// ------- Contactus -------
Route::get('/contactuss', [ContactusController::class,'showContactuss'])->middleware('APIAuth');
Route::post('/create-contactus', [ContactusController::class,'createContactus'])->middleware('APIAuth');
Route::get('/show-single-contactus/{id}', [ContactusController::class,'showSingleContactus'])->middleware('APIAuth');
Route::post('/update-contactus', [ContactusController::class,'updateContactus'])->middleware('APIAuth');
Route::get('/deactivate-contactus/{id}', [ContactusController::class,'deactivateContactus'])->middleware('APIAuth');
Route::get('/activate-contactus/{id}', [ContactusController::class,'activateContactus'])->middleware('APIAuth');
Route::get('/remove-single-contactus/{id}', [ContactusController::class,'removeSingleContactus'])->middleware('APIAuth');
Route::get('/remove-all-contactus', [ContactusController::class,'removeAllContactus'])->middleware('APIAuth');
Route::post('/search-contactus-by-name', [ContactusController::class,'searchContactusByName'])->middleware('APIAuth');