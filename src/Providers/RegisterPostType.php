<?php

namespace FinancialCalendar\Providers;
use Copia\CustomPostTypes as CPT;

class RegisterPostType implements Provider
{
    public function __construct()
    {
        add_action('init', [$this, 'cpt_register']);
    }

    public function register()
    {
        //
    }

    public function cpt_register() {
        $types = [];

        array_push($types, CPT::createPostType('calendar')
            ->setPublic(true)
            ->setMenuPosition(27)
            ->setMenuIcon('dashicons-calendar-alt')
            ->setSupports(['title', 'revisions'])
            ->setRewrite([
                'slug' => 'calendar',
                'with_front' => false
            ]),
        );

        array_push($types, CPT::createTaxonomy('calendar_years', 'calendar', 'Calendar Year'));

        $types = apply_filters('financial_calendar_tax_before_insert', $types);

        CPT::register($types, false);
    }
}
