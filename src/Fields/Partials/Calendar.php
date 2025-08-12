<?php

namespace FinancialCalendar\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class FinancialCalendar extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $Fields = new FieldsBuilder('calendar');

        $Fields
            ->addText('title', [
                'label' => 'Title',
                'instructions' => 'Please enter a title to appear above the financial calendar.',
            ]);

        return $Fields;
    }
}
