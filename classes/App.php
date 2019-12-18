<?php

namespace WoocommerceMl;

use WoocommerceMl\Outputter\HtmlOutputter;
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
    }

    /**
     * Entry point
     *
     * @return void
     */
    public function run()
    {
        //Set up Apriori model
        $model = new WCML_Aproiori();

        //Train model
        $model->train();

        //Set model
        $this->setAprioriModel($model);

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
