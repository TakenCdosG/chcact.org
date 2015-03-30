<?php

/* adding New Custom Menus */

register_nav_menus (
	array(
		'left_menu' => __('Left Menu','wpex')
	)
);


/* Menu Walker */

class WPEX_Walker_Nav_Menu_footer extends Walker_Nav_Menu {
	/*function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output) {
	if($element->menu_order !=1 && $element->menu_item_parent == 0){
	//$children_elements = NULL;
	Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}*/

	function walk( $elements, $max_depth){

	foreach($elements as $key => $element){
	if($element->menu_order == 1 || $element->menu_item_parent != 0){
	unset($elements[$key]);
	}
	}

	return Walker_Nav_Menu::walk( $elements, $max_depth);
	}

}

