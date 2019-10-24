<?php

namespace WoocommerceMl\Algorithm;

abstract class Algorithm
{
    private $label;
    protected $trainingModel;// PHP-ML Model
    protected $trainingData;

    public function __construct(string $name = NULL)
    {
        $this->label = $name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    abstract public function getTrainingData();

}
