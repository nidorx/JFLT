<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * @package		Joomla.Framework
 */
class JFTLoader {

    /**
     * Loads a class from specified directories.
     *
     * @param string $name	The class name to look for ( dot notation ).
     * @param string $base	Search this directory for the class.
     * @param string $key	String used as a prefix to denote the full path of the file ( dot notation ).
     * @return void
     */
    function import($filePath, $base = null, $key = 'libraries.') {
        static $paths;

        if (!isset($paths)) {
            $paths = array();
        }

        $keyPath = $key ? $key . $filePath : $filePath;

        if (!isset($paths[$keyPath])) {
            if (!$base) {
                $base = dirname(__FILE__);
            }

            $parts = explode('.', $filePath);

            $classname = array_pop($parts);
            
            $classname = ucfirst($classname);
                   
            $path = str_replace('.', DS, $filePath);

            if (strpos($filePath, 'nidorx') === 0) {
                /*
                 * If we are loading a JFT class prepend the classname with a
                 * capital JFT.
                 */
                $classname = 'JFT' . $classname;
                $classes = JFTLoader::register($classname, $base . DS . $path . '.php');
                $rs = isset($classes[strtolower($classname)]);
            } else {
                /*
                 * If it is not in the joomla namespace then we have no idea if
                 * it uses our pattern for class names/files so just include.
                 */
                $rs = include($base . DS . $path . '.php');
            }

            $paths[$keyPath] = $rs;
        }

        return $paths[$keyPath];
    }

    /**
     * Add a class to autoload
     *
     * @param	string $classname	The class name
     * @param	string $file		Full path to the file that holds the class
     * @return	array|boolean  		Array of classes
     */
    function & register($class = null, $file = null) {
        static $classes;

        if (!isset($classes)) {
            $classes = array();
        }

        if ($class && is_file($file)) {
            // Force to lower case.
            $class = strtolower($class);
            $classes[$class] = $file;

            // In php4 we load the class immediately.
            if ((version_compare(phpversion(), '5.0') < 0)) {
                JFTLoader::load($class);
            }
        }

        return $classes;
    }

    /**
     * Load the file for a class
     *
     * @access  public
     * @param   string  $class  The class that will be loaded
     * @return  boolean True on success
     */
    function load($class) {
        $class = strtolower($class); //force to lower case

        if (class_exists($class)) {
            return;
        }

        $classes = JFTLoader::register();
        if (array_key_exists(strtolower($class), $classes)) {
            include($classes[$class]);
            return true;
        }
        return false;
    }

}

/**
 * When calling a class that hasn't been defined, __autoload will attempt to
 * include the correct file for that class.
 *
 * This function get's called by PHP. Never call this function yourself.
 *
 * @param 	string 	$class
 * @access 	public
 * @return  boolean
 */
function __autoload($class) {
    if (JFTLoader::load($class)) {
        return true;
    }
    return false;
}

/**
 * Global application exit.
 *
 * This function provides a single exit point for the framework.
 *
 * @param mixed Exit code or string. Defaults to zero.
 */
function JFTexit($message = 0) {
    exit($message);
}

/**
 * Intelligent file importer
 *
 * @access public
 * @param string $path A dot syntax path
 * @since 1.5
 */
function JFTimport($path) {
    return JFTLoader::import($path);
}
