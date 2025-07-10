<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ListingController;
use App\Http\Controllers\API\TransactionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Detail loggin information user',
        'data' => Auth::user(),
    ]);
});

Route::resource('listings', ListingController::class)->only(['index', 'show']);

Route::controller(TransactionController::class)->group(function () {
    Route::get('mytransaction/{user:name}', 'index');
    Route::post('transaction/is-available', 'isAvailable');
    Route::post('transaction/create', 'store');
    Route::get('transaction/detail/{listing:slug}', 'show');
})->middleware(['auth:sanctum']);

Route::get('/test-token', function(){
    $user = User::first();
    return $user->createToken('test')->plainTextToken;
});

require __DIR__.'/auth.php';