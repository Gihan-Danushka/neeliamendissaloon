<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes return JSON for mobile / external apps.
| They mirror web.php but send JSON when Accept: application/json is used.
|--------------------------------------------------------------------------
*/

// --- Public Auth ---

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);


// Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

//service
    Route::get('/services', [ServiceController::class, 'index']); // Get all services (optional, if needed)
    Route::post('/services', [ServiceController::class, 'store']); // Store new service
    Route::get('/services/{id}', [ServiceController::class, 'show']); // Show a specific service (optional)
    Route::put('/services/{id}', [ServiceController::class, 'update']); // Update a service
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']); // Delete a service

// --- Protected Routes ---
Route::middleware('auth:sanctum')->group(function () {

    // Current User
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    //Route::post('/login', [AuthController::class, 'login']);

    // Show a specific Users
    Route::get('/user/{id}', [AuthController::class, 'profileView']);

    // Update a specific Users
    Route::post('/user/{id}', [AuthController::class, 'update']);

    // Delete a specific Users
    Route::delete('/user/{id}', [AuthController::class, 'destroy']);

    // List all Users
    Route::get('/all-User', [AuthController::class, 'allUsers']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/services/categories', [DashboardController::class, 'service']);
    Route::post('/services/download', [DashboardController::class, 'download']);

    // Bills & Invoices
    Route::post('/bill/download', [BillController::class, 'download']);
    Route::post('/invoice/preview', [BillController::class, 'preview']);
    Route::post('/invoice/generate', [BillController::class, 'generate']);

    // Clients
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::patch('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'delete']);
    Route::post('/clients/search', [ClientController::class, 'search']);
    Route::get('/clients/{id}/profile', [ClientController::class, 'profile']);

    // Invoices
    Route::get('/invoices/{id}', [InvoiceController::class, 'index']);       // invoices for client
    Route::get('/invoices', [InvoiceController::class, 'index_view']);      // all invoices
    Route::get('/services/{id}', [InvoiceController::class, 'get_service']); // service by id
    Route::post('/invoices', [InvoiceController::class, 'store']);           // create invoice

    // History
    Route::get('/history', [HistoryController::class, 'index_view']);
    Route::post('/history/search', [HistoryController::class, 'search']);

    /* Route::get('/services', [ServiceController::class, 'index']); // Get all services (optional, if needed)
    Route::post('/services', [ServiceController::class, 'store']); // Store new service
    Route::get('/services/{id}', [ServiceController::class, 'show']); // Show a specific service (optional)
    Route::put('/services/{id}', [ServiceController::class, 'update']); // Update a service
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']); // Delete a service */

    // Staff
    Route::get('/staff', [StaffController::class, 'index']);
    Route::get('/staff/{id}', [StaffController::class, 'show']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

    /* // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']); */

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/counts', [BookingController::class, 'getBookingCounts']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    

    Route::get('/notifications', [NotificationController::class, 'getNotifications']);

});
