<?php

/**
 * Convert multiple query with the same key
 *
 * @param  array  $string_params
 * @return [$keys, $values]
 */
function convertQueryParams($string_params)
{
    $keys = [];
    $values = [];
    foreach ($string_params as $string_param) {
        $arr = explode('=', $string_param);
        $keys[] = $arr[0];
        $values[] = $arr[1];
    }
    $keys = array_unique($keys);

    return [$keys, $values];
}

/**
 * @param $search
 * @return array
 */
function parserSearchData($search)
{
    $searchData = [];

    if (stripos($search, ':')) {
        $fields = explode(';', $search);

        foreach ($fields as $row) {
            try {
                [$field, $value] = explode(':', $row);
                $searchData[$field] = $value;
            } catch (\Exception $e) {
                //Surround offset error
            }
        }
    }

    return $searchData;
}
