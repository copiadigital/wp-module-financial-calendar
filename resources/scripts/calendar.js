import { createEvent } from 'ics';

if (!window.__calendarModuleInitialized) {
  window.__calendarModuleInitialized = true;

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-calendar a').forEach(link => {
      link.addEventListener('click', async function (e) {
        e.preventDefault();

        const row = this.closest('tr');
        const title = row.querySelector('.event-title')?.textContent.trim();
        const dateText = row.querySelector('.event-date')?.textContent.trim();

        if (!title || !dateText) {
          alert('Missing event data.');
          return;
        }

        // Expecting DD/MM/YYYY
        const [day, month, year] = dateText.split('/').map(Number);

        const event = {
          start: [year, month, day, 0, 0],
          end: [year, month, day, 0, 0],
          title,
          status: 'CONFIRMED'
        };

        try {
          const filename = `${title}.ics`;

          const file = await new Promise((resolve, reject) => {
            createEvent(event, (error, value) => {
              if (error) return reject(error);
              resolve(new File([value], filename, { type: 'text/calendar' }));
            });
          });

          const url = URL.createObjectURL(file);
          const a = document.createElement('a');
          a.href = url;
          a.download = filename;
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(url);

        } catch (err) {
          console.error(err);
          alert('Failed to generate ICS file.');
        }
      });
    });
  });
}
