<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\TripBookingController;
use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TripController; // Dodajemy kontroler dla wycieczek

// Trasa do przechowywania opinii
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Trasa do obsługi zapisania danych osobowych i rezerwacji wycieczki
Route::post('/personal-data', [PersonalDataController::class, 'store'])->name('personal_data.store');
Route::post('/trips/book', [AgencyController::class, 'bookTrip'])->name('trips.book');

// Strona główna z listą wycieczek
Route::get('/', [AgencyController::class, 'index'])->name('home');

// Szczegóły wycieczki
Route::get('/trips/{id}', [AgencyController::class, 'show'])->name('trips.show');

// Zakładka z pakietami
Route::get('/packages', [AgencyController::class, 'packages'])->name('packages');

// Trasa do szczegółów rezerwacji w profilu
Route::get('/profile/trips/{booking}/details', [ProfileController::class, 'tripDetails'])->name('profile.trips.details');

// Nowe trasy dla pracowników (CRUD dla wycieczek)
Route::middleware(['auth', 'employee'])->group(function () {
    // Możesz również zdefiniować te trasy osobno, ale użycie resource zapewnia porządek
    Route::get('/trips/create', [AgencyController::class, 'create'])->name('trips.create'); // Formularz tworzenia wycieczki
    Route::post('/trips', [AgencyController::class, 'store'])->name('trips.store'); // Zapisywanie wycieczki
    Route::get('/trips/{id}/edit', [AgencyController::class, 'edit'])->name('trips.edit'); // Formularz edycji wycieczki
    Route::put('/trips/{id}', [AgencyController::class, 'update'])->name('trips.update'); // Aktualizowanie wycieczki
    Route::delete('/trips/{id}', [AgencyController::class, 'destroy'])->name('trips.destroy'); // Usuwanie wycieczki
    Route::get('/trips', [AgencyController::class, 'index'])->name('trips.index'); // Wyświetlanie listy wycieczek
});

// Trasy dla użytkowników zalogowanych
Route::middleware('auth')->group(function () {
    // Zarządzanie profilem
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Trasa GET
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Trasa PUT
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Trasa DELETE

    // Nowe funkcje profilu
    Route::get('/profile/trips', [ProfileController::class, 'trips'])->name('profile.trips'); // Zakładka My Trips
    Route::post('/profile/trips/{booking}/cancel', [ProfileController::class, 'cancelTrip'])->name('profile.trips.cancel');
});

require __DIR__.'/auth.php'; // Wczytanie routingu dla autentykacji
