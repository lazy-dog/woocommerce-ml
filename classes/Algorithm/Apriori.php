<?php

namespace WoocommerceMl\Algorithm;

use Phpml\Association\Apriori as PhpML_Apriorio;
use WoocommerceMl\Outputter\OutputInterface;

class Apriori extends Algorithm
{
    public function __construct()
    {
        $this->trainingModel = new PhpML_Apriorio($support = 0.1, $confidence = 0.5);
    }

    public function predict(array $input)
    {
        return $this->trainingModel->predict($input);
    }

    public function train()
    {
        $trainingData = $this->getTrainingData();
        $this->trainModel($trainingData);
    }

    private function trainModel($trainingData, $labels = [])
    {
        $this->trainingModel->train($trainingData, $labels);
        return $this;
    }

    public function getTrainingData() 
    {
        if (class_exists('WC_Order_Query')) {
           
            $query = new \WC_Order_Query( 
                array(
                    'limit' => -1,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'return' => 'ids',
                )
            );

            $orders = $query->get_orders();

            $orderSets = []; 

            foreach ($orders as $order_id) {
                $basket = [];
                $order = wc_get_order($order_id);
                foreach ($order->get_items() as $item_id => $item) {
                    $basket[] = $item->get_product_id();
                }
                $orderSets[] = $basket;
            }

            return $orderSets;

        }

        $orders = wc_get_orders(array(
            'limit' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'return' => 'ids',
        ));

        $orderSets = []; 

        foreach ($orders as $order_id) {
            $basket = [];
            $order = wc_get_order($order_id);
            foreach ($order->get_items() as $item_id => $item) {
                $basket[] = $item['id'];
            }
            $orderSets[] = $basket;
        }

        return $orderSets;

    }
}
