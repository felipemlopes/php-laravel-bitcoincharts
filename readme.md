# BitcoinCharts

A Laravel PHP library for working w/ the BitcoinCharts API.

## Install

Normal install via Composer.

## Usage

Call the desired method and pass the params as a single array.

```php
$prices = Travis\BitcoinCharts::all('bitstampUSD');
$prices = Travis\BitcoinCharts::recent('bitstampUSD');
```

The ``all()`` method will provide all trades from all time up to the previous evening, which represents a huge amount of data.  The ``recent()`` method will provide the last day of trades up to about 15 minutes ago.

See [BitcoinCharts](http://bitcoincharts.com/about/markets-api/) for more information.

## Notes

- The API is broken and won't perform as expected when using the ``start`` and ``end`` arguments.  So I've changed the methods in this library to only accept symbol.  You can manually splice together long and short histories to get the dataset you want.
- You may need to increase the memory allowed to the application when using the ``all()`` method.
- I encountered an issue where this package couldn't connect to BitcoinCharts due to their server returning an IPv6 address.  I had to modify my server to disable IPv6, which allowed the PHP to continue working properly.