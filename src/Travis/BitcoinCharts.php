<?php

namespace Travis;

class BitcoinCharts {

    /**
     * Return array from BitcoinCharts.
     *
     * @param   array   $args
     * @return  array
     */
    public static function get($args = array())
    {
        // calculate hash
        $hash = md5(serialize($args));

        // cache for 15 minutes...
        return \Cache::remember('bitcoincharts_'.$hash, 15, function() use($args)
        {
            // determine endpoint
            $endpoint = 'http://api.bitcoincharts.com/v1/trades.csv';

            // detect "start" and convert
            if (isset($args['start'])) $args['start'] = strtotime($args['start']);
            if (isset($args['end'])) $args['end'] = strtotime($args['end']);

            // construct query
            $query = '';
            foreach ($args as $key => $value)
            {
                $query .= '&'.$key.'='.urlencode($value);
            }

            // make url
            $url = $endpoint.'?'.$query;

            // load csv from remote
            $csv = \Travis\CSV::from_url($url, false); // false flag means first row NOT headers

            // catch error...
            if (!$csv) return false;

            // add columns
            $csv->columns(array('time', 'price', 'volume'));

            // return
            return $csv->to_array();
        });
    }

}