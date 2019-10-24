<?php

namespace WoocommerceMl;

use Phpml\Association\Apriori;
use WoocommerceMl\Apriori as WcmlApriori;

class App {

    private $modelLabel;
    private $model;

    /**
     * Set the model for the app to use
     */
    public function __construct($modelLabel)
    {
        $this->modelLabel = $modelLabel;
        
        $this->setModel($modelLabel);

        add_action('init', [$this, 'run']);

    }

     /**
     * Do the things!
     */
    public function run()
    {

        //Get data specific to model
        $trainingData = $this->getTrainingData();

        echo '<h2>Basket data</h2>';
        echo '<ol>';
        foreach($trainingData as $ids) {
            echo '<li>';
                echo '<ul>';
                foreach($ids as $id) {
                    echo '<li>';
                    echo get_the_title($id)." (ID:$id)";
                    echo '</li>';
                }
                echo '</ul>';
            echo '</li>';
        }
        echo '</ol>';

        echo '<hr>';

        $this->trainModel($trainingData);

        echo '<p>Doing the predictings...</p>';

        echo '<hr>';

        $product_id = 21;

        echo '<h2>Prediction for '.get_the_title($product_id)." (ID:$product_id)".'</h2>';

        $associatedProductIdSets = $this->predict([$product_id]);

        echo '<ul>';

        foreach($associatedProductIdSets as $ids) {

            foreach($ids as $id) {
                echo '<li>';
                echo get_the_title($id)." (ID:$id)";
                echo '</li>';
            }
        }
        echo '</ul>';
        

        return;
        
    }

    public function setModel(string $modelLabel)
    {
        switch ($modelLabel) {
            case 'apriori':
                $this->model = new Apriori($support = 0.5, $confidence = 0.5);
                break;
            
            default:
                # code...
                break;
        }
        
    }

    public function trainModel($trainingData, $labels = [])
    {
        $this->model->train($trainingData, $labels);
    }

    public function predict(array $input)
    {
        return $this->model->predict($input);
    }

    public function getTrainingData()
    {
        switch ($this->modelLabel) {
            case 'apriori':
                return (new WcmlApriori)->getTrainingData();
                break;
            
            default:
                # code...
                break;
        }
    }

}
