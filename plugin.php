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

use Phpml\Association\Apriori;
use WoocommerceMl\Data\WooCommerceDataInterface;

if (!defined('WPINC')) {
    die();
}

require_once __DIR__ . '/vendor/autoload.php';

$options = new Options();//From WP Options table

$app = new App($options);

//@TODO implement queueing for training
//@TODO implement persistance for trained models
//@TODO store related products as metadata - needs updating, use a queue 
