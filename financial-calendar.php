<?php
/**
* Plugin Name:  Financial calendar
* Text Domain:  financial-calendar
* Description:  Financial calendar template.
* Version:      1.0.0
* Author:       Copia Digital
* Author URI:   https://www.copiadigital.com/
* License:      MIT License
*/

$autoload_path = __DIR__.'/vendor/autoload.php';
if ( file_exists( $autoload_path ) ) {
    require_once( $autoload_path );
}

define( 'FINANCIAL_CALENDAR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

$clover = new FinancialCalendar\Providers\FinancialCalendarServiceProvider;
$clover->register();

add_action('init', [$clover, 'boot']);
