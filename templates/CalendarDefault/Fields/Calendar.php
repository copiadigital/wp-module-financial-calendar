<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Calendar extends Field
{
    /**
     * The field group.
     *
     * @return array
     */
    public function fields()
    {
        if(!is_plugin_active('financial-calendar/financial-calendar.php')) {
            return;
        }

        $Calendar = new FieldsBuilder('calendar', [
            'title' => 'Fields',
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
            'show_in_rest' => 0,
        ]);

        $Calendar
            ->setLocation('post_type', '==', 'calendar');

        $Calendar
            ->addDatePicker('date', [
                'label' => 'Date',
                'instructions' => 'Please select a date from the date picker field below.',
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ]);

        return $Calendar->build();
    }
}
