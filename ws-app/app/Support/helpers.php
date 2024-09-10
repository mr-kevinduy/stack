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

if (! function_exists('front_as')) {
    function front_as()
    {
        return config('site.front.as', 'front');
    }
}

if (! function_exists('front_prefix')) {
    function front_prefix()
    {
        return config('site.front.prefix', null);
    }
}

if (! function_exists('front_home_suffix')) {
    function front_home_suffix()
    {
        return config('site.front.home_suffix', 'home.index');
    }
}

if (! function_exists('front_home_route_name')) {
    function front_home_route_name()
    {
        return front_as().'.'.front_home_suffix();
    }
}

if (! function_exists('front_home_url')) {
    function front_home_url()
    {
        return route(front_home_route_name());
    }
}

if (! function_exists('front_route')) {
    function front_route($routeName = '', $options = [])
    {
        return route(front_as().'.'.$routeName, $options);
    }
}

if (! function_exists('uniqcode')) {
    function uniqcode()
    {
        return sha1(uniqid(mt_rand(), true));
    }
}
