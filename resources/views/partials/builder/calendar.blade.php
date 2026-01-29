@vite(['modules/wp-module-financial-calendar/resources/scripts/calendar.js'])

<div class="section calendar"
  x-data="{
    activeTab: '{{ $calendar_years[0]->slug ?? '' }}',
    addToCalendar(e) {
      e.preventDefault();
      const link = e.currentTarget;
      const row = link.closest('tr');
      const title = row.querySelector('.event-title')?.textContent.trim();
      const dateText = row.querySelector('.event-date')?.textContent.trim();

      if (!title || !dateText) {
        alert('Missing event data.');
        return;
      }

      const [day, month, year] = dateText.split('/').map(Number);

      const event = {
        start: [year, month, day, 0, 0],
        end: [year, month, day, 0, 0],
        title,
        status: 'CONFIRMED'
      };

      try {
        const filename = `${title}.ics`;

        createEvent(event, (error, value) => {
          if (error) {
            console.error(error);
            alert('Failed to generate ICS file.');
            return;
          }

          const file = new File([value], filename, { type: 'text/calendar' });
          const url = URL.createObjectURL(file);
          const a = document.createElement('a');
          a.href = url;
          a.download = filename;
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(url);
        });
      } catch (err) {
        console.error(err);
        alert('Failed to generate ICS file.');
      }
    }
  }"
>
  <div class="calendar__container">
    @if($build['title'])
      <div class="calendar__title">
        <p class="tw-text-h3">{!! $build['title'] !!}</p>
      </div>
    @endif

    <div class="calendar__list">
      <ul class="calendar__nav tw-list-none tw-p-0 tw-m-0 tw-flex tw-flex-wrap tw-border-b tw-border-gray-200" role="tablist">
        @foreach($calendar_years as $calendar_year)
          <li class="calendar__nav-item" role="presentation">
            <button
              type="button"
              class="calendar__nav-link tw-px-10 tw-py-10 tw-border-b-2 tw-transition-colors"
              :class="activeTab === '{{ $calendar_year->slug }}' ? 'tw-border-current tw-font-semibold' : 'tw-border-transparent hover:tw-border-gray-300'"
              @click="activeTab = '{{ $calendar_year->slug }}'"
              role="tab"
              :aria-selected="activeTab === '{{ $calendar_year->slug }}'"
              aria-controls="year-{{ $calendar_year->slug }}"
            >
              {!! $calendar_year->name !!}
            </button>
          </li>
        @endforeach
      </ul>

      <div class="calendar__tab-content tw-mt-40">
        @foreach($calendar_years as $calendar_year)
          <div
            x-show="activeTab === '{{ $calendar_year->slug }}'"
            x-transition:enter="tw-transition tw-ease-out tw-duration-200"
            x-transition:enter-start="tw-opacity-0"
            x-transition:enter-end="tw-opacity-100"
            class="calendar__tab-pane"
            id="year-{{ $calendar_year->slug }}"
            role="tabpanel"
            aria-labelledby="year-{{ $calendar_year->slug }}-tab"
          >
            @php
              $query = new WP_Query([
                'post_type' => 'calendar',
                'tax_query' => [[
                  'taxonomy' => $calendar_year->taxonomy,
                  'field' => 'term_id',
                  'terms' => $calendar_year->term_id
                ]]
              ]);
            @endphp

            @hasposts($query)
              <table class="calendar__table tw-w-full">
                <thead class="calendar__table-head">
                  <tr>
                    <th class="calendar__table-head-date tw-w-[20%] tw-border tw-border-gray-200 tw-p-8 tw-font-bold tw-bg-gray-200">Date</th>
                    <th class="calendar__table-head-title tw-w-[60%] tw-border tw-border-gray-200 tw-p-8 tw-font-bold tw-bg-gray-200">Title</th>
                    <th class="calendar__table-head-action tw-w-[20%] tw-border tw-border-gray-200 tw-p-8 tw-font-bold tw-bg-gray-200">Add to calendar</th>
                  </tr>
                </thead>
                <tbody class="calendar__table-body">
                  @posts($query)
                    @php $date = get_field('date', get_the_ID()) @endphp
                    <tr>
                      <td class="calendar__table-body-date event-date tw-border tw-border-gray-200 tw-p-8">{{ $date }}</td>
                      <td class="calendar__table-body-title event-title tw-border tw-border-gray-200 tw-p-8">@title</td>
                      <td class="calendar__table-body-action tw-border tw-border-gray-200 tw-p-8">
                        <a href="#"
                          aria-label="Add to calendar"
                          @click="addToCalendar($event)"
                        >Add to calendar</a>
                      </td>
                    </tr>
                  @endposts
                </tbody>
              </table>
            @endhasposts
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
