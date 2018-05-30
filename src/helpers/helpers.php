<?php
    /**
     * Laraware Helpers.
     * 
     * Common helper functions for Laravel applications
     *
     *-------------------------------------------------------- */

    if (!function_exists('isEmpty')) {
       /*
        * Customized isEmpty
        *
        * @param Mixed  $data  - Mixed data
        * 
        * @return array
        *---------------------------------------------------------------- */
        function isEmpty($data)
        {
            if (empty($data) === false) {
                if (($data instanceof Illuminate\Database\Eloquent\Collection
                        or $data instanceof Illuminate\Pagination\Paginator
                        or $data instanceof Illuminate\Pagination\LengthAwarePaginator
                        or $data instanceof Illuminate\Support\Collection)
                    and ($data->count() <= 0)) {
                    return true;
                } elseif (is_object($data)) {
                    $data = (array) $data;
                    return empty($data);
                }
                return false;
            }
            return true;
        }
    }
    if (!function_exists('ifIsset')) {
        /*
          * Check isset & isEmpty & return the result based on values sent
          *
          * @param Mixed  $data  - Mixed data - Note: Should no used direct function etc
          * @param Mixed  $ifSetValue  - Value if result is true
          * @param Mixed  $ifNotSetValue  - Value if result is false
          * 
          * @return array
          *---------------------------------------------------------------- */        
        function ifIsset(&$data, $ifSetValue = '', $ifNotSetValue = '')
        {
            // check if value isset & not empty
            if ((isset($data) === true) and (isEmpty($data) === false)) {
                if (! is_string($ifSetValue) and is_callable($ifSetValue) === true) {
                    return call_user_func($ifSetValue, $data);
                } elseif ($ifSetValue === true) {
                    return $data;
                } elseif ($ifSetValue !== '') {
                    return $ifSetValue;
                }
                return true;
            } else {
                if (! is_string($ifNotSetValue) and is_callable($ifNotSetValue) === true) {
                    return call_user_func($ifNotSetValue);
                } elseif ($ifNotSetValue !== '') {
                    return $ifNotSetValue;
                }
                return false;
            }
        }
    }

    if (!function_exists('re_index_array')) {
       /*
        * Re Indexing using array value based on key
        *
        * @param array $array
        * @param string $valueKey 
        * @param closure function $closure
        * @since - 29 JUN 2017
        * @example uses
            re_index_array([
                ['id' => '9e0fec39-dd53-4636-b628-f0123f05b318', name= 'xyz'],
                ['id' => '8e0fec39-ed53-5636-c628-f0123f05b618', name= 'abc']
            ], 'id', function($item, $valueKey) {
                   $item['name'] =>  strtoupper($item['name']);
                   return $item;
            });

            // Result
                [
                    '9e0fec39-dd53-4636-b628-f0123f05b318' => [
                        'id' => '9e0fec39-dd53-4636-b628-f0123f05b318',
                        'name' => 'Xyz'
                    ],
                    '8e0fec39-ed53-5636-c628-f0123f05b618' => [
                        'id' => '8e0fec39-ed53-5636-c628-f0123f05b618',
                        'name' => 'Abc'
                    ]
                ]

        * @return array.
        *-------------------------------------------------------- */
        function re_index_array(array $array, $valueKey, $closure = null)
        {
            $newArray = [];
            if(!empty($array)) {
                foreach ($array as $item) {
                    if(is_array($item)) {
                        $itemForKey = array_get($item, $valueKey);                    
                        if($itemForKey and (is_string($itemForKey) 
                            or is_numeric($itemForKey))) {
                            if($closure and is_callable($closure)) {
                                $newArray[$itemForKey] = call_user_func($closure, $item, $valueKey);
                            } else {
                                $newArray[$itemForKey] = $item;
                            }
                        }
                    }
                }
            }
            unset($array, $valueKey, $closure);
            return $newArray;
        }
    }