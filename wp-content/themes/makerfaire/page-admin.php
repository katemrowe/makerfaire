<?php
add_action('wp_print_scripts','example_dequeue_myscript');
function example_dequeue_myscript() {
	wp_dequeue_script( 'jquery-main' );
}
/*
Template name: Admin No Sidebar
*/
get_header('admin'); 

?>

<div class="clear"></div>
<div class="container">
	<div class="content">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>

			<?php endwhile; ?>


			<?php else: ?>

				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

			<?php endif; ?>

		</div><!--Content-->

</div><!--Container-->

<?php get_footer('admin'); ?>