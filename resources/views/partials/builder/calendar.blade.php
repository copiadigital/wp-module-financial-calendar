<div class="section calendar">
  <div class="row">
    @if($build['title'])
      <div class="col-12">
        <p class="h3">{!! $build['title'] !!}</p>
      </div>
    @endif

    <div class="calendar-list col-12">
      <div class="nav nav-pills mb-3" role="tablist">
        @foreach($calendar_years as $key => $calendar_year)
          <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="pill" href="#year-{{ $calendar_year->slug }}" role="tab" aria-controls="year-{{ $calendar_year->slug }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}}">{!! $calendar_year->name !!}</a>
        @endforeach
      </div>

      <div class="tab-content">
        @foreach($calendar_years as $key => $calendar_year)
          <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="year-{{$calendar_year->slug}}" role="tabpanel" aria-labelledby="year-{{ $calendar_year->slug }}-tab">
            @set($query, new WP_Query([
              'post_type' => 'calendar',
                'tax_query' => [
                  [
                    'taxonomy' => $calendar_year->taxonomy,
                    'field' => $calendar_year->slug,
                    'terms' => $calendar_year->term_id
                  ]
                ]
            ]))
            @hasposts($query)
              <table>
                <thead>
                  <th width="20%">Date</th>
                  <th width="60%">Title</th>
                  <th width="20%">Add to calendar</th>
                </thead>
                <tbody>
                  @posts($query)
                    @set($date, get_field('date', get_the_ID()))
                    <tr>
                      <td width="20%" class="event-date">{{ $date }}</td>
                      <td width="60%" class="event-title">@title</td>
                      <td width="20%" class="add-to-calendar"><a href="#" aria-label="Add to calendar">Add to calendar</a></td>
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
