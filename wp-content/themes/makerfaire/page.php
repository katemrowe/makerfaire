<?php get_header(); 

//determine the parent page slug
 $par_post = get_post($post->post_parent);
 $slug = $par_post->post_name;
?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content col-md-8">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class(); ?>>

					<!--<p class="categories"><?php the_category(', '); ?></p>-->

					<?php /*<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1> */ ?>

					<?php /*<p class="meta top">By <?php the_author_posts_link(); ?>, <?php the_time('Y/m/d \@ g:i a') ?></p> */ ?>

					<?php the_content(); ?>

					<div class="clear"></div>

					<?php /*
					<div class="row">

						<div class="postmeta">

							<div class="span-thumb img-thumbnail">

								<?php echo get_avatar( get_the_author_meta('user_email'), 72); ?>

							</div>

							<div class="span-well well">

								<p>Posted by <?php the_author_posts_link(); ?> | <a href="<?php the_permalink(); ?>"><?php the_time('l F jS, Y g:i A'); ?></a></p>
								<p>Categories: <?php the_category(', '); ?> | <?php comments_popup_link(); ?> <?php edit_post_link('Fix me...', ' | '); ?></p>

							</div>

						</div>

						<div class="clear"></div>

					</div>
					*/ ?>

				</article>

			<?php endwhile; ?>

				<ul class="pager">

					<li class="previous"><?php previous_posts_link('&larr; Previous Page'); ?></li>
					<li class="next"><?php next_posts_link('Next Page &rarr;'); ?></li>

				</ul>

			<?php else: ?>

				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

			<?php endif; ?>

		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer(); ?>
