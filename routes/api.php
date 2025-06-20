<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PendudukLookupController;

Route::get('/penduduk/by-kk', [PendudukLookupController::class, 'getByNoKk']);
