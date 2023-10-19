import 'ics';

$(() => {
  // Download calendar ICS file
  $('.add-to-calendar a').on('click', function(e) {
    e.preventDefault();

    const ics = require('ics');

    // Get text from calendar listing
    let title = $(this).closest('tr').find('.event-title').text();
    let date = $(this).closest('tr').find('.event-date').text();

    // Get date format and split to array
    let date_array = date.split('/');
    let date_day = date_array[0];
    let date_month = date_array[1];
    let date_year = date_array[2];

    // Grab calendar data
    const event = {
      start: [date_year, date_month, date_day, 0, 0],
      end: [date_year, date_month, date_day, 0, 0],
      //duration: { hours: 0, minutes: 0 },
      title: title,
      status: 'CONFIRMED',
    }

    // Build file with ICS calendar data
    ics.createEvent(event, (error, value) => {
      if (error) {
        alert('ICS file could not be downloaded.');
        console.error(error)
        return
      }

      // Download ICS file with calendar data
      window.open('data:text/calendar;charset=utf8,' + escape(value));
    });
  });
});
