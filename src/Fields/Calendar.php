<?php

namespace FinancialCalendar\Fields;

use Log1x\AcfComposer\Field;
use Log1x\AcfComposer\Builder;

class Calendar extends Field
{
    /**
     * The field group.
     *
     * @return array
     */
    public function fields()
    {
        $Fields = Builder::make('calendar', [
            'title' => 'Fields',
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
            'show_in_rest' => 0,
        ]);

        $Fields
            ->setLocation('post_type', '==', 'calendar');

        $Fields
            ->addDatePicker('date', [
                'label' => 'Date',
                'instructions' => 'Please select a date from the date picker field below.',
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ]);

        return $Fields->build();
    }
}
