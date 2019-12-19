<?php

namespace WoocommerceMl;

/**
 * Administrator options
 * 
 * @category WCML
 * @package  WCML
 * @author   10 Degrees <hello@10degrees.uk>
 * @license  GPL 2.0 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     www.example.com
 */
class Options
{
    protected $optionsWithLabels;
    protected $optionsWithValues;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->optionsWithLabels = [
            'single_product_recommendation_widget_enable' => __('Enable product recommendation widget?'),
            'single_product_recommendation_widget_confidence'=> __('Set confidence'),
            'single_product_recommendation_widget_support'=> __('Set support'),
        ];
    }

    /**
     * Fetches options from database and 
     * sets them as a property 
     *
     * @return void
     */
    public function fetchOptions()
    {
        foreach ($this->optionsWithLabels as $key=>$value) {
            $this->optionsWithValues[$key] = $value;
        }
    }
    
    /**
     * Get the value of optionsWithValues
     * 
     * @return array $options An array of options with associated values
     */ 
    public function getOptionsWithValues()
    {
        return $this->optionsWithValues;
    }

    /**
     * Get the value of optionsWithLabels
     * 
     * @return array $options An array of options with associated labels
     */ 
    public function getOptionsWithLabels()
    {
        return $this->optionsWithLabels;
    }
}
