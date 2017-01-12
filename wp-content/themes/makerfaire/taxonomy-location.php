<?php get_header(); ?>

<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content col-md-8">

			<?php
				$term_obj = get_queried_object();
				echo mf_schedule( array( 'location' => $term_obj->term_id ) );
			?>

		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer(); ?>