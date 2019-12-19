<?php

namespace WoocommerceMl;

use Phpml\ModelManager;

/**
 * Responsible persisting trained models
 */
class Storage
{
    private static $instance = null;
    protected static $directoryName;
    protected static $modelManager;

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->directoryName = trailingslashit(wp_upload_dir().'WCML');
        $this->modelManager =  new ModelManager();
    } 

    /**
     * Get instance
     *
     * @return Storage Instance of storage class
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Storage();
        }

        return self::$instance;
    }

    /**
     * Persist a trained model to the filesystem
     *
     * @param string    $filename Name of file
     * @param Algorithm $model    A model 
     * 
     * @return void
     */
    public function storeModel(string $filename, Algorithm $model)
    {
        $this->modelManager->saveToFile($model, $this->directoryName.$filename);
    }

    public function getModel($filename)
    {
        $this->modelManager->restoreFromFile($this->directoryName.$filename);
    }

}
