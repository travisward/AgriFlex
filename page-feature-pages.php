<?php
/**
 * Template Name: Home: Feature Pages
 * @package WordPress
 */

get_header(); ?>
		<div id="wrap">
			<div id="content" role="main">		
				<?php if($tvmdlonly) :?>
				<?php tvmdl_test_search() ?>
				<?php endif; ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>	
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php } ?>				

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'county_ext' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'county_ext' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

<?php endwhile; ?>	
		<div id="home-middle">
		<div class="home-middle-features">
			<?php $my_query = new WP_Query('meta_key=feature-homepage&meta_value=1&showposts=3&post_type=page');
	  		while ($my_query->have_posts()) : $my_query->the_post();
	  		?>
	        <div class="featured-wrap" id="featured-wrapper-<?php echo $count;?>">
			<h3 class="entry-title"><a href="<?php the_permalink();?>"><?php echo get_the_title(); ?></a></h3>
			<p><a href="<?php the_permalink();?>"><?php if ( has_post_thumbnail() ) {
  the_post_thumbnail('featured-mediabox'); 
} else  { 
	echo '<img src="'.get_bloginfo("template_url").'/images/AgriLife-default-post-image.png" alt="AgriLife Logo" title="AgriLife" />'; 
	}
	?></a></p>
		<?php the_excerpt();?>
			</div><!-- end .featured-wrap -->
			<?php endwhile;  wp_reset_query; ?>	
													
		</div><!-- end .home-features -->		
			
		<div class="home-middle-1">
			<?php if (!dynamic_sidebar('Home Page Bottom')) : ?>
			<div class="widget">
				<h2><?php _e("Home Page Bottom Widget", 'county_ext'); ?></h2>
				<p><?php _e("This is a widgeted area which is called Home Middle #1. To get started, log into your WordPress dashboard, and then go to the Appearance > Widgets screen. There you can drag the widget into the Home Middle #1 widget area on the right hand side. To get the image to display, simply upload an image through the media uploader on the edit post screen and publish your page. The Featured Page widget will know to display the post image as long as you select that option in the widget interface.", 'genesis'); ?></p>
			</div>		
			<?php endif; ?>
		</div><!-- end .home-middle-1 -->
		</div><!-- end #home-middle -->				
			</div><!-- #content -->
		</div><!-- #wrap -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>