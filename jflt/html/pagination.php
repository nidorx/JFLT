<?php
/**
 * @package   Template Overrides - RocketTheme
 * @version   3.0.11 September 5, 2010
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Rockettheme Gantry Template uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 *	 Input variable $list is an array with offsets:
 *		 $list[limit]		: int
 *		 $list[limitstart]	: int
 *		 $list[total]		: int
 *		 $list[limitfield]	: string
 *		 $list[pagescounter]	: string
 *		 $list[pageslinks]	: string
 *
 * pagination_list_render
 *	 Input variable $list is an array with offsets:
 *		 $list[all]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[start]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[previous]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[next]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[end]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[pages]
 *			 [{PAGE}][data]		: string
 *			 [{PAGE}][active]	: boolean
 *
 * pagination_item_active
 *	 Input variable $item is an object with fields:
 *		 $item->base	: integer
 *		 $item->link	: string
 *		 $item->text	: string
 *
 * pagination_item_inactive
 *	 Input variable $item is an object with fields:
 *		 $item->base	: integer
 *		 $item->link	: string
 *		 $item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

function pagination_list_footer($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<div class=\"list-footer\">\n";

	$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	$html .= $list['pageslinks'];
	$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";

	return $html;
}

function pagination_list_render($list)
{


    /*


     <span>
                              <ul id="navigator">
                                <li><a href="#"><span class="nav">�</span></a></li>
                                <li><a href="#"><span class="nav">1</span></a></li>
                                <li><a href="#"><span class="nav">2</span></a></li>
                                <li class="active"><a href="#"><span class="nav">3</span></a></li>
                                <li><a href="#"><span class="nav">4</span></a></li>
                                <li><a href="#"><span class="nav">5</span></a></li>
                                <li><a href="#"><span class="nav">�</span></a></li>
                                <li><span>...</span class="nav"></li>
                                <li><a href="#"><span class="nav">�</span></a></li>
                              </ul>
                              </span>
     


     */

	// Initialize variables
	$lang =& JFactory::getLanguage();

	$html = "<ul id=\"pagination-list\">\n<li class=\"tab\">"."\n".$list['start']['data']."</li>";

	$html .= "\n<li class=\"tab\">"."\n".$list['previous']['data']."</li>";

	foreach( $list['pages'] as $page )
	{
		if($page['data']['active']) {
			//$html .= '<strong>';
		}

		$html .= "\n<li class=\"page-block\">".$page['data']."</li>";

		if($page['data']['active']) {
			//  $html .= '</strong>';
		}
	}

	$html .= "\n<li class=\"tab\">"."\n".$list['next']['data']."</li>";
	$html .= "\n<li class=\"tab\">"."\n".$list['end']['data']."</li><ul>";
	// $html .= '&#171;';

	return $html;
}

function pagination_item_active(&$item) {
	return "<span><a href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a></span>";
}

function pagination_item_inactive(&$item) {
	return "<span class=\"active\">".$item->text."</span>";
}
?>