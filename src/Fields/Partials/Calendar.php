<?php

namespace FinancialCalendar\Fields\Partials;

use Log1x\AcfComposer\Partial;
use Log1x\AcfComposer\Builder;

class Calendar extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $Fields = Builder::make('calendar');

        $Fields
            ->addText('title', [
                'label' => 'Title',
                'instructions' => 'Please enter a title to appear above the financial calendar.',
            ]);

        return $Fields;
    }
}
