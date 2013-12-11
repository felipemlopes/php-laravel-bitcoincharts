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

            // construct query
            $query = '';
            foreach ($args as $key => $value)
            {
                $query .= '&'.$key.'='.urlencode($value);
            }

            // make csv object
            $csv = \Travis\CSV::from_url($endpoint.'?'.$query);

            // catch error...
            if (!$csv) return false;

            // return
            return $csv->to_array();
        });
    }

}