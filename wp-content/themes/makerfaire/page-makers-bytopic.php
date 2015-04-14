<?php
/**
 * Template Name: Makers By Topic
 */
global $wp_query;
$topic_slug = $wp_query->query_vars['t_slug'];
print_r(get_term_by('slug',$topic_slug,'category'));
$category = get_term_by('slug',$topic_slug,'category');
$search_category = $category->name.':'.$category->term_id;
print_r($search_category);

$f = $wp_query->query_vars['f'];
$search_criteria['field_filters'][] = array( 'key' => '147', 'value' => array( $search_category));
$entries=GFAPI::get_entries(20,$search_criteria);

get_header(); ?>
<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<div class="page-header">

				<h1> <small><?php echo  $topic_slug; ?></small></h1>

			</div>
			
			TOPIC SLUG:	<?php echo $topic_slug;?>
			
			<?php foreach ($entries as $entry) :

			$project_name = isset($entry['151']) ? $entry['151']  : '';
			$entry_id = isset($entry['id']) ? $entry['id']  : '';
				
				?>
						<hr>
			<div class="row">
			<div class="span2"></div><div class="span6">
			<h3><a href="/maker/entry/<?php echo $entry_id; ?>"><?php echo $project_name;?></a></h3>
			<ul class="unstyled"><li>Topics: 
				<a href="#">Topic</a>
			</li>
			</ul>
			</div>
			</div>
			<?php endforeach;?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <?php the_content(); ?>
    <!-- The last holder-->
	<?php endwhile; ?>
    
			<?php endif; ?>
    
		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer(); ?>