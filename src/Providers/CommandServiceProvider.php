<?php

namespace FinancialCalendar\Providers;

use FinancialCalendar\Commands\FinancialCalendarCommand;

class CommandServiceProvider implements Provider
{
    public function register()
    {
        if (! defined('WP_CLI') || ! WP_CLI) {
            return;
        }

        \WP_CLI::add_command('results', FinancialCalendarCommand::class);
    }
}
