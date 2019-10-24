<?php

namespace WoocommerceMl;

use Phpml\Association\Apriori;
use WoocommerceMl\Apriori as WcmlApriori;

class App {

    private $modelLabel;//e.g. apriori
    private $trainingModel;// PHP-ML Model
    private $model; //WCML Model
    private $debug = false;

    /**
     * Set the model for the app to use
     */
    public function __construct($modelLabel)
    {
        $this->modelLabel = $modelLabel;
        add_action('init', [$this, 'run']); //Wait for WooCommerce to be loaded
    }

     /**
     * Do the things!
     */
    public function run()
    {
        ob_start();
        //Choose a model
        $this->setModel($this->modelLabel);

        //Get data to train a model
        $trainingData = $this->model->getTrainingData();

        //Output the data passed to the model
        $this->model->outputTrainingData($trainingData);

        //Train the model
        $this->trainModel($trainingData);

        echo '<hr>';

        //Predict
        $associatedProductIdSets = $this->predict([21]); //Pass product ID

        //Output prediction
        $this->model->outputPrediction($associatedProductIdSets, $product_id);

        $output = ob_get_clean();

        if($this->debug) {
            echo $output;
        }

        return;
    
    }

    /**
     * Set training model and WCML model
     */
    public function setModel(string $modelLabel)
    {
        switch ($modelLabel) {
            case 'apriori':
                $this->trainingModel = new Apriori($support = 0.5, $confidence = 0.5);
                $this->model = new WcmlApriori;
                break;
            
            default:
                # code...
                break;
        }
        
    }

    /**
     * Train model
     */
    public function trainModel($trainingData, $labels = [])
    {
        $this->trainingModel->train($trainingData, $labels);
    }

    /**
     * Get prediction
     */
    public function predict(array $input)
    {
        return $this->trainingModel->predict($input);
    }

}
