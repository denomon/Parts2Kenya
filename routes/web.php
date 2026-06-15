<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\ShipmentBatchController;
use App\Http\Controllers\Admin\ShipmentTrackingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PartRequestController as AdminPartRequestController;

Route::get('/', fn () => view('public.home'))->name('home');
Route::get('/request-part', [PartRequestController::class, 'create'])->name('part-requests.create');
Route::post('/request-part', [PartRequestController::class, 'store'])->name('part-requests.store');
Route::get('/request-submitted/{partRequest}', [PartRequestController::class, 'submitted'])->name('part-requests.submitted');
Route::get('/track', [TrackingController::class, 'form'])->name('tracking.form');
Route::post('/track', [TrackingController::class, 'lookup'])->name('tracking.lookup');

Route::get('/quote/{quote:public_token}', [PaymentController::class, 'showQuote'])->name('quotes.public.show');
Route::post('/quote/{quote:public_token}/accept', [PaymentController::class, 'acceptQuote'])->name('quotes.public.accept');
Route::get('/payment/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel/{order}', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/stripe/webhook', StripeWebhookController::class)->name('stripe.webhook');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
    Route::resource('quotes', QuoteController::class);
    Route::post('quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');
    Route::post('quotes/{quote}/items', [QuoteController::class, 'storeItem'])->name('quotes.items.store');
    Route::delete('quote-items/{quoteItem}', [QuoteController::class, 'destroyItem'])->name('quotes.items.destroy');
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::resource('shipment-batches', ShipmentBatchController::class);
    Route::post('shipment-batches/{shipmentBatch}/orders', [ShipmentBatchController::class, 'attachOrder'])->name('shipment-batches.orders.attach');
    Route::delete('shipment-batches/{shipmentBatch}/orders/{order}', [ShipmentBatchController::class, 'detachOrder'])->name('shipment-batches.orders.detach');
    Route::post('orders/{order}/tracking', [ShipmentTrackingController::class, 'store'])->name('orders.tracking.store');
    Route::get('part-requests/{partRequest}', [AdminPartRequestController::class, 'show'])
        ->name('part-requests.show');
});
