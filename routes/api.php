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
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\AppointmentReasonController;

use App\Http\Controllers\LenderSearch\Amortization;
use App\Http\Controllers\LenderSearch\Challenges;
use App\Http\Controllers\LenderSearch\CreditScore;

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


// ------- Appointment Reason -------
Route::get('/appointment-reasons', [AppointmentReasonController::class,'showAppointmentReasons'])->middleware('APIAuth');
Route::post('/create-appointment-reason', [AppointmentReasonController::class,'createAppointmentReason'])->middleware('APIAuth');
Route::get('/show-single-appointment-reason/{id}', [AppointmentReasonController::class,'showSingleAppointmentReason'])->middleware('APIAuth');
Route::post('/update-appointment-reason', [AppointmentReasonController::class,'updateAppointmentReason'])->middleware('APIAuth');
Route::get('/deactivate-appointment-reason/{id}', [AppointmentReasonController::class,'deactivateAppointmentReason'])->middleware('APIAuth');
Route::get('/activate-appointment-reason/{id}', [AppointmentReasonController::class,'activateAppointmentReason'])->middleware('APIAuth');
Route::get('/remove-single-appointment-reason/{id}', [AppointmentReasonController::class,'removeSingleAppointmentReason'])->middleware('APIAuth');
Route::get('/remove-all-appointment-reason', [AppointmentReasonController::class,'removeAllAppointmentReason'])->middleware('APIAuth');
Route::post('/search-appointment-reason-by-name', [AppointmentReasonController::class,'searchAppointmentReasonByName'])->middleware('APIAuth');


// ------- Appointment -------
Route::get('/appointments', [AppointmentsController::class,'showAppointments'])->middleware('APIAuth');
Route::post('/create-appointment', [AppointmentsController::class,'createAppointment'])->middleware('APIAuth');
Route::get('/show-single-appointment/{id}', [AppointmentsController::class,'showSingleAppointment'])->middleware('APIAuth');
Route::post('/update-appointment', [AppointmentsController::class,'updateAppointment'])->middleware('APIAuth');
Route::get('/deactivate-appointment/{id}', [AppointmentsController::class,'deactivateAppointment'])->middleware('APIAuth');
Route::get('/activate-appointment/{id}', [AppointmentsController::class,'activateAppointment'])->middleware('APIAuth');
Route::get('/remove-single-appointment/{id}', [AppointmentsController::class,'removeSingleAppointment'])->middleware('APIAuth');
Route::get('/remove-all-appointment', [AppointmentsController::class,'removeAllAppointment'])->middleware('APIAuth');
Route::post('/search-appointment-by-name', [AppointmentsController::class,'searchAppointmentByName'])->middleware('APIAuth');


// ------- Lender Search -------


// ------- Amortization -------
Route::get('/amortizations', [Amortization::class,'showAmortizations'])->middleware('APIAuth');
Route::post('/create-amortization', [Amortization::class,'createAmortization'])->middleware('APIAuth');
Route::get('/show-single-amortization/{id}', [Amortization::class,'showSingleAmortization'])->middleware('APIAuth');
Route::post('/update-amortization', [Amortization::class,'updateAmortization'])->middleware('APIAuth');
Route::get('/deactivate-amortization/{id}', [Amortization::class,'deactivateAmortization'])->middleware('APIAuth');
Route::get('/activate-amortization/{id}', [Amortization::class,'activateAmortization'])->middleware('APIAuth');
Route::get('/remove-single-amortization/{id}', [Amortization::class,'removeSingleAmortization'])->middleware('APIAuth');
Route::get('/remove-all-amortization', [Amortization::class,'removeAllAmortization'])->middleware('APIAuth');
Route::post('/search-amortization-by-name', [Amortization::class,'searchAmortizationByName'])->middleware('APIAuth');


// ------- Challenges -------
Route::get('/challenges', [Challenges::class,'showChallenges'])->middleware('APIAuth');
Route::post('/create-challenges', [Challenges::class,'createChallenges'])->middleware('APIAuth');
Route::get('/show-single-challenges/{id}', [Challenges::class,'showSingleChallenges'])->middleware('APIAuth');
Route::post('/update-challenges', [Challenges::class,'updateChallenges'])->middleware('APIAuth');
Route::get('/deactivate-challenges/{id}', [Challenges::class,'deactivateChallenges'])->middleware('APIAuth');
Route::get('/activate-challenges/{id}', [Challenges::class,'activateChallenges'])->middleware('APIAuth');
Route::get('/remove-single-challenges/{id}', [Challenges::class,'removeSingleChallenges'])->middleware('APIAuth');
Route::get('/remove-all-challenges', [Challenges::class,'removeAllChallenges'])->middleware('APIAuth');
Route::post('/search-challenges-by-name', [Challenges::class,'searchChallengesByName'])->middleware('APIAuth');


// ------- Credit Score -------
Route::get('/credit-score', [CreditScore::class,'showCreditScore'])->middleware('APIAuth');
Route::post('/create-credit-score', [CreditScore::class,'createCreditScore'])->middleware('APIAuth');
Route::get('/show-single-credit-score/{id}', [CreditScore::class,'showSingleCreditScore'])->middleware('APIAuth');
Route::post('/update-credit-score', [CreditScore::class,'updateCreditScore'])->middleware('APIAuth');
Route::get('/deactivate-credit-score/{id}', [CreditScore::class,'deactivateCreditScore'])->middleware('APIAuth');
Route::get('/activate-credit-score/{id}', [CreditScore::class,'activateCreditScore'])->middleware('APIAuth');
Route::get('/remove-single-credit-score/{id}', [CreditScore::class,'removeSingleCreditScore'])->middleware('APIAuth');
Route::get('/remove-all-credit-score', [CreditScore::class,'removeAllCreditScore'])->middleware('APIAuth');
Route::post('/search-credit-score-by-name', [CreditScore::class,'searchCreditScoreByName'])->middleware('APIAuth');