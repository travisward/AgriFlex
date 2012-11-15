<?php
/**
 * Filter functions for the AgriFlex theme
 *
 * @package AgriFlex
 * @since AgriFlex 2.0
 */

/**
 * Custom Body Classes Based On Agency Selected
 *
 * @since AgriFlex 1.0
 * @param array $classes Existing class values
 * @return array $classes Filtered class values
 */
add_filter('body_class','my_class_names');
function my_class_names($classes) {

  $classes[] = '';

  if (class_exists("AgrilifeCustomizer")) {
    GLOBAL $options;

    // Set Header Tabs
    if($options['isResearch']) $classes[] .= 'research';
    if($options['isExtension']) $classes[] .= 'extension';
    if($options['isCollege']) $classes[] .= 'college';
    if($options['isTvmdl'] || $options['isFazd']) $classes[] .= 'tvmdl';
    if($options['isFazd'])$classes[] .= 'fazd';

    // Single Agency Classes
    if($options['isResearch'] && !$options['isExtension'] && !$options['isCollege'] && !$options['isTvmdl']) $classes[] .= 'researchonly';

    if($options['isCollege'] && !$options['isExtension'] && !$options['isResearch'] && !$options['isTvmdl']) $classes[] .= 'collegeonly';

    if($options['isTvmdl'] && !$options['isExtension'] && !$options['isResearch'] && !$options['isCollege']) $classes[] .= 'tvmdlonly';

    if($options['isExtension'] && !$options['isResearch'] && !$options['isCollege'] && !$options['isTvmdl']) :

      $classes[] .= 'extensiononly';              

      // Extension Only Sub-categories
      switch ($options['extension_type']) {
        case 0:
          break;
        case 1:
          $classes[] .= 'extension4h';
          break;
        case 2:
          $classes[] .= 'extensioncounty';
          break;
        case 3:
          $classes[] .= 'extensioncountytce';
          break;
        case 4:
          $classes[] .= 'extensionmg';
          break;
        case 5:
          $classes[] .= 'extensionmn';
          break;
        case 6:
          $classes[] .= 'extensionsg';
          break;
      }
    endif;

  }    

  return $classes;

}

/**
 * Makes some changes to the <title> tag, by filtering the output of wp_title().
 *
 * If we have a site description and we're viewing the home page or a blog posts
 * page (when using a static front page), then we will add the site description.
 *
 * If we're viewing a search result, then we're going to recreate the title
 * entirely.
 *
 * We're going to add page numbers to all titles as well, to the middle of a
 * search result title and the end of all other titles.
 *
 * The site title also gets added to all titles.
 *
 * @since agriflex 1.0
 *
 * @param string $title Title generated by wp_title()
 * @param string $separator The separator passed to wp_title(). Twenty Ten uses a
 *      vertical bar, "|", as a separator in header.php.
 * @return string The new title, ready for the <title> tag.
 */
add_filter( 'wp_title', 'agriflex_filter_wp_title', 10, 2 );
function agriflex_filter_wp_title( $title, $separator ) {

  // Don't affect wp_title() calls in feeds.
  if ( is_feed() )
    return $title;

  // The $paged global variable contains the page number of a listing of
  // posts.
  // The $page global variable contains the page number of a single post that
  // is paged.
  // We'll display whichever one applies, if we're not looking at the first
  // page.
  global $paged, $page;

  if ( is_search() ) {
    // If we're a search, let's start over:
    $title = sprintf( __( 'Search results for %s', 'agriflex' ),
    '"' . get_search_query() . '"' );

    // Add a page number if we're on page 2 or more:
    if ( $paged >= 2 )
      $title .= " $separator " . sprintf( __( 'Page %s', 'agriflex' ), $paged );

    // Add the site name to the end:
    $title .= " $separator " . get_bloginfo( 'name', 'display' );

    // We're done. Let's send the new title back to wp_title():
    return $title;
  }

  // Otherwise, let's start by adding the site name to the end:
  $title .= get_bloginfo( 'name', 'display' );

  // If we have a site description and we're on the home/front page, add the
  // description.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) )
    $title .= " $separator " . $site_description;

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    $title .= " $separator " .
    sprintf( __( 'Page %s', 'agriflex' ), max( $paged, $page ) );

  // Return the new title to wp_title():
  return $title;

}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since agriflex 1.0
 * @return array $args The updated array of menu arguments
 */
add_filter( 'wp_page_menu_args', 'agriflex_page_menu_args' );
function agriflex_page_menu_args( $args ) {

  $args['show_home'] = true;
  return $args;

} // agriflex_page_menu_args

add_filter( 'wp_nav_menu_args', 'agriflex_nav_menu_args' );
function agriflex_nav_menu_args( $args = 'sf-menu' ) {

  $args['menu_class'] = 'sf-menu menu';
  return $args;

} // agriflex_nav_menu_args

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since agriflex 1.0
 * @return int
 */
add_filter( 'excerpt_length', 'agriflex_excerpt_length' );
function agriflex_excerpt_length( $length ) {

     return 88;

} // agriflex_excerpt_length

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since agriflex 1.0
 * @return string "Continue Reading" link
 */
function agriflex_continue_reading_link() {

  return ' <span class="read-more"><a href="'. get_permalink() . '">' .
    __( 'Read More &rarr;', 'agriflex' ) . '</a></span>';

} // agriflex_continue_reading_link

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an
 * ellipsis and agriflex_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since agriflex 1.0
 * @return string An ellipsis
 */
add_filter( 'excerpt_more', 'agriflex_auto_excerpt_more' );
function agriflex_auto_excerpt_more( $more ) {

  return '...' . agriflex_continue_reading_link();

} // agriflex_auto_excerpt_more

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since agriflex 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
add_filter( 'get_the_excerpt', 'agriflex_custom_excerpt_more' );
function agriflex_custom_excerpt_more( $output ) {

  if ( has_excerpt() && ! is_attachment() ) {
    $output .= agriflex_continue_reading_link();
  }

  return $output;

} // agriflex_custom_excerpt_more

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since agriflex 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
add_filter( 'gallery_style', 'agriflex_remove_gallery_css' );
function agriflex_remove_gallery_css( $css ) {

  return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );

} // agriflex_remove_gallery_css

// Custom search
add_filter('get_search_form', 'agriflex_custom_search_form');
function agriflex_custom_search_form() {

  $search_text = get_search_query() ?
    esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) :
    apply_filters('agriflex_search_text', esc_attr__('Search', 'agriflex'));

  $button_text = apply_filters( 'agriflex_search_button_text',
    esc_attr__( 'Go', 'agriflex' ) );

  $onfocus = " onfocus=\"if (this.value == '$search_text') {this.value = '';}\"";

  $onblur = " onblur=\"if (this.value == '') {this.value = '$search_text';}\"";

  $form = '<form method="get" class="searchform" action"' .
    get_option( 'home' ) . '/" >';
  $form .= '<input type="text" value="' . $search_text . '" name="s" class="s"' .
    $onfocus . $onblur . ' />';
  $form .= '<input type="submit" class="searchsubmit" value="' .
    $button_text .'" />';
  $form .= '</form>';

  return apply_filters('custom_search_form', $form, $search_text, $button_text);

} // agriflex_custom_search_form

/**
 * Body classes for admin
 *
 * @since AgriFlex 1.0
 */
add_filter('admin_body_class', 'agriflex_admin_body_class');
function agriflex_admin_body_class( $classes ) {

  // Current action
  if ( is_admin() && isset( $_GET['action'] ) ) {
    $classes .= 'action-' . $_GET['action'];
  }

  // Current post ID
  if ( is_admin() && isset( $_GET['post'] ) ) {
    $classes .= ' ';
    $classes .= 'post-' . $_GET['post'];
  }

  // New post type & listing page
  if ( isset( $_GET['post_type'] ) ) $post_type = $_GET['post_type'];

  if ( isset( $post_type ) ) {
    $classes .= ' ';
    $classes .= 'post-type-' . $post_type;
  }

  // Editting a post type
  $post_query = $_GET['post'];

  if ( isset( $post_query ) ) {
    $current_post_edit = get_post( $post_query );
    $current_post_type = $current_post_edit->post_type;

    if ( !empty( $current_post_type ) ) {
      $classes .= ' ';
      $classes .= 'post-type-' . $current_post_type;
    }
  }

  // Return the $classes array
  return $classes;

} // agriflex_admin_body_class
