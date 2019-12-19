<?php

namespace WoocommerceMl\Data;

class WooCommerceDataInterface implements DataInterface
{
    /*
     * Gets training data for Apriori algorithm
     *
     * @return void
     */
    public function getTrainingData()
    {
        if (class_exists('WC_Order_Query')) {
           
            $query = new \WC_Order_Query( 
                array(
                    'limit' => 100,
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
            'limit' => 100,
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
