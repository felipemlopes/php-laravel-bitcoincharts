# BitcoinCharts

A Laravel PHP library for working w/ the BitcoinCharts API.

## Install

This library is designed for use w/ Laravel, as it requires the use of caching and CSV file conversions.

### Provider

Register your service provider in ``app/config/app.php``:

```php
'Travis\BitcoinCharts\Provider'
```

You may also wish to add an alias to remove the namespace:

```php
'BitcoinCharts' => 'Travis\BitcoinCharts'
```

## Usage

Call the desired method and pass the params as a single array.

```php
$chart = BitcoinCharts::get(array(
    'symbol' => 'bitstampUSD',
    'start' => '2013-12-01', // will interpret using strtotime() and convert to unix timestamp
));
```

See [BitcoinCharts](http://bitcoincharts.com/about/markets-api/) for full list of arguments.