@vite(['modules/wp-module-financial-calendar/resources/scripts/calendar.js'])

<div class="section calendar"
  x-data="{
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
  <div class="row">
    @if($build['title'])
      <div class="col-12">
        <p class="h3">{!! $build['title'] !!}</p>
      </div>
    @endif

    <div class="calendar-list col-12">
      <div class="nav nav-pills mb-3" role="tablist">
        @foreach($calendar_years as $calendar_year)
          <a class="nav-link {{ $loop->first ? 'active' : '' }}"
            data-bs-toggle="pill"
            href="#year-{{ $calendar_year->slug }}"
            role="tab"
            aria-controls="year-{{ $calendar_year->slug }}"
            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
          >
            {!! $calendar_year->name !!}
          </a>
        @endforeach
      </div>

      <div class="tab-content">
        @foreach($calendar_years as $calendar_year)
          <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
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
              <table>
                <thead>
                  <th width="20%">Date</th>
                  <th width="60%">Title</th>
                  <th width="20%">Add to calendar</th>
                </thead>
                <tbody>
                  @posts($query)
                    @php $date = get_field('date', get_the_ID()) @endphp
                    <tr>
                      <td class="event-date">{{ $date }}</td>
                      <td class="event-title">@title</td>
                      <td class="add-to-calendar">
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
