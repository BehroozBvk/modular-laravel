# Log Viewer for Baraeim

[OPcodes's Log Viewer](https://github.com/opcodesio/log-viewer) is integrated into Baraeim to provide an elegant and powerful interface for viewing and managing logs.

## 📋 Overview

Log Viewer helps you quickly and clearly see individual log entries, search, filter, and make sense of your Laravel logs fast. It eliminates the need to read raw log files when troubleshooting issues.

![Log Viewer Screenshot](https://github.com/opcodesio/log-viewer/raw/main/art/screenshot.png)

## ✨ Features

- 📂 View all Laravel logs in your `storage/logs` directory
- 📂 Support for other log types - Horizon, Apache, Nginx, Redis, Supervisor, Postgres, and more
- 🔍 Powerful search functionality
- 🎚 Filter by log level (error, info, debug, etc.)
- 🔗 Sharable links to individual log entries
- 🌑 Dark mode support
- 📱 Mobile-friendly UI
- 🖥️ Multiple host support
- ⌨️ Keyboard accessible
- 💾 Download & delete log files directly from the UI
- ☑️ Horizon log support (up to Horizon v9.20)
- ☎️ API access for folders, files & log entries
- 💌 Mail previews for e-mails sent to the logs

## 🚀 Accessing Log Viewer

Once installed, Log Viewer is available at:

```
{APP_URL}/log-viewer
```

For example: `https://baraeim.test/log-viewer`

## 🔐 Authentication & Authorization

By default, Log Viewer is only accessible in the `local` environment. For production use, you should configure proper authentication to prevent unauthorized access.

### Configuring Access Control

You can modify the Log Viewer configuration to restrict access:

```php
// config/log-viewer.php
'middleware' => [
    'web',
    'auth',
    function () {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }
    },
],
```

## 📋 Advanced Configuration

For advanced configuration options, publish the configuration file:

```bash
php artisan vendor:publish --tag=log-viewer-config
```

This will create a `config/log-viewer.php` file where you can customize:

- Route path
- Middleware
- Log directories
- Maximum file size
- UI preferences
- And more

## 🔄 Updating Log Viewer

To update Log Viewer assets after package updates:

```bash
php artisan log-viewer:publish
```

## 📚 Additional Resources

- [Official Documentation](https://log-viewer.opcodes.io/)
- [GitHub Repository](https://github.com/opcodesio/log-viewer)
- [Demo Video](https://log-viewer.opcodes.io/#demo) 