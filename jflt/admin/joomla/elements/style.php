<?php

/**
 * @package     gantry
 * @subpackage  admin.elements
 * @version		3.0.11 September 5, 2010
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();


if (defined('DS'))
{
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * @package     gantry
 * @subpackage  admin.elements
 */
class JElementStyle extends JElement
{

    var $_name = 'Text';

    function getTemplate()
    {
//        $texto = __FILE__;
//        $procura = "templates" . DS;
//
//        print_r();
//        exit;
//        $posicao = strpos($texto, $procura);
//        $texto = substr($texto, $posicao + strlen($procura));
//        $procura = DS;
//        $posicao = strpos($texto, $procura);
//        $template = substr($texto, 0, $posicao);
        return $_REQUEST['cid'][0];
    }

    function fetchElement($name, $value, &$node, $control_name)
    {

        $templateURL = JURI::root() . 'templates/' . $this->getTemplate();
        $document = & JFactory::getDocument();

        $document->addStyleSheet($templateURL . '/admin/common/css/mini-grid.css');
        $document->addScript($templateURL . '/admin/common/js/mini-grid.js');

        $document->addStyleSheet($templateURL . '/admin/joomla/css/humrum.css');
        $document->addScript($templateURL . '/admin/joomla/js/humrum.js');




        return '';
    }

}