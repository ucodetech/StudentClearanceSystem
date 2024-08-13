<?php

use App\Livewire\Dashboard;
use App\Livewire\InitiateClearance;
use App\Livewire\ViewRequest;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth:web'])->group(function (){

    Route::get('/initiate-clearance', InitiateClearance::class)->middleware(['verified'])->name('initiate.clearance');
    Route::get('/view-desk/{desk}', ViewRequest::class)->middleware(['verified'])->name('view.desk');
});


require __DIR__.'/auth.php';
