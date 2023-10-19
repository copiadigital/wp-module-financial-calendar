<?php

namespace FinancialCalendar\Commands;

class FinancialCalendarCommand extends \WP_CLI_Command
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * command usage: wp financial_calendar financial_calendar_default
     */
    public function financial_calendar_default()
    {
        $views_plugin_dir = FINANCIAL_CALENDAR_PLUGIN_DIR . 'templates/CalendarDefault/Views/calendar.blade.php';
        $views_theme_dir = get_stylesheet_directory() . '/resources/views/partials/builder/calendar.blade.php';

        $controller_plugin_dir = FINANCIAL_CALENDAR_PLUGIN_DIR . 'templates/CalendarDefault/Controller/Calendar.php';
        $controller_theme_dir = get_stylesheet_directory() . '/app/View/Composers/Calendar.php';

        $field_plugin_dir = FINANCIAL_CALENDAR_PLUGIN_DIR . 'templates/CalendarDefault/Fields/Calendar.php';
        $field_theme_dir = get_stylesheet_directory() . '/app/Fields/Calendar.php';

        $field_partial_plugin_dir = FINANCIAL_CALENDAR_PLUGIN_DIR . 'templates/CalendarDefault/Fields/Partials/Calendar.php';
        $field_partial_theme_dir = get_stylesheet_directory() . '/app/Fields/Partials/Builder/Layouts/Calendar.php';

        if(!copy($views_plugin_dir, $views_theme_dir)) {
            echo "\nfailed to copy $views_plugin_dir to $views_theme_dir...\n";
        }else {
            echo "\nSuccessfully copy $views_plugin_dir to $views_theme_dir...\n";
        }

        if(!copy($controller_plugin_dir, $controller_theme_dir)) {
            echo "\nfailed to copy $controller_plugin_dir to $controller_theme_dir...\n";
        }else {
            echo "\nSuccessfully copy $controller_plugin_dir to $controller_theme_dir...\n";
        }

        if(!copy($field_plugin_dir, $field_theme_dir)) {
            echo "\nfailed to copy $field_plugin_dir to $field_theme_dir...\n";
        }else {
            echo "\nSuccessfully copy $field_plugin_dir to $field_theme_dir...\n";
        }

        if(!copy($field_partial_plugin_dir, $field_partial_theme_dir)) {
            echo "\nfailed to copy $field_partial_plugin_dir to $field_partial_theme_dir...\n";
        }else {
            echo "\nSuccessfully copy $field_partial_plugin_dir to $field_partial_theme_dir...\n";
        }
    }
}
