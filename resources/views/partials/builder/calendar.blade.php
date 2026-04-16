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
        <p class="text-h3">{!! $build['title'] !!}</p>
      </div>
    @endif

    <div class="calendar__list">
      <ul class="calendar__nav list-none p-0 m-0 flex flex-wrap border-b border-gray-200" role="tablist">
        @foreach($calendar_years as $calendar_year)
          <li class="calendar__nav-item" role="presentation">
            <button
              type="button"
              class="calendar__nav-link px-10 py-10 border-b-2 transition-colors"
              :class="activeTab === '{{ $calendar_year->slug }}' ? 'border-current font-semibold' : 'border-transparent hover:border-gray-300'"
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

      <div class="calendar__tab-content mt-40">
        @foreach($calendar_years as $calendar_year)
          <div
            x-show="activeTab === '{{ $calendar_year->slug }}'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
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
              <table class="calendar__table w-full">
                <thead class="calendar__table-head">
                  <tr>
                    <th class="calendar__table-head-date w-[20%] border border-gray-200 p-8 font-bold bg-gray-200">Date</th>
                    <th class="calendar__table-head-title w-[60%] border border-gray-200 p-8 font-bold bg-gray-200">Title</th>
                    <th class="calendar__table-head-action w-[20%] border border-gray-200 p-8 font-bold bg-gray-200">Add to calendar</th>
                  </tr>
                </thead>
                <tbody class="calendar__table-body">
                  @posts($query)
                    @php $date = get_field('date', get_the_ID()) @endphp
                    <tr>
                      <td class="calendar__table-body-date event-date border border-gray-200 p-8">{{ $date }}</td>
                      <td class="calendar__table-body-title event-title border border-gray-200 p-8">@title</td>
                      <td class="calendar__table-body-action border border-gray-200 p-8">
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
