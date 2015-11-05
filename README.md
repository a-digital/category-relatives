# category-relatives
ExpressionEngine plugin output information about the currently viewed category.

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
