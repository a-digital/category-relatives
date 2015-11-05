<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Lounge Categories Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Andrew Armitage
 * @link		http://www.armitageonline.co.uk
 */

$plugin_info = array(
	'pi_name'		=> 'Category relatives',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Andrew Armitage',
	'pi_author_url'	=> 'http://www.adigital.co.uk',
	'pi_description'=> 'Single tag to output information about the currently viewed category.',
	'pi_usage'		=>  Category_relatives::usage()
);

class Category_relatives {
    
	public $return_data;

	/**
	 * Constructor
	 */
	public function __construct()
	{	

	}//end __construct()
	
	public function count_children() {
		
		$category_url_title = ee()->TMPL->fetch_param('category');
		$cat_group_id = ee()->TMPL->fetch_param('category_group');
					
		// Count the number of children underneath the current category
		$child_cats = ee()->db->query("SELECT COUNT(*) AS total FROM exp_categories WHERE exp_categories.group_id = '" . $cat_group_id . "' AND exp_categories.parent_id <> 0
AND 
(SELECT exp_categories.cat_id FROM exp_categories WHERE exp_categories.cat_url_title = '" . $category_url_title . "' AND exp_categories.group_id = '" . $cat_group_id . "') = exp_categories.parent_id ORDER BY exp_categories.cat_order ASC");

		$vars = array();

		if($child_cats->num_rows() > 0)
		{
		    $arr = $child_cats->result_array();
		    return $arr['0']['total'];
		}		
	}
	
	public function has_parent() {
		$category_url_title = ee()->TMPL->fetch_param('category');
		$cat_group_id = ee()->TMPL->fetch_param('category_group');  		
		// Does this category have a parent?
		$parent = ee()->db->query("SELECT parent_id FROM exp_categories WHERE exp_categories.group_id = '" . $cat_group_id . "' AND cat_url_title = '" . $category_url_title . "'");

		$vars = array();

		if($parent->num_rows() > 0)
		{
		    $arr = $parent->result_array();
		    return $arr['0']['parent_id'];
		}		
	}
	
	public function parent_name() {
		$category_url_title = ee()->TMPL->fetch_param('category');
		$cat_group_id = ee()->TMPL->fetch_param('category_group');  		
		// Does this category have a parent?
		$parent = ee()->db->query("SELECT parent_id FROM exp_categories WHERE exp_categories.group_id = '" . $cat_group_id . "' AND cat_url_title = '" . $category_url_title . "'");

		$vars = array();

		if($parent->num_rows() > 0)
		{
		    $arr = $parent->result_array();
		    $parent_name =  $arr['0']['parent_id'];
		    
		    $get_parent_id = ee()->db->query("SELECT cat_name FROM exp_categories WHERE cat_id = '" . $parent_name . "'");
		    
		   if($get_parent_id->num_rows() > 0)
				{
				    $arr = $get_parent_id->result_array();
				    return $arr['0']['cat_name'];
				}		
		    
		}		
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

This is a single tag which requires parameters for category and category_group. Category Group is required as EE allows categories to share the same name and url_title, so this additional parameter avoids any ambiguity. It would most likely be used in conjunction with http://gwcode.com/add-ons/gwcode-categories which provides greater access to the category tree than the native channel categories tag.

If Structure is being used with Zoo Triggers, the category will need to be extracted using the {triggers:segment_x} tag. Otherwise, the normal {segment_x} tag can be used depending on the location within the category URL structure.

The tag outputs the following:

--
Number of children beneath the current category:
{exp:category_relatives:count_children category="{triggers:segment_4}" category_group="2"}

Output: eg. 6
--
Whether the current category has a parent:
{exp:category_relatives:has_parent category="{triggers:segment_4}" category_group="2"}

Output: eg: 12. NB. This isn't a boolean output, but the category ID of the current parent. A category with no parent will have a parent_id of 0.

--
The title of the parent category:
{exp:category_relatives:parent_name category="{triggers:segment_4}" category_group="2"}

Output: eg. Food and Drink


<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.lounge_categories.php */
/* Location: /system/expressionengine/third_party/lounge_categories/pi.lounge_categories.php */