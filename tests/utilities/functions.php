<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 9/19/17
 * Time: 8:48 PM
 */

function create($class, $attributes = []) {
    return factory($class)->create($attributes);
}

function make($class, $attributes = []) {
    return factory($class)->make($attributes);
}