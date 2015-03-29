<?php
/**
 * Modify WP menu for dropdown styles
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
*/

class WPEX_Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
		
        $id_field = $this->db_fields['id'];
		
        if( !empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
            $element->classes[] = 'dropdown';
            $element->title .= ' <i class="icon-angle-down"></i>';
        }
		
		if( !empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
            $element->classes[] = 'dropdown';
            $element->title .= ' <i class="icon-angle-right"></i>';
        }
				
        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
 
    }
}

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