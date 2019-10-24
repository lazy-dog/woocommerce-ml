<?php

namespace WoocommerceMl;

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
        $model = new WCML_Aproiori();
        $trainingData = $model->getTrainingData();
        $model->trainModel($trainingData);
        $result = $model->predict([21]);
        $model->outputPrediction($result, 21);
    }

}
