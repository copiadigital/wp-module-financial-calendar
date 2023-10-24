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
            'calendar_years' => $this->calendarYears()
            //'calendar_items' => $this->calendarItems()
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

    /*public function calendarItems()
    {
        $calendar_years = get_terms(array(
            'taxonomy' => 'calendar_years',
            'hide_empty' => false,
            'fields' => 'id=>slug',
            'order' => 'DESC',
        ));

        $posts = $this->getPostsByQueryArgs([
            'post_type' => 'calendar'
        ], false);

        $calendar_items = [];

        foreach ( $posts as $post ) {
            $calendar_items[] = [
                'ID' => $post->ID,
                'title' => get_the_title($post->ID),
                'date' => get_field('date', $post->ID)
            ];
        }

        return $calendar_items;
    }*/
}
