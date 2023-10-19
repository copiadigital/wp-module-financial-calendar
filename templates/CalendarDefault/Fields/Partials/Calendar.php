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
        $Calendar = new FieldsBuilder('calendar');

        $Calendar
            ->addText('title', [
                'label' => 'title',
                'instructions' => 'Please enter a title to appear above the financial calendar.',
            ]);
        return $Calendar;
    }
}
