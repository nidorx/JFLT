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

/**
 * @package     gantry
 * @subpackage  admin.elements
 */
class JElementBlock extends JElement {

    function fetchElement($name, $value, &$node, $control_name) {


        $output = "";
        $opensTable = "<table class='paramlist2 admintable' width='100%' cellspacing='1'><tbody><tr><td>";
        $closeTable = "</td></tr></tbody></table>";
        $surroundOpens = "<div id='jft-$name' class='jftparamsblock '>";
        $surroundClose = "</div>";
        $title = "<div class='jft-title block-toggler accordion-toggler' rel='$name'>" . JText::_($node->attributes('label')) . "<span class='arrow'></span></div>";
        $shadow = "<div class='jft-title-shadow'></div>";
        $innerOpens = "<div id='jft-$name-inner' class='jftparamsblock-inner block-content accordion-content'>";
        $innerClose = "</div>";

        if (!defined("BLOCK")) {
            $output = $closeTable . $surroundOpens . $title . $innerOpens . $opensTable;
            define("BLOCK", 1);
        } else {
            $output = $closeTable . $innerClose . $surroundClose . $surroundOpens . $title . $innerOpens . $opensTable;
        }

        return $output;
    }

}