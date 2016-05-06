# Plates for Glue

Use [leauge/plates](https://github.com/thephpleague/plates) with [gluephp/glue](https://github.com/gluephp/glue)

## Installation

Use [Composer](http://getcomposer.org):

```bash
$ composer require gluephp/glue-plates
```

## Configure Plates

```php
$app = new Glue\App;

$app->config->override([
    'plates' => [
        'path'    => '/absolute/path/to/templates/folder',
    ],
]);
```

## Register Plates

```php
$app->register(
    new Glue\Plates\ServiceProvider()
);
```

## Get the Plates instance

Once the service provider is registered, you can fetch the Plates instance with:

```php
$plates = $app->make('League\Plates\Engine');
```
or use the alias:
```php
$plates = $app->plates;
```

