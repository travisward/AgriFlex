<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage agriflex
 * @since agriflex 1.0
 */

get_header(); ?>

<div id="wrap">
	<div id="content" role="main">
	<?php
		/* Queue the first post, that way we know
		 * what date we're dealing with (if that is the case).
		 *
		 * We reset this later so we can run the loop
		 * properly with a call to rewind_posts().
		 */
		if ( have_posts() )
			the_post();
	?>
	
				<h1 class="page-title">
				<?php if ( is_day() ) : ?>
					<?php printf( __( 'Daily Archives: <span>%s</span>', 'agriflex' ), get_the_date() ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Monthly Archives: <span>%s</span>', 'agriflex' ), get_the_date('F Y') ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Yearly Archives: <span>%s</span>', 'agriflex' ), get_the_date('Y') ); ?>				
				<?php elseif ( 'tests' == get_post_type() && $istvmdlonly) : ?>
					<?php _e( 'Test Search', 'agriflex' ); ?>
				<?php else : ?>
					<?php _e( 'Blog Archives', 'agriflex' ); ?>							
				<?php endif; ?>
				</h1>
	
	<?php 
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();
		
	if ( 'tests' == get_post_type() ) : 
		/* Run the loop for the test search to output the posts.
		 * Uses loop-tests.php.
		 */
		get_template_part( 'loop', 'tests' ); 
	else : 
		/* Run the loop for the archives page to output the posts.
		 * If you want to overload this in a child theme then include a file
		 * called loop-archives.php and that will be used instead.
		 */
		 get_template_part( 'loop', 'archive' );
	
	endif; 
	?>
	</div><!-- #content -->
</div><!-- #wrap -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
