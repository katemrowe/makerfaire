<?php
/**
 * Template Name: Makers
 */
get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">
			
			<div class="page-header">
				
				<h1><?php the_title(); ?> <small>Maker Faire Bay Area 2013</small></h1>	
				
			</div>
			
			<?php get_search_form(); ?>
			
			<?php
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$args = array(
				'post_type'		=> 'mf_form',
				'post_status'	=> 'accepted',
				'orderby' 		=> 'title',
				'order'			=> 'asc',
				'posts_per_page'=> 20,
				'paged'			=> $paged
			);
			$my_query = new WP_Query($args);

			if($my_query->have_posts()):
				while($my_query->have_posts()):$my_query->the_post();
					the_mf_content();
					echo '<hr>';
				endwhile;
			?>
			<ul class="pager">
				<li class="previous"><?php previous_posts_link('&larr; Previous Page', $my_query->max_num_pages); ?></li>
				<li class="next"><?php next_posts_link('Next Page &rarr;', $my_query->max_num_pages); ?></li>
			</ul>
			<?php endif; ?>
			<?php wp_reset_query(); ?>

		
		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>
	
</div><!--Container-->

<?php get_footer(); ?>