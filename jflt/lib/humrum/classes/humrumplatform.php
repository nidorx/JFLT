<?php

/**
 * @package jflt
 * @subpackage  core
 * @version 0.2.0 Dezembro 2010
 * @author Alex Rodin - contato@alexrodin.com (email,msn,gtalk)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * jflt! template system usa o Framework Joomla (http://www.joomla.org), um cms GNU/GPLv2
 *
 * This implementation is based on the work from Chris Schuld
 *  http://chrisschuld.com/projects/browser-php-detecting-a-users-browser-from-php/
 */
// bloqueando acessos diretos
defined('JFLT_EXEC') or die('Restricted access');

class HumrumPlatform {

    private $_agent = '';
    private $_platform = '';
    private $_os = '';

    
    // Hold an instance of the class
    private static $instance;

    // The singleton method
    public static function get() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    // A private constructor; prevents direct creation of object
    private function __construct() {
        $this->reset();
        $this->checkPlatform();
    }

    /**
     * Reset all properties
     */
    public function reset() {
        $this->_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $this->_platform = PLATFORM_UNKNOWN;
        $this->_os = OPERATING_SYSTEM_UNKNOWN;
    }

    /**
     * Returns a formatted string with a summary of the details of the browser.
     * @return string formatted string with a summary of the browser
     */
    public function __toString() {
        return "<strong>Platform:</strong>{$this->getPlatform()}<br/>";
    }

    public function getPlataform() {
        return $this->_platform;
    }

    /**
     * Determine the user's platform
     */
    protected function checkPlatform() {
        if (stripos($this->_agent, 'windows') !== false) {
            $this->_platform = PLATFORM_WINDOWS;
        } else if (stripos($this->_agent, 'iPad') !== false) {
            $this->_platform = PLATFORM_IPAD;
        } else if (stripos($this->_agent, 'iPod') !== false) {
            $this->_platform = PLATFORM_IPOD;
        } else if (stripos($this->_agent, 'iPhone') !== false) {
            $this->_platform = PLATFORM_IPHONE;
        } elseif (stripos($this->_agent, 'mac') !== false) {
            $this->_platform = PLATFORM_APPLE;
        } elseif (stripos($this->_agent, 'android') !== false) {
            $this->_platform = PLATFORM_ANDROID;
        } elseif (stripos($this->_agent, 'linux') !== false) {
            $this->_platform = PLATFORM_LINUX;
        } else if (stripos($this->_agent, 'Nokia') !== false) {
            $this->_platform = PLATFORM_NOKIA;
        } else if (stripos($this->_agent, 'BlackBerry') !== false) {
            $this->_platform = PLATFORM_BLACKBERRY;
        } elseif (stripos($this->_agent, 'FreeBSD') !== false) {
            $this->_platform = PLATFORM_FREEBSD;
        } elseif (stripos($this->_agent, 'OpenBSD') !== false) {
            $this->_platform = PLATFORM_OPENBSD;
        } elseif (stripos($this->_agent, 'NetBSD') !== false) {
            $this->_platform = PLATFORM_NETBSD;
        } elseif (stripos($this->_agent, 'OpenSolaris') !== false) {
            $this->_platform = PLATFORM_OPENSOLARIS;
        } elseif (stripos($this->_agent, 'SunOS') !== false) {
            $this->_platform = PLATFORM_SUNOS;
        } elseif (stripos($this->_agent, 'OS\/2') !== false) {
            $this->_platform = PLATFORM_OS2;
        } elseif (stripos($this->_agent, 'BeOS') !== false) {
            $this->_platform = PLATFORM_BEOS;
        } elseif (stripos($this->_agent, 'win') !== false) {
            $this->_platform = PLATFORM_WINDOWS;
        }
    }

}
?>



<?php
/*
$platform = Platform::get();
print_r($platform);

*/
?>