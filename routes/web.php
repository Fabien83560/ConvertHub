<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\SetLocale;

Route::post('/set-language', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale');

    if (! in_array($locale, ['en', 'fr'])) {
        abort(400);
    }

    Session::put('locale', $locale);
    return redirect()->back();
})->name('set-language');

Route::middleware([SetLocale::class])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});

Route::middleware([SetLocale::class, 'auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
