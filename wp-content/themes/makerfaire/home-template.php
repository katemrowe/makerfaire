<?php
/**
 * Template Name: Home page OLD
 */
get_header();
?>

<div class="clear"></div>

<div class="container">

    <div class="row">

        <div class="content col-md-8">

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <article <?php post_class( 'home-page' ); ?>>

                    <?php the_content(); ?>

                    <div class="clear"></div>

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

    </div>

</div><!--Container-->

<?php get_footer(); ?>

