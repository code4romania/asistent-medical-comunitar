<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::redirect('/intrare.php', '/login', Response::HTTP_MOVED_PERMANENTLY)->name('login');
