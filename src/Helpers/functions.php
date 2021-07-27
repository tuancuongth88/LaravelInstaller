<?php


if (! function_exists('isActive')) {
    /**
     * Set the active class to the current opened menu.
     *
     * @param  string|array $route
     * @param  string       $className
     * @return string
     */
    function isActive($route, $className = 'active')
    {
        if (is_array($route)) {
            return in_array(Route::currentRouteName(), $route) ? $className : '';
        }
        if (Route::currentRouteName() == $route) {
            return $className;
        }
        if (strpos(URL::current(), $route)) {
            return $className;
        }
    }
}
if (!function_exists('get_package_version')) {
    /**
     * @param string $packageName
     * @return string
     */
    function get_package_version($packageName)
    {
        $file = base_path().'/composer.lock';
        $packages = json_decode(file_get_contents($file), true)['packages'];
        foreach ($packages as $package) {
            if ($package['name'] == $packageName) {
                return $package['version'];
            }
        }
        return null;
    }
}

