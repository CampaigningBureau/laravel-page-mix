# laravel-page-mix

This package parses your `mix-manifest.json` to automatically implement the
Javascript named after the current route.

## Setup

Add the service provider to the `config/app.php` provider array
```php
MScharl\LaravelPageMix\Provider\LaravelPageMixProvider::class,
```

Use `pageMix()` instead of `mix('page.js')`
```blade
<script src="{{ pageMix() }}"></script>
```

## Config

Publish the config file by executing the following command:
```bash
php artisan vendor:publish --provider=MScharl\\LaravelPageMix\\Provider\\LaravelPageMixProvider
```

It allows to configure a default file path if the route does not match any file name
