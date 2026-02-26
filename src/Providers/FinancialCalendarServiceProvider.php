<?php

namespace FinancialCalendar\Providers;

use Illuminate\Support\Facades\View;
use FinancialCalendar\Fields\Calendar as CalendarField;
use FinancialCalendar\Fields\Partials\Calendar as CalendarBuilderField;
use FinancialCalendar\View\Composers\Calendar as CalendarComposer;
use Log1x\AcfComposer\AcfComposer;

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

    protected function registerFields()
    {
        $composer = app(AcfComposer::class);
        $calendar = new CalendarField($composer);
        $calendar->compose();
    }

    protected function registerLayouts()
    {
        add_filter('acf_page_builder_before_build', function ($builder) {
            $fields = $builder->getFields();

            $flexible = null;

            foreach ($fields as $field) {
                if ($field->getName() === 'builder') {
                    $flexible = $field;
                    break;
                }
            }

            if ($flexible) {
                $composer = app(AcfComposer::class);

                $flexible
                    ->addLayout((new CalendarBuilderField($composer))->fields(), [
                        'label' => 'Calendar',
                        'display' => 'block',
                    ]);
            }

            return $builder;
        });
    }

    public function register()
    {
        foreach ($this->providers() as $service) {
            (new $service)->register();
        }

        $this->registerFields();
        $this->registerLayouts();
    }

    public function boot()
    {
        // Register views
        View::addLocation(dirname(dirname(__DIR__)) . '/resources/views');

        View::composer('partials.builder.calendar', CalendarComposer::class);
    }
}
