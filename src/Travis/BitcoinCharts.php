<?php

namespace Travis;

class BitcoinCharts {

    /**
     * Return array of recent trades.
     *
     * @param   string  $symbol
     * @return  array
     */
    public static function recent($symbol)
    {
        return static::get('recent', $symbol);
    }

    /**
     * Return array of all trades.
     *
     * @param   string  $symbol
     * @return  array
     */
    public static function all($symbol)
    {
        return static::get('all', $symbol);
    }

    /**
     * Process request w/ API.
     *
     * @param   string  $method
     * @param   string  $symbol
     * @return  array
     */
    protected static function get($method, $symbol)
    {
        // calculate hash
        $hash = md5($method.$symbol);

        // set time for cache...
        $time = $method == 'all' ? 720 : 15;

        // load from cache...
        return \Cache::remember('bitcoincharts_'.$hash, $time, function() use($method, $symbol)
        {
            // if all...
            if ($method == 'all')
            {
                // make url
                $url = 'http://api.bitcoincharts.com/v1/csv/'.$symbol.'.csv';
            }

            // else if recent...
            else
            {
                // make url
                $url = 'http://api.bitcoincharts.com/v1/trades.csv?symbol='.$symbol;
            }

            // load csv from remote
            $csv = \Travis\CSV::from_url($url, false); // false flag means first row NOT headers

            // catch error...
            if (!$csv) return false;

            // add columns
            $csv->columns(array('time', 'price', 'volume'));

            // get rows
            $history = $csv->to_array();

            // sort the rows by time (oldest first)
            usort($history, function($a, $b)
            {
                return $a['time'] < $b['time'] ? -1 : 1;
            });

            // return
            return $history;
        });
    }

}