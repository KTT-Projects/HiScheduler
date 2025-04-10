# HiScheduler

HiScheduler is a dynamic web-based scheduling application that enables efficient activity management and participation tracking.

## Features

- **Activity Management**: Add, remove, and manage activities
- **Calendar Integration**: Visual calendar interface for scheduling
- **Admin Controls**: Dedicated admin area for system management
- **User Participation**: Track and manage user participation in activities
- **Mobile Responsive**: Optimized for both desktop and mobile devices

## Technologies

- PHP
- MySQL
- JavaScript (jQuery)
- HTML5
- CSS3

## Setup

1. Clone the repository
2. Import `HiScheduler_Database.sql` to set up the database
3. Configure database connection in `config.php`
4. Ensure your web server meets the following requirements:
   - PHP 7.0+
   - MySQL 5.7+
   - Apache/Nginx web server

## Directory Structure

```
HiScheduler/
├── css/               # Style sheets for specific pages
│   ├── calendar.css
│   ├── index.css
│   └── ...
├── js/               # JavaScript files
│   └── index.js
├── images/           # Image assets
├── tools/            # Helper tools and utilities
├── config.php        # Database configuration
├── index.php         # Application entry point
└── various .php      # Core application files
```

## Core Files

- `index.php`: Main entry point
- `home.php`: Dashboard view
- `manage_activity.php`: Activity management interface
- `manage_participation.php`: Participation tracking
- `config.php`: Database and application configuration

## Usage

1. Access the application through your web browser
2. Log in to the system
3. Use the calendar interface to view scheduled activities
4. Add or manage activities through the admin interface
5. Track participation and manage user sessions

## License

All rights reserved. This project is proprietary and confidential.
