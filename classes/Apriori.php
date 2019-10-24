<?php

namespace WoocommerceMl;

class Apriori extends Algorithm implements DataInterface
{
    private $label;

    public function __construct(string $name = 'apriori')
    {
        $this->label = $name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getTrainingData() 
    {

        $query = new \WC_Order_Query( array(
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'return' => 'ids',
        ));

        $orders = $query->get_orders();

        $orderSets = []; 

        foreach ($orders as $order_id) {

            $basket = [];

            $order = wc_get_order( $order_id );

            foreach( $order->get_items() as $item_id => $item ) {

                $basket[] = $item->get_product_id();
            }

            $orderSets[] = $basket;
        }

        return $orderSets;
    }

    public function outputTrainingData($trainingData){

        
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
        
    }

    public function outputPrediction($associatedProductIdSets, $product_id){


        echo '<h2>Prediction for '.get_the_title($product_id)." (ID:$product_id)".'</h2>';

        

        echo '<ul>';

        foreach($associatedProductIdSets as $ids) {

            foreach($ids as $id) {
                echo '<li>';
                echo get_the_title($id)." (ID:$id)";
                echo '</li>';
            }
        }
        echo '</ul>';
    }

    

}
