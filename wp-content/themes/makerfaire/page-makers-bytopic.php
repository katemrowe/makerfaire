<?php
/**
 * Template Name: Makers By Topic
 */

// Check what faire taxonomy we need to display
//$current_faire_slug = get_post_meta( $post->ID, '_faire-tax-archive', true );
//$faire = ( ! empty( $current_faire_slug ) || $current_faire_slug != 'none' ) ? get_term_by( 'slug', sanitize_text_field( $current_faire_slug ), 'faire' ) : '';
global $wp_query;
$topic_slug = $wp_query->query_vars['t_slug'];

get_header(); ?>
<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<div class="page-header">

				<h1><?php the_title(); ?> <small><?php echo esc_html( $topic_slug ); ?></small></h1>

			</div>

			TOPIC SLUG:	<?php echo $topic_slug;?>
		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer(); ?>