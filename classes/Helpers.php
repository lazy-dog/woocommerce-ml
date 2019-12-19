<?php

namespace WoocommerceMl;

/**
 * Helper functions
 */
class Helpers
{

    /**
     * Load a view and pass variables into it
     *
     * To ouput a view you would want to echo it
     *
     * @param string $fileName excluding file extension
     * @param array  $vars     variables to pass to view
     *
     * @return string
     */
    public static function view($fileName, $vars = array())
    {
        foreach ($vars as $key => $value) {
            ${$key} = $value;
        }
        ob_start();
        include plugin_dir_path(__FILENAME__) . '/' .$fileName . '.php';
        return ob_get_clean();
    }

    /**
     * Array flattening pasta
     *
     * @param array $array Thing to flatten
     * 
     * @see https://gist.github.com/SeanCannon/6585889
     * 
     * @return array $result Flattened array
     */
    public static function arrayFlatten(array $array = null)
    {
        $result = array();
    
        if (!is_array($array)) {
            $array = func_get_args();
        }
    
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, self::arrayFlatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }
    
        return $result;
    }

}
