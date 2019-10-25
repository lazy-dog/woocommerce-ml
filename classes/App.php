<?php

namespace WoocommerceMl;

use WoocommerceMl\Outputter\HtmlOutputter;
use WoocommerceMl\Algorithm\Apriori as WCML_Aproiori;

class App {

    /**
     * Set the model for the app to use
     */
    public function __construct($modelLabel)
    {
        add_action('init', [$this, 'run']); //Wait for WooCommerce to be loaded
    }

     /**
     * Do the things!
     */
    public function run()
    {

        $model = new WCML_Aproiori(new HtmlOutputter);//Pass outputter class
        $trainingData = $model->getTrainingData();
        $model->trainModel($trainingData);
        $product_id = 32;
        $result = $model->predict([$product_id]);

        if(is_admin()) {
            return;
        }


        $model->outputTrainingData($trainingData);



        $model->outputPrediction($result, $product_id);
        echo '<hr>';
        $product_id = 22;
        $result = $model->predict([$product_id]);
        $model->outputPrediction($result, $product_id);
    }

}
