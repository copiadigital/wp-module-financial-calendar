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
        wp_enqueue_script('calendar.js', plugins_url('../public/scripts/calendar.js', dirname(__FILE__)), ['jquery'], null, true);
    }
}
