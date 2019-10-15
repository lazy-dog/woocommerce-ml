<?php

namespace WoocommerceMl;

use Phpml\Association\Apriori;

class WoocommerceMl
{

    protected $aprioriAssociator;
    protected $samples;
    protected $labels;

    public function __construct()
    {

        //On creation fetch persisted model
        //If none exists new one up
        $this->associator = new Apriori($support = 0.5, $confidence = 0.5);
        $this->labels = [];
        $this->samples = [
            ['alpha', 'beta', 'epsilon'],
            ['alpha', 'beta', 'theta'],
            ['alpha', 'beta', 'epsilon'],
            ['alpha', 'beta', 'theta']
        ];

        $this->main();

    }

    public function main()
    {
        //Just for tests
        $prediction = $this->train($this->samples, $this->labels)
            ->predict(['alpha','theta']);

        // var_dump($prediction[0][0]);

    }

    public function train($samples, $labels)
    {
        //@TODO create samples from WC Orders
        $this->associator->train($samples, $labels);
        return $this;
    }

    public function predict(array $input)
    {
        return $this->associator->predict($input);
    }
}
