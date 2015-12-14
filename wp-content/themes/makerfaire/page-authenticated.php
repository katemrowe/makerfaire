<?php
/*
Template name: Authenticated content
*/
if (!is_user_logged_in())
    auth_redirect();

get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content col-md-12">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class(); ?>>

					<?php the_content(); ?>

				</article>

			<?php endwhile; ?>
                	<?php else: ?>

				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

			<?php endif; ?>

		</div><!--Content-->

	</div>

</div><!--Container-->

<?php get_footer(); ?>