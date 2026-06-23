<?php

use App\Providers\AppServiceProvider;
use Illuminate\Pagination\Paginator;

return [
    AppServiceProvider::class,
    Paginator::useBootstrapFive(),
];
