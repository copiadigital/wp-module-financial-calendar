<?php

namespace FinancialCalendar\Providers;

use FinancialCalendar\View\Composers\App;

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

    }
}
