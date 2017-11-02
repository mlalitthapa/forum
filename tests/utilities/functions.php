<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 9/19/17
 * Time: 8:48 PM
 */

function create($class, $attributes = [], $times = null) {
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null) {
    return factory($class, $times)->make($attributes);
}