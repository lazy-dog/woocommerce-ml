<?php

namespace WoocommerceMl\Outputter;

use WoocommerceMl\Outputter\OutputInterface;

class HtmlOutputter implements OutputInterface{

    public function output()
    {
        return  'this is html output';
    }
}
