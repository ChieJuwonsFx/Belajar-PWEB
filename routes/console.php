<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\adjustExpiredStock;
use Illuminate\Foundation\Console\ClosureCommand;

Schedule::command(adjustExpiredStock::class)
    ->daily();

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
