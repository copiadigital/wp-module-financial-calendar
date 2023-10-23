<?php

namespace App\Fields\Partials\Builder\Layouts;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Calendar extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        if(!is_plugin_active('financial-calendar/financial-calendar.php')) {
            return;
        }

        $Calendar = new FieldsBuilder('calendar');

        $Calendar
            ->addText('title', [
                'label' => 'Title',
                'instructions' => 'Please enter a title to appear above the financial calendar.',
            ]);
        return $Calendar;
    }
}
