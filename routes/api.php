<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Registration;
use App\Http\Controllers\Login;

use App\Http\Controllers\TokenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\LoanOfficerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\BanglaFaqsController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\AppointmentReasonController;
use App\Http\Controllers\TodaysMortgageRateController;

use App\Http\Controllers\LenderSearch\AmortizationController;
use App\Http\Controllers\LenderSearch\ChallengesController;
use App\Http\Controllers\LenderSearch\CreditScoreController;
use App\Http\Controllers\LenderSearch\ImmigStatusController;
use App\Http\Controllers\LenderSearch\IncomeDocController;
use App\Http\Controllers\LenderSearch\LoanController;
use App\Http\Controllers\LenderSearch\OccupancyController;
use App\Http\Controllers\LenderSearch\ProductTypeController;
use App\Http\Controllers\LenderSearch\PropertyTypeController;
use App\Http\Controllers\LenderSearch\StateController;
use App\Http\Controllers\LenderSearch\LenderSearchController;

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
Route::post('/registration', [Registration::class, 'Registrations']);

// ------- Login -------
Route::post('/login', [Login::class, 'login']);
Route::post('/logout', [Login::class, 'logout'])->middleware('APIAuth');

// ------- Token -------
Route::get('/tokens', [TokenController::class, 'showToken'])->middleware('APIAuth');
Route::get('/show-single-token/{id}', [TokenController::class, 'showSingleToken'])->middleware('APIAuth');
Route::get('/remove-single-token/{id}', [TokenController::class, 'removeSingleToken'])->middleware('APIAuth');
Route::get('/remove-all-token', [TokenController::class, 'removeAllToken'])->middleware('APIAuth');
Route::post('/search-token-by-name', [TokenController::class, 'searchTokenByName'])->middleware('APIAuth');

// ------- Admin -------
Route::get('/admins', [AdminController::class, 'showAdmins'])->middleware('APIAuth');
Route::post('/create-admin', [AdminController::class, 'createAdmin'])->middleware('APIAuth');
Route::get('/show-single-admin/{id}', [AdminController::class, 'showSingleAdmin'])->middleware('APIAuth');
Route::post('/update-admin', [AdminController::class, 'updateAdmin'])->middleware('APIAuth');
Route::get('/deactivate-admin/{id}', [AdminController::class, 'deactivateAdmin'])->middleware('APIAuth');
Route::get('/activate-admin/{id}', [AdminController::class, 'activateAdmin'])->middleware('APIAuth');
Route::get('/remove-single-admin/{id}', [AdminController::class, 'removeSingleAdmin'])->middleware('APIAuth');
Route::get('/remove-all-admin', [AdminController::class, 'removeAllAdmin'])->middleware('APIAuth');
Route::post('/search-admin-by-name', [AdminController::class, 'searchAdminByName'])->middleware('APIAuth');

// ------- Client -------
Route::get('/clients', [ClientsController::class, 'showClients'])->middleware('APIAuth');
Route::post('/create-client', [ClientsController::class, 'createClient'])->middleware('APIAuth');
Route::get('/show-single-client/{id}', [ClientsController::class, 'showSingleClient'])->middleware('APIAuth');
Route::post('/update-client', [ClientsController::class, 'updateClient'])->middleware('APIAuth');
Route::get('/deactivate-client/{id}', [ClientsController::class, 'deactivateClient'])->middleware('APIAuth');
Route::get('/activate-client/{id}', [ClientsController::class, 'activateClient'])->middleware('APIAuth');
Route::get('/remove-single-client/{id}', [ClientsController::class, 'removeSingleClient'])->middleware('APIAuth');
Route::get('/remove-all-clients', [ClientsController::class, 'removeAllClient'])->middleware('APIAuth');
Route::post('/search-client-by-name', [ClientsController::class, 'searchClientByName'])->middleware('APIAuth');

// ------- Loan Officer -------
Route::get('/loan-officer', [LoanOfficerController::class, 'showLoanOfficer'])->middleware('APIAuth');
Route::post('/create-loan-officer', [LoanOfficerController::class, 'createLoanOfficer'])->middleware('APIAuth');
Route::get('/show-single-loan-officer/{id}', [LoanOfficerController::class, 'showSingleLoanOfficer'])->middleware('APIAuth');
Route::post('/update-loan-officer', [LoanOfficerController::class, 'updateLoanOfficer'])->middleware('APIAuth');
Route::get('/deactivate-loan-officer/{id}', [LoanOfficerController::class, 'deactivateLoanOfficer'])->middleware('APIAuth');
Route::get('/activate-loan-officer/{id}', [LoanOfficerController::class, 'activateLoanOfficer'])->middleware('APIAuth');
Route::get('/remove-single-loan-officer/{id}', [LoanOfficerController::class, 'removeSingleLoanOfficer'])->middleware('APIAuth');
Route::get('/remove-all-loan-officer', [LoanOfficerController::class, 'removeAllLoanOfficer'])->middleware('APIAuth');
Route::post('/search-loan-officer-by-name', [LoanOfficerController::class, 'searchLoanOfficerByName'])->middleware('APIAuth');

// ------- Feedback -------
Route::get('/feedbacks', [FeedbackController::class, 'showFeedbacks'])->middleware('APIAuth');
Route::post('/create-feedback', [FeedbackController::class, 'createFeedback'])->middleware('APIAuth');
Route::get('/show-single-feedback/{id}', [FeedbackController::class, 'showSingleFeedback'])->middleware('APIAuth');
Route::post('/update-feedback', [FeedbackController::class, 'updateFeedback'])->middleware('APIAuth');
Route::get('/deactivate-feedback/{id}', [FeedbackController::class, 'deactivateFeedback'])->middleware('APIAuth');
Route::get('/activate-feedback/{id}', [FeedbackController::class, 'activateFeedback'])->middleware('APIAuth');
Route::get('/remove-single-feedback/{id}', [FeedbackController::class, 'removeSingleFeedback'])->middleware('APIAuth');
Route::get('/remove-all-feedbacks', [FeedbackController::class, 'removeAllFeedback'])->middleware('APIAuth');
Route::post('/search-feedback-by-name', [FeedbackController::class, 'searchFeedbackByName'])->middleware('APIAuth');

// ------- Question -------
Route::get('/questions', [QuestionController::class, 'showQuestions'])->middleware('APIAuth');
Route::post('/create-question', [QuestionController::class, 'createQuestion'])->middleware('APIAuth');
Route::get('/show-single-question/{id}', [QuestionController::class, 'showSingleQuestion'])->middleware('APIAuth');
Route::post('/update-question', [QuestionController::class, 'updateQuestion'])->middleware('APIAuth');
Route::get('/deactivate-question/{id}', [QuestionController::class, 'deactivateQuestion'])->middleware('APIAuth');
Route::get('/activate-question/{id}', [QuestionController::class, 'activateQuestion'])->middleware('APIAuth');
Route::get('/remove-single-question/{id}', [QuestionController::class, 'removeSingleQuestion'])->middleware('APIAuth');
Route::get('/remove-all-questions', [QuestionController::class, 'removeAllQuestion'])->middleware('APIAuth');
Route::post('/search-question-by-name', [QuestionController::class, 'searchQuestionByName'])->middleware('APIAuth');

// ------- FAQs -------
Route::get('/faqs', [FaqsController::class, 'showFAQs'])->middleware('APIAuth');
Route::post('/create-faqs', [FaqsController::class, 'createFAQs'])->middleware('APIAuth');
Route::get('/show-single-faqs/{id}', [FaqsController::class, 'showSingleFAQs'])->middleware('APIAuth');
Route::post('/update-faqs', [FaqsController::class, 'updateFAQs'])->middleware('APIAuth');
Route::get('/deactivate-faqs/{id}', [FaqsController::class, 'deactivateFAQs'])->middleware('APIAuth');
Route::get('/activate-faqs/{id}', [FaqsController::class, 'activateFAQs'])->middleware('APIAuth');
Route::get('/remove-single-faqs/{id}', [FaqsController::class, 'removeSingleFAQs'])->middleware('APIAuth');
Route::get('/remove-all-faqs', [FaqsController::class, 'removeAllFAQs'])->middleware('APIAuth');
Route::post('/search-faqs-by-name', [FaqsController::class, 'searchFAQsByName'])->middleware('APIAuth');

// ------- Bangla FAQs -------
Route::get('/bangla-faqs', [BanglaFaqsController::class, 'showBanglaFAQs'])->middleware('APIAuth');
Route::post('/create-bangla-faqs', [BanglaFaqsController::class, 'createBanglaFAQs'])->middleware('APIAuth');
Route::get('/show-single-bangla-faqs/{id}', [BanglaFaqsController::class, 'showSingleBanglaFAQs'])->middleware('APIAuth');
Route::post('/update-bangla-faqs', [BanglaFaqsController::class, 'updateBanglaFAQs'])->middleware('APIAuth');
Route::get('/deactivate-bangla-faqs/{id}', [BanglaFaqsController::class, 'deactivateBanglaFAQs'])->middleware('APIAuth');
Route::get('/activate-bangla-faqs/{id}', [BanglaFaqsController::class, 'activateBanglaFAQs'])->middleware('APIAuth');
Route::get('/remove-single-bangla-faqs/{id}', [BanglaFaqsController::class, 'removeSingleBanglaFAQs'])->middleware('APIAuth');
Route::get('/remove-all-bangla-faqs', [BanglaFaqsController::class, 'removeAllBanglaFAQs'])->middleware('APIAuth');
Route::post('/search-bangla-faqs-by-name', [BanglaFaqsController::class, 'searchBanglaFAQsByName'])->middleware('APIAuth');

// ------- Contactus -------
Route::get('/contactuss', [ContactusController::class, 'showContactuss'])->middleware('APIAuth');
Route::post('/create-contactus', [ContactusController::class, 'createContactus'])->middleware('APIAuth');
Route::get('/show-single-contactus/{id}', [ContactusController::class, 'showSingleContactus'])->middleware('APIAuth');
Route::post('/update-contactus', [ContactusController::class, 'updateContactus'])->middleware('APIAuth');
Route::get('/deactivate-contactus/{id}', [ContactusController::class, 'deactivateContactus'])->middleware('APIAuth');
Route::get('/activate-contactus/{id}', [ContactusController::class, 'activateContactus'])->middleware('APIAuth');
Route::get('/remove-single-contactus/{id}', [ContactusController::class, 'removeSingleContactus'])->middleware('APIAuth');
Route::get('/remove-all-contactus', [ContactusController::class, 'removeAllContactus'])->middleware('APIAuth');
Route::post('/search-contactus-by-name', [ContactusController::class, 'searchContactusByName'])->middleware('APIAuth');

// ------- Todays Mortgage Rate -------
Route::get('/todays-mortgage-rates', [TodaysMortgageRateController::class, 'showTodaysMortgageRates'])->middleware('APIAuth');
Route::post('/create-todays-mortgage-rate', [TodaysMortgageRateController::class, 'createTodaysMortgageRate'])->middleware('APIAuth');
Route::get('/show-single-todays-mortgage-rate/{id}', [TodaysMortgageRateController::class, 'showSingleTodaysMortgageRate'])->middleware('APIAuth');
Route::post('/update-todays-mortgage-rate', [TodaysMortgageRateController::class, 'updateTodaysMortgageRate'])->middleware('APIAuth');
Route::get('/deactivate-todays-mortgage-rate/{id}', [TodaysMortgageRateController::class, 'deactivateTodaysMortgageRate'])->middleware('APIAuth');
Route::get('/activate-todays-mortgage-rate/{id}', [TodaysMortgageRateController::class, 'activateTodaysMortgageRate'])->middleware('APIAuth');
Route::get('/remove-single-todays-mortgage-rate/{id}', [TodaysMortgageRateController::class, 'removeSingleTodaysMortgageRate'])->middleware('APIAuth');
Route::get('/remove-all-todays-mortgage-rate', [TodaysMortgageRateController::class, 'removeAllTodaysMortgageRate'])->middleware('APIAuth');
Route::post('/search-todays-mortgage-rate-by-name', [TodaysMortgageRateController::class, 'searchTodaysMortgageRateByName'])->middleware('APIAuth');

// ------- Appointment Reason -------
Route::get('/appointment-reasons', [AppointmentReasonController::class, 'showAppointmentReasons'])->middleware('APIAuth');
Route::post('/create-appointment-reason', [AppointmentReasonController::class, 'createAppointmentReason'])->middleware('APIAuth');
Route::get('/show-single-appointment-reason/{id}', [AppointmentReasonController::class, 'showSingleAppointmentReason'])->middleware('APIAuth');
Route::post('/update-appointment-reason', [AppointmentReasonController::class, 'updateAppointmentReason'])->middleware('APIAuth');
Route::get('/deactivate-appointment-reason/{id}', [AppointmentReasonController::class, 'deactivateAppointmentReason'])->middleware('APIAuth');
Route::get('/activate-appointment-reason/{id}', [AppointmentReasonController::class, 'activateAppointmentReason'])->middleware('APIAuth');
Route::get('/remove-single-appointment-reason/{id}', [AppointmentReasonController::class, 'removeSingleAppointmentReason'])->middleware('APIAuth');
Route::get('/remove-all-appointment-reason', [AppointmentReasonController::class, 'removeAllAppointmentReason'])->middleware('APIAuth');
Route::post('/search-appointment-reason-by-name', [AppointmentReasonController::class, 'searchAppointmentReasonByName'])->middleware('APIAuth');

// ------- Appointment -------
Route::get('/appointments', [AppointmentsController::class, 'showAppointments'])->middleware('APIAuth');
Route::post('/create-appointment', [AppointmentsController::class, 'createAppointment'])->middleware('APIAuth');
Route::get('/show-single-appointment/{id}', [AppointmentsController::class, 'showSingleAppointment'])->middleware('APIAuth');
Route::post('/update-appointment', [AppointmentsController::class, 'updateAppointment'])->middleware('APIAuth');
Route::get('/deactivate-appointment/{id}', [AppointmentsController::class, 'deactivateAppointment'])->middleware('APIAuth');
Route::get('/activate-appointment/{id}', [AppointmentsController::class, 'activateAppointment'])->middleware('APIAuth');
Route::get('/remove-single-appointment/{id}', [AppointmentsController::class, 'removeSingleAppointment'])->middleware('APIAuth');
Route::get('/remove-all-appointment', [AppointmentsController::class, 'removeAllAppointment'])->middleware('APIAuth');
Route::post('/search-appointment-by-name', [AppointmentsController::class, 'searchAppointmentByName'])->middleware('APIAuth');

// ------- Lender Search -------

// ------- Amortization -------
Route::get('/amortizations', [AmortizationController::class, 'showAmortizations'])->middleware('APIAuth');
Route::post('/create-amortization', [AmortizationController::class, 'createAmortization'])->middleware('APIAuth');
Route::get('/show-single-amortization/{id}', [AmortizationController::class, 'showSingleAmortization'])->middleware('APIAuth');
Route::post('/update-amortization', [AmortizationController::class, 'updateAmortization'])->middleware('APIAuth');
Route::get('/deactivate-amortization/{id}', [AmortizationController::class, 'deactivateAmortization'])->middleware('APIAuth');
Route::get('/activate-amortization/{id}', [AmortizationController::class, 'activateAmortization'])->middleware('APIAuth');
Route::get('/remove-single-amortization/{id}', [AmortizationController::class, 'removeSingleAmortization'])->middleware('APIAuth');
Route::get('/remove-all-amortization', [AmortizationController::class, 'removeAllAmortization'])->middleware('APIAuth');
Route::post('/search-amortization-by-name', [AmortizationController::class, 'searchAmortizationByName'])->middleware('APIAuth');

// ------- Challenges -------
Route::get('/challenges', [ChallengesController::class, 'showChallenges'])->middleware('APIAuth');
Route::post('/create-challenges', [ChallengesController::class, 'createChallenges'])->middleware('APIAuth');
Route::get('/show-single-challenges/{id}', [ChallengesController::class, 'showSingleChallenges'])->middleware('APIAuth');
Route::post('/update-challenges', [ChallengesController::class, 'updateChallenges'])->middleware('APIAuth');
Route::get('/deactivate-challenges/{id}', [ChallengesController::class, 'deactivateChallenges'])->middleware('APIAuth');
Route::get('/activate-challenges/{id}', [ChallengesController::class, 'activateChallenges'])->middleware('APIAuth');
Route::get('/remove-single-challenges/{id}', [ChallengesController::class, 'removeSingleChallenges'])->middleware('APIAuth');
Route::get('/remove-all-challenges', [ChallengesController::class, 'removeAllChallenges'])->middleware('APIAuth');
Route::post('/search-challenges-by-name', [ChallengesController::class, 'searchChallengesByName'])->middleware('APIAuth');

// ------- Credit Score -------
Route::get('/credit-score', [CreditScoreController::class, 'showCreditScore'])->middleware('APIAuth');
Route::post('/create-credit-score', [CreditScoreController::class, 'createCreditScore'])->middleware('APIAuth');
Route::get('/show-single-credit-score/{id}', [CreditScoreController::class, 'showSingleCreditScore'])->middleware('APIAuth');
Route::post('/update-credit-score', [CreditScoreController::class, 'updateCreditScore'])->middleware('APIAuth');
Route::get('/deactivate-credit-score/{id}', [CreditScoreController::class, 'deactivateCreditScore'])->middleware('APIAuth');
Route::get('/activate-credit-score/{id}', [CreditScoreController::class, 'activateCreditScore'])->middleware('APIAuth');
Route::get('/remove-single-credit-score/{id}', [CreditScoreController::class, 'removeSingleCreditScore'])->middleware('APIAuth');
Route::get('/remove-all-credit-score', [CreditScoreController::class, 'removeAllCreditScore'])->middleware('APIAuth');
Route::post('/search-credit-score-by-name', [CreditScoreController::class, 'searchCreditScoreByName'])->middleware('APIAuth');

// ------- Immig Status -------
Route::get('/immig-status', [ImmigStatusController::class, 'showImmigStatus'])->middleware('APIAuth');
Route::post('/create-immig-status', [ImmigStatusController::class, 'createImmigStatus'])->middleware('APIAuth');
Route::get('/show-single-immig-status/{id}', [ImmigStatusController::class, 'showSingleImmigStatus'])->middleware('APIAuth');
Route::post('/update-immig-status', [ImmigStatusController::class, 'updateImmigStatus'])->middleware('APIAuth');
Route::get('/deactivate-immig-status/{id}', [ImmigStatusController::class, 'deactivateImmigStatus'])->middleware('APIAuth');
Route::get('/activate-immig-status/{id}', [ImmigStatusController::class, 'activateImmigStatus'])->middleware('APIAuth');
Route::get('/remove-single-immig-status/{id}', [ImmigStatusController::class, 'removeSingleImmigStatus'])->middleware('APIAuth');
Route::get('/remove-all-immig-status', [ImmigStatusController::class, 'removeAllImmigStatus'])->middleware('APIAuth');
Route::post('/search-immig-status-by-name', [ImmigStatusController::class, 'searchImmigStatusByName'])->middleware('APIAuth');

// ------- Income Doc -------
Route::get('/income-docs', [IncomeDocController::class, 'showIncomeDocs'])->middleware('APIAuth');
Route::post('/create-income-doc', [IncomeDocController::class, 'createIncomeDoc'])->middleware('APIAuth');
Route::get('/show-single-income-doc/{id}', [IncomeDocController::class, 'showSingleIncomeDoc'])->middleware('APIAuth');
Route::post('/update-income-doc', [IncomeDocController::class, 'updateIncomeDoc'])->middleware('APIAuth');
Route::get('/deactivate-income-doc/{id}', [IncomeDocController::class, 'deactivateIncomeDoc'])->middleware('APIAuth');
Route::get('/activate-income-doc/{id}', [IncomeDocController::class, 'activateIncomeDoc'])->middleware('APIAuth');
Route::get('/remove-single-income-doc/{id}', [IncomeDocController::class, 'removeSingleIncomeDoc'])->middleware('APIAuth');
Route::get('/remove-all-income-doc', [IncomeDocController::class, 'removeAllIncomeDoc'])->middleware('APIAuth');
Route::post('/search-income-doc-by-name', [IncomeDocController::class, 'searchIncomeDocByName'])->middleware('APIAuth');

// ------- Loan -------
Route::get('/loans', [LoanController::class, 'showLoans'])->middleware('APIAuth');
Route::post('/create-loan', [LoanController::class, 'createLoan'])->middleware('APIAuth');
Route::get('/show-single-loan/{id}', [LoanController::class, 'showSingleLoan'])->middleware('APIAuth');
Route::post('/update-loan', [LoanController::class, 'updateLoan'])->middleware('APIAuth');
Route::get('/deactivate-loan/{id}', [LoanController::class, 'deactivateLoan'])->middleware('APIAuth');
Route::get('/activate-loan/{id}', [LoanController::class, 'activateLoan'])->middleware('APIAuth');
Route::get('/remove-single-loan/{id}', [LoanController::class, 'removeSingleLoan'])->middleware('APIAuth');
Route::get('/remove-all-loan', [LoanController::class, 'removeAllLoan'])->middleware('APIAuth');
Route::post('/search-loan-by-name', [LoanController::class, 'searchLoanByName'])->middleware('APIAuth');

// ------- Occupancy -------
Route::get('/occupancy', [OccupancyController::class, 'showOccupancy'])->middleware('APIAuth');
Route::post('/create-occupancy', [OccupancyController::class, 'createOccupancy'])->middleware('APIAuth');
Route::get('/show-single-occupancy/{id}', [OccupancyController::class, 'showSingleOccupancy'])->middleware('APIAuth');
Route::post('/update-occupancy', [OccupancyController::class, 'updateOccupancy'])->middleware('APIAuth');
Route::get('/deactivate-occupancy/{id}', [OccupancyController::class, 'deactivateOccupancy'])->middleware('APIAuth');
Route::get('/activate-occupancy/{id}', [OccupancyController::class, 'activateOccupancy'])->middleware('APIAuth');
Route::get('/remove-single-occupancy/{id}', [OccupancyController::class, 'removeSingleOccupancy'])->middleware('APIAuth');
Route::get('/remove-all-occupancy', [OccupancyController::class, 'removeAllOccupancy'])->middleware('APIAuth');
Route::post('/search-occupancy-by-name', [OccupancyController::class, 'searchOccupancyByName'])->middleware('APIAuth');

// ------- Product Type -------
Route::get('/product-type', [ProductTypeController::class, 'showProductType'])->middleware('APIAuth');
Route::post('/create-product-type', [ProductTypeController::class, 'createProductType'])->middleware('APIAuth');
Route::get('/show-single-product-type/{id}', [ProductTypeController::class, 'showSingleProductType'])->middleware('APIAuth');
Route::post('/update-product-type', [ProductTypeController::class, 'updateProductType'])->middleware('APIAuth');
Route::get('/deactivate-product-type/{id}', [ProductTypeController::class, 'deactivateProductType'])->middleware('APIAuth');
Route::get('/activate-product-type/{id}', [ProductTypeController::class, 'activateProductType'])->middleware('APIAuth');
Route::get('/remove-single-product-type/{id}', [ProductTypeController::class, 'removeSingleProductType'])->middleware('APIAuth');
Route::get('/remove-all-product-type', [ProductTypeController::class, 'removeAllProductType'])->middleware('APIAuth');
Route::post('/search-product-type-by-name', [ProductTypeController::class, 'searchProductTypeByName'])->middleware('APIAuth');

// ------- Property Type -------
Route::get('/property-type', [PropertyTypeController::class, 'showPropertyType'])->middleware('APIAuth');
Route::post('/create-property-type', [PropertyTypeController::class, 'createPropertyType'])->middleware('APIAuth');
Route::get('/show-single-property-type/{id}', [PropertyTypeController::class, 'showSinglePropertyType'])->middleware('APIAuth');
Route::post('/update-property-type', [PropertyTypeController::class, 'updatePropertyType'])->middleware('APIAuth');
Route::get('/deactivate-property-type/{id}', [PropertyTypeController::class, 'deactivatePropertyType'])->middleware('APIAuth');
Route::get('/activate-property-type/{id}', [PropertyTypeController::class, 'activatePropertyType'])->middleware('APIAuth');
Route::get('/remove-single-property-type/{id}', [PropertyTypeController::class, 'removeSinglePropertyType'])->middleware('APIAuth');
Route::get('/remove-all-property-type', [PropertyTypeController::class, 'removeAllPropertyType'])->middleware('APIAuth');
Route::post('/search-property-type-by-name', [PropertyTypeController::class, 'searchPropertyTypeByName'])->middleware('APIAuth');

// ------- State -------
Route::get('/states', [StateController::class, 'showStates'])->middleware('APIAuth');
Route::post('/create-state', [StateController::class, 'createState'])->middleware('APIAuth');
Route::get('/show-single-state/{id}', [StateController::class, 'showSingleState'])->middleware('APIAuth');
Route::post('/update-state', [StateController::class, 'updateState'])->middleware('APIAuth');
Route::get('/deactivate-state/{id}', [StateController::class, 'deactivateState'])->middleware('APIAuth');
Route::get('/activate-state/{id}', [StateController::class, 'activateState'])->middleware('APIAuth');
Route::get('/remove-single-state/{id}', [StateController::class, 'removeSingleState'])->middleware('APIAuth');
Route::get('/remove-all-state', [StateController::class, 'removeAllState'])->middleware('APIAuth');
Route::post('/search-state-by-name', [StateController::class, 'searchStateByName'])->middleware('APIAuth');

// ------- Lender Search -------
Route::get('/lender-search', [LenderSearchController::class, 'showLenderSearch'])->middleware('APIAuth');
Route::post('/create-lender-search', [LenderSearchController::class, 'createLenderSearch'])->middleware('APIAuth');
Route::get('/show-single-lender-search/{id}', [LenderSearchController::class, 'showSingleLenderSearch'])->middleware('APIAuth');
Route::post('/update-lender-search', [LenderSearchController::class, 'updateLenderSearch'])->middleware('APIAuth');
Route::get('/deactivate-lender-search/{id}', [LenderSearchController::class, 'deactivateLenderSearch'])->middleware('APIAuth');
Route::get('/activate-lender-search/{id}', [LenderSearchController::class, 'activateLenderSearch'])->middleware('APIAuth');
Route::get('/remove-single-lender-search/{id}', [LenderSearchController::class, 'removeSingleLenderSearch'])->middleware('APIAuth');
Route::get('/remove-all-lender-search', [LenderSearchController::class, 'removeAllLenderSearch'])->middleware('APIAuth');
Route::post('/search-lender-search-by-name', [LenderSearchController::class, 'searchLenderSearchByName'])->middleware('APIAuth');
Route::get('/search-lender', [LenderSearchController::class, 'searchLender'])->middleware('APIAuth');