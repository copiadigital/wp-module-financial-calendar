<?php

namespace FinancialCalendar\Fields\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;
use FinancialCalendar\Providers\FinancialCalendarServiceProvider;

class Calendar
{
    protected $fields;

    public function __construct()
    {
        $parent_layout_key = FinancialCalendarServiceProvider::$parent_layout_key;
        $subfield_key = 'calendar';
        $final_key = $parent_layout_key . '_' . $subfield_key;

        $this->fields = new FieldsBuilder($final_key);

        $this->fields
            ->addText('title', [
                'label' => 'Title',
                'instructions' => 'Please enter a title to appear above the financial calendar.',
                'required' => 0,
                'maxlength' => false,
                '_name' => 'title',
            ]);
    }

    /**
     * Get the built fields for the partial
     *
     * @return array
     */
    public function register(): array
    {
        return $this->fields->build();
    }
}
