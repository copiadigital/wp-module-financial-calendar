# Financial Calendar Module

WordPress module that provides a financial calendar feature with event management and ICS export functionality.

## Tech Stack

- **PHP** ^8.0 with PSR-4 autoloading (`FinancialCalendar\` namespace)
- **Node.js** ^22.12.0
- **Tailwind CSS** for styling
- **Alpine.js** for frontend interactivity
- **Blade** templating (Laravel-style)
- **ACF** (Advanced Custom Fields) with Log1x\AcfComposer
- **Vite** for asset bundling

## Project Structure

```
src/
├── Providers/          # Service providers (assets, post types)
├── Fields/             # ACF field definitions
│   └── Partials/       # Page builder partial fields
└── View/Composers/     # View data composers

resources/
├── views/partials/builder/  # Blade templates
└── scripts/                 # JavaScript files
```

## Key Components

- **Custom Post Type**: `calendar` with `calendar_years` taxonomy
- **View Composer**: `src/View/Composers/Calendar.php` prepares template data
- **Main Template**: `resources/views/partials/builder/calendar.blade.php`

## Development

Module is installed in a WordPress theme. Assets are compiled from the parent theme:

```bash
yarn dev  # Development with HMR
yarn build  # Production build
```

## Coding Conventions

- Use vanilla JavaScript (no jQuery)
- Alpine.js for interactive components (`x-data`, `@click`, etc.)
- Tailwind CSS utility classes for styling
- ACF Composer builder pattern for field registration
- Blade templates with `@vite` directive for assets
