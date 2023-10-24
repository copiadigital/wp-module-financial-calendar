<?php

namespace FinancialCalendar\Providers;

use Illuminate\Support\Facades\View;
use FinancialCalendar\View\Composers\Calendar;

class FinancialCalendarServiceProvider implements Provider
{
    protected function providers()
    {
        return [
            CommandServiceProvider::class,
            RegisterAssets::class,
            RegisterPostType::class,
        ];
    }

    public function register()
    {
        foreach ($this->providers() as $service) {
            (new $service)->register();
        }
    }

    public function boot()
    {
        if ( function_exists( '\Roots\view' ) ) {
            \Roots\view()->addNamespace('FinancialCalendar', FINANCIAL_CALENDAR_PLUGIN_DIR . 'resources/views/');

            // \Roots\view('FinancialCalendar::partials.builder.calendar', ['test' => 'variable'])->render();
        }

        View::composer('FinancialCalendar::partials.builder.calendar', Calendar::class);

    }
}
