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
    function view($fileName, $vars = array())
    {
        foreach ($vars as $key => $value) {
            ${$key} = $value;
        }
        ob_start();
        include plugin_dir_path(__FILENAME__) . '/' .$fileName . '.php';
        return ob_get_clean();
    }
}
