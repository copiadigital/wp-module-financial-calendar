<?php

namespace FinancialCalendar\View\Composers;
use Roots\Acorn\View\Composer;

class Calendar extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.builder.calendar'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'calendar_years' => $this->calendarYears(),
        ];
    }

    /**
     * Calendar years taxonomy
     */
    public function calendarYears()
    {
        $years = get_terms([
            'taxonomy' => 'calendar_years',
            'hide_empty' => true,
            'order' => 'DESC',
        ]);

        return $years;
    }
}
