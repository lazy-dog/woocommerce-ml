<?php

namespace WoocommerceMl;

use WoocommerceMl\Outputter\HtmlOutputter;
use WoocommerceMl\Helpers;
use WoocommerceMl\Algorithm\Apriori as WCML_Aproiori;
/**
 * Main class
 */
class App 
{

    private $aprioriModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', [$this, 'run']); //Wait for WooCommerce to be loaded
        add_action('woocommerce_after_add_to_cart_button', [$this, 'renderRealtedProductsWidget']); //Wait for WooCommerce to be loaded
    }

    public function renderRealtedProductsWidget()
    {

        $start_time = microtime(true);

        $product_id = get_queried_object_id();
        $products = $this->getAssociatedProducts([$product_id]);
        $products = Helpers::arrayFlatten($products);
        $product = array_unique($products);
        $products_unique = [];
        foreach ($product as $product_id) {
            if (!in_array($product_id, $products_unique)) {
                $products_unique[] = $product_id;
            }
        }

        echo '<hr><div><h3>You may also like:</h3>';
        foreach ($products_unique as $id) {
            echo '<a href="'.get_the_permalink($id).'">';
            echo get_the_title($id);
            echo '</a>';
            echo '<br>';
        }
        echo '</div>';

        $time_elapsed_secs = microtime(true) - $start_time;

        var_dump('renderRealtedProductsWidget running time: '.$time_elapsed_secs.' seconds');
    }

    /**
     * Entry point
     *
     * @return void
     */
    public function run()
    {

        //Check for existing model - use that if possible
        
        //Set up Apriori model
        $model = new WCML_Aproiori();

        //Train model
        $model->train();

        //Set model
        $this->setAprioriModel($model);

        //Now use model! 
    }

    public function getAssociatedProducts($product_id)
    {
        $model = $this->getAprioriModel();
        return $model->predict($product_id);
    }

    /**
     * Getter
     * 
     * Get the value of aprioriModel
     * 
     * @return WCML_Apriori 
     */ 
    public function getAprioriModel()
    {
        return $this->aprioriModel;
    }

    /**
     * Setter
     * 
     * Set the value of aprioriModel
     *
     * @return self
     */ 
    private function setAprioriModel($aprioriModel)
    {
        $this->aprioriModel = $aprioriModel;

        return $this;
    }
}
