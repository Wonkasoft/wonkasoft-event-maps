<?php

/**
 * This file builds a custom search form for searching events
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 *
 * @package    Wonkasoft_Event_Maps
 * @subpackage Wonkasoft_Event_Maps/includes
 */

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function wem_custom_search_form( $form ) {

    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
    <input type="search" value="' . get_search_query() . '" name="s" id="s" />
    <button type="submit" id="search-submit"></button>
    <input type="hidden" value="page" name="post_type" id="post_type" />
    </div>
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'wem_custom_search_form' );