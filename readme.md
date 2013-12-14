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
$prices = BitcoinCharts::all('bitstampUSD');
$prices = BitcoinCharts::recent('bitstampUSD');
```

The ``all()`` method will provide all trades from all time up to the previous evening, which represents a huge amount of data.  The ``recent()`` method will provide the last day of trades up to about 15 minutes ago.

See [BitcoinCharts](http://bitcoincharts.com/about/markets-api/) for more information.

## Notes

The API is broken and won't perform as expected when using the ``start`` and ``end`` arguments.  So I've changed the methods in this library to only accept symbol.  You can manually splice together long and short histories to get the dataset you want.

Also, you may need to increase the memory allowed to the application when using the ``all()`` method.