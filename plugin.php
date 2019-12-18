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
 * PHP Version 7.2
 * 
 * @category WCML
 * @package  WCML
 * @author   10 Degrees <hello@10degrees.uk>
 * @license  GPL 2.0 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     www.example.com
 */

namespace WoocommerceMl;

if (!defined('WPINC')) {
    die();
}

require_once __DIR__ . '/vendor/autoload.php';


//Trained on instantiation
// $start = microtime(true);
// //phpcs:disable
$app = new App(); 

// $time_elapsed_secs = microtime(true) - $start;


// die('Executed in: '.$time_elapsed_secs.' seconds');

// $prediction = $app->getAssociatedProducts(99324);

// var_dump($prediction);

// die();
//phpcs:enable


//Register a widget area

//$app->getAssociatedProducts(21);
