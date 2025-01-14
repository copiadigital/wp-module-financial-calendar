<?php

namespace FinancialCalendar\Providers;

use Illuminate\Support\Facades\View;
use FinancialCalendar\Fields\Calendar as CalendarField;
use FinancialCalendar\Fields\Partials\Calendar as CalendarBuilderField;
use FinancialCalendar\View\Composers\Calendar as CalendarComposer;
use Log1x\AcfComposer\AcfComposer;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Clones\Builder;

class FinancialCalendarServiceProvider implements Provider
{
    public static $parent_layout_key;

    protected function providers()
    {
        return [
            RegisterAssets::class,
            RegisterPostType::class,
        ];
    }

    public function register()
    {
        $calendar_key = 'calendar';  // Variable value
        self::$parent_layout_key = 'builder_builder_' . $calendar_key;

        foreach ($this->providers() as $service) {
            (new $service)->register();
        }
    }

    public function boot()
    {
        // Register Fields
        $composer = app(AcfComposer::class);
        $calendar = new CalendarField($composer);
        $calendar->compose();

        add_filter('acf/load_field/name=builder', function ($field) {
            if (isset($field['layouts'])) {
                $calendar_builder = new CalendarBuilderField();

                $layout = [
                    'key' => 'field_'.self::$parent_layout_key,
                    'name' => 'calendar',
                    'label' => 'Calendar',
                    'display' => 'block',
                    'sub_fields' => $calendar_builder->register()['fields'],
                    'min' => '',
                    'max' => '',
                    'acfe_flexible_render_template' => false,
                    'acfe_flexible_render_style' => false,
                    'acfe_flexible_render_script' => false,
                    'acfe_flexible_thumbnail' => false,
                    'acfe_flexible_settings' => false,
                    'acfe_flexible_settings_size' => 'medium',
                    'acfe_flexible_modal_edit_size' => false,
                    'acfe_flexible_category' => false,
                ];

                $field['layouts'][] = $layout;
            }
            // dd($field);
            return $field;
        });

        // Register views
        if ( function_exists( '\Roots\view' ) ) {
            \Roots\view()->addNamespace('FinancialCalendar', dirname(dirname(__DIR__)) . '/resources/views/');

            // \Roots\view('FinancialCalendar::partials.builder.calendar', ['test' => 'variable'])->render();
        }

        View::composer('FinancialCalendar::partials.builder.calendar', CalendarComposer::class);

    }
}
