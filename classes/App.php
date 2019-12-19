<?php

namespace WoocommerceMl;

use WoocommerceMl\Outputter\HtmlOutputter;
use WoocommerceMl\Helpers;
use WoocommerceMl\Storage;
use WoocommerceMl\Algorithm\Apriori as WCML_Aproiori;
use Phpml\Association\Apriori;

/**
 * Main class
 * 
 * @category WCML
 * @package  WCML
 * @author   10 Degrees <hello@10degrees.uk>
 * @license  GPL 2.0 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     www.example.com
 */
class App
{
    private $aprioriModel;//phpcs:ignore
    private $model;//phpcs:ignore
    private $dataInterface;//phpcs:ignore
    private $options;//phpcs:ignore

    /**
     * Constructor
     */
    public function __construct(Options $options)
    {
        $this->options = $options;//Set options
        add_action('init', [$this, 'run']); 

        //Do things based on options 

        // $this->model = $model;//PHP-ML Model
        // $this->dataInterface = $dataInterface;//Interface for getting datas

        // add_action('init', [$this, 'run']); //Wait for WooCommerce to be loaded
        // add_action('woocommerce_after_add_to_cart_button', [$this, 'renderRealtedProductsWidget']); //Wait for WooCommerce to be loaded
    }



    /**
     * Fetch options
     * 
     * Get options from the WP options table 
     *
     * @return void
     */
    private function fetchOptions()
    {
        $options = [];
        // $options['models']['apriori'];
        // $options['implementations']['single-products-widget'];
        return $options;
    }

    private function fetchModel()
    {

    }

    public function renderRealtedProductsWidget()
    {
        $start_time = microtime(true);
        $product_id = get_queried_object_id();
        $products = $this->model->predict([$product_id]);
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
        $optionsValues = $this->options->getOptionsWithValues();

        if ($optionsValues['single_product_recommendation_widget_enable']) {
            $support = $optionsValues['single_product_recommendation_widget_confidence'] ?  floatval($optionsValues['single_product_recommendation_widget_confidence']) : 0.5;
            $confidence = $optionsValues['single_product_recommendation_widget_confidence'] ? floatval($optionsValues['single_product_recommendation_widget_confidence']) : 0.5;
            $aprioriModel = new Apriori($support, $confidence);
            $dataInterface = new WooCommerceDataInterface;
            $trainingData =  $dataInterface->getTrainingData();
            $aprioriModel->train($trainingData);
        }
    }

    public function getAssociatedProducts($product_id)
    {
        return $this->model->predict([$product_id]);
    }

    /**
     * Get the value of aprioriModel
     * 
     * @return WCML_Apriori 
     */ 
    public function getAprioriModel()
    {
        return $this->aprioriModel;
    }

    /**
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
