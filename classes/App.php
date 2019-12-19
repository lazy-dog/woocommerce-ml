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
        $product_id = get_queried_object_id();
        $products = $this->getAssociatedProducts([$product_id]);
        $products = Helpers::arrayFlatten($products);
        $product = array_unique($products);
        $products_unique = [];
        foreach ($product as $product_id) {
            if(!in_array($product_id, $products_unique)) {
                $products_unique[] = $product_id;
            }
        }
        // var_dump($products_unique);

        echo '<hr><div>';
        foreach ($products_unique as $id) {
            echo '<a href="'.get_the_permalink($id).'">';
            echo get_the_title($id);
            echo '</a>';
            echo '<br>';
        }
        echo '</div>';
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
        $start_time = microtime(true);
        $model->train();
        $time_elapsed_secs = microtime(true) - $start_time;

        var_dump('Training time: '.$time_elapsed_secs.' seconds');

        //Set model
        $this->setAprioriModel($model);

        // $rules = $model->getRules();
        // echo 'rules';
        // var_dump($rules);
        // echo 'prediction';
        // var_dump($model->predict([26209]));

        echo '<hr>';

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
