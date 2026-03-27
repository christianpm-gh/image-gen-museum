<?php

use App\Http\Controllers\MemoryGenerationController;
use App\Http\Controllers\MuseumController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('dashboard', 'museo')->name('dashboard');

    Route::get('museo', [MuseumController::class, 'index'])->name('museum.index');
    Route::get('salas/{museumRoom:slug}', [MuseumController::class, 'showRoom'])->name('museum.rooms.show');
    Route::get('exposiciones/{exhibition:slug}', [MuseumController::class, 'showExhibition'])->name('museum.exhibitions.show');

    Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/comprar', [OrderController::class, 'create'])->name('tickets.purchase');
    Route::post('tickets/comprar', [OrderController::class, 'store'])->name('orders.store');
    Route::get('tickets/{ticket:uuid}', [TicketController::class, 'show'])->name('tickets.show');

    Route::get('recuerdos', [MemoryGenerationController::class, 'index'])->name('memories.index');
    Route::get('recuerdos/{memoryGeneration}', [MemoryGenerationController::class, 'show'])->name('memories.show');
    Route::get('tickets/{ticket:uuid}/recuerdo', [MemoryGenerationController::class, 'create'])
        ->middleware('signed')
        ->name('memories.create');
    Route::post('tickets/{ticket:uuid}/recuerdo', [MemoryGenerationController::class, 'store'])->name('memories.store');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
});

require __DIR__.'/auth.php';
