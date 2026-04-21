<?php

$boot = new FinancialCalendar\Providers\FinancialCalendarServiceProvider;
$boot->register();

add_action('init', [$boot, 'boot']);
