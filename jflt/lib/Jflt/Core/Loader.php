<?php

// no direct access
defined('JFLT_EXEC') or die('Restricted access');

class Jflt_Core_Loader
{

    /**
     * Loads a class from specified directories.
     *
     * @param string $name    The class name to look for ( '_' notation ).
     * @return void
     */
    function import($classNeed)
    {

        //lib folder
        $basePath = realpath(dirname(__FILE__) . '/../..');
        $parts = explode('_', $classNeed);
        foreach ($parts as &$part)
        {
            $part = ucfirst(strtolower($part));
        }

        $fileName = array_pop($parts);
        $filePath = implode(DS, $parts);
        $fullFilePath = $basePath . DS . $filePath . DS . $fileName . '.php';

        if (file_exists($fullFilePath))
        {
            require_once ($fullFilePath);
        } else
        {
            throw new Jflt_Exception('File requested not exist "' . $fullFilePath . '"');
        }
    }

}

/**
 * Intelligent file importer
 *
 * @access public
 * @param string $class 
 */
function JfltImport($class)
{
    
    Jflt_Core_Loader::import($class);
}
/**
 *
 * @param type $class
 * @return class 
 */
function JfltLoad($class)
{
    Jflt_Core_Loader::import($class);

    if (class_exists($class))
    {
        return new $class();
    }

    return null;
}