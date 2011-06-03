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
class JElementPositioncontent extends JElement
{
	var	$_name = 'Text';

	function fetchElement($name, $value, &$node, $control_name)
	{
                $value = htmlentities($value);

		/*return '
		<div class="wrapper">
			<input type="text" class="position pos" name="'.$name.'" id="'.$name.'-position" value="'.$value.'" />
		</div>
		';*/

                $size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
                $pos = $node->attributes('position');
        /*
         * Required to avoid a cycle of encoding &
         * html_entity_decode was used in place of htmlspecialchars_decode because
         * htmlspecialchars_decode is not compatible with PHP 4
         */
        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);

		return '<input type="text" name="'.$control_name.'['.$name.']" id="'.$pos.'-position" value="'.$value.'" class="positionContent pos"  '.$size.' />';
	}
}