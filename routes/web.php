<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PayrollController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return redirect()->route('login');
// });
// Display the login page (GET request)
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', function () {
    return view('auth.login'); // This should return the login view
})->name('login');

// Handle the login action (POST request)
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Handle the logout (GET request)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/services', [ServiceController::class, 'index'])->name('services');  // For displaying services

    Route::post('/services', [DashboardController::class, 'download'])->name('services.download');
    Route::post('/invoice/download', [BillController::class, 'download'])->name('invoice.download');


   


    Route::post('/invoice/preview', [BillController::class, 'preview'])->name('invoice.preview');




    Route::get('/client', [ClientController::class, 'index'])->name('client');
    Route::post('/client-store', [ClientController::class, 'store'])->name('client-store');
    Route::patch('/client/update/{id}', [ClientController::class, 'update'])->name('client-update');
    Route::delete('/client/delete/{id}', [ClientController::class, 'delete'])->name('client-delete');
    Route::post('/client/search', [ClientController::class, 'search'])->name('client-search');
    Route::get('/client/profile/{id}', [ClientController::class, 'profile'])->name('client-profile');

    Route::get('/invoice/{id}', [InvoiceController::class, 'index'])->name('invoice-client');
    Route::get('/invoice', [InvoiceController::class, 'index_view'])->name('invoice');
    Route::get('/get-service/{id}', [InvoiceController::class, 'get_service'])->name('get-service');

    Route::get('/history', [HistoryController::class, 'index_view'])->name('history');
    Route::post('/history-search', [HistoryController::class, 'search'])->name('history-search');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');


    // Route to show the create form for services
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');

// Route to store the service after the form submission
Route::post('/services/store', [ServiceController::class, 'store'])->name('pages.service');

// Route to show all staff members and their categories
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');


// Route to create a new staff member (handled by the store method)
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');

// Route to show the Create Staff form (the page where the form is displayed)
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');

// Route to show a specific staff member (view staff details)
Route::get('/staff/{id}', [StaffController::class, 'show'])->name('staff.show');

// Route to show the Edit Staff form (dedicated page)
Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');

// Route to update an existing staff member
Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');

// Route to delete a staff member
Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

// Route for updating categories of a staff member in bulk
Route::post('/staff/update-category', [StaffController::class, 'updateCategoryStaff'])->name('staff.updateCategoryStaff');

// Route for deleting categories of a staff member in bulk
Route::post('/staff/delete-category', [StaffController::class, 'deleteCategoryStaff'])->name('staff.deleteCategoryStaff');

// Payroll Routes
Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
Route::post('/payroll/process-all', [PayrollController::class, 'processAll'])->name('payroll.processAll');
Route::post('/payroll/{staff}/process', [PayrollController::class, 'processPayment'])->name('payroll.process');
    Route::get('/payroll/{payroll}/slip', [PayrollController::class, 'downloadSlip'])->name('payroll.slip');

Route::get('/bookings/create', [BookingController::class, 'webCreate'])->name('bookings.create');
Route::post('/bookings/store', [BookingController::class, 'webStore'])->name('bookings.store');


Route::get('/logout',[AuthController::class,'logout'])->name('logout');

// Pending Appointments actions (Dashboard)
Route::post('/appointments/{id}/approve', [DashboardController::class, 'approveAppointment'])->name('appointments.approve');

Route::post('/appointments/{id}/cancel', [DashboardController::class, 'cancelAppointment'])->name('appointments.cancel');

Route::post('/notifications/booking/{id}/remind', [DashboardController::class, 'sendReminder'])
    ->name('notifications.booking.remind');

    Route::get('/bookings', [BookingController::class, 'index']);



});
