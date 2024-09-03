<?php

if (! function_exists('admin_as')) {
    function admin_as()
    {
        return config('site.admin.as', 'admin');
    }
}

if (! function_exists('admin_prefix')) {
    function admin_prefix()
    {
        return config('site.admin.prefix', 'admin');
    }
}

if (! function_exists('admin_home_suffix')) {
    function admin_home_suffix()
    {
        return config('site.admin.home_suffix', 'home.index');
    }
}

if (! function_exists('admin_url')) {
    function admin_url()
    {
        return '/'.admin_prefix();
    }
}

if (! function_exists('admin_home_route_name')) {
    function admin_home_route_name()
    {
        return admin_as().'.'.admin_home_suffix();
    }
}

if (! function_exists('admin_home_url')) {
    function admin_home_url()
    {
        return route(admin_home_route_name());
    }
}

if (! function_exists('home_url')) {
    function home_url()
    {
        return '/';
    }
}

