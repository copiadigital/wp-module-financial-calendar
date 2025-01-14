<?php

namespace FinancialCalendar\Providers;

class RegisterAssets implements Provider
{
    public function __construct()
    {
        add_action('init', [$this, 'enqueue']);
    }

    public function register()
    {
        //
    }

    public function enqueue() {

        wp_enqueue_script('calendar.js', get_template_directory_uri() . '/modules/financial-calendar/public/scripts/calendar.js', ['jquery'], null, true);
    }
}
