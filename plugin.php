<?php

/**
 * Plugin Name: WooCommerce ML
 * Plugin URI: 
 * Text Domain: wcml
 * Description: An imlementation of PHP-ML to WooCommerce
 * Version: 1.0
 * Author: You
 * Author URI: 
 * License: GPL2
 *
 */

namespace WoocommerceMl;

if (!defined('WPINC')) {
    die();
}

require_once __DIR__ . '/vendor/autoload.php';


$app = new App('apriori');

// $app->run();


