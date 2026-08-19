<?php

if (! function_exists('userId')) {
    function userId() {
        return service('Authentication')->session("userId") ?: "0";
    }
}

if (! function_exists('user')) {
    function user($key="") {
        return service('Authentication')->user($key);
    }
}

if (! function_exists('prevUserId')) {
    function prevUserId() {
        return service('Authentication')->session("prevUserId") ?: "0";
    }
}

if (! function_exists('prevUser')) {
    function prevUser($key="") {
        return service('Authentication')->prevUser($key);
    }
}

if (! function_exists('inGroup')) {
    function inGroup($group)
    {
        return service('Authentication')->inGroup($group);
    }
}

if (! function_exists('office')) {
    function office($key="")
    {
        return service('Configs')->officedata($key);
    }
}