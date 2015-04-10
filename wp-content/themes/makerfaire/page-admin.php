<?php

/*
Template name: No Frills
*/

get_header('admin'); ?>

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