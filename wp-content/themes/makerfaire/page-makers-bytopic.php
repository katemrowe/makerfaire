<?php
/**
 * Template Name: Makers By Topic
 */
global $wp_query;
$topic_slug = $wp_query->query_vars['t_slug'];
$category = get_term_by('slug',$topic_slug,'category');
$search_category = $category->name.':'.$category->term_id;
$offset = $wp_query->query_vars['offset'];
print_r( $wp_query->query_vars['offset']);

$total_count = 0;
$f = $wp_query->query_vars['f'];
$search_criteria['field_filters'][] = array( 'key' => '147', 'value' => array( $search_category));
$entries=GFAPI::get_entries(20,$search_criteria,null,array('offset' => $offset, 'page_size' => 20 ),$total_count);

// Load Categories
$cats_tags = get_categories(array('hide_empty' => 0));




get_header(); ?>
<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">

			<div class="page-header">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
				<h1> <small><?php echo  $topic_slug; ?></small></h1>

			</div>
			
			TOPIC:	<?php echo $topic_slug;?>
			PAGE: <?php echo $offset;?>
			TOTAL :<?php echo $total_count;?>
			
			<?php foreach ($entries as $entry) :
			print_r($entry['147']);
			$project_name = isset($entry['151']) ? $entry['151']  : '';
			$entry_id = isset($entry['id']) ? $entry['id']  : '';
			foreach ($cats_tags as $cat) {
				if ($cat->slug != 'uncategorized') {
					if (strlen($entry['147.1']) > 0)  $topicsarray[] = $entry[$topic['id']];
	
				}
			}
				
				?>
						<hr>
			<div class="row">
			<div class="span2"></div><div class="span6">
			<h3><a href="/maker/entry/<?php echo $entry_id; ?>"><?php echo $project_name;?></a></h3>
			
			</div>
			</div>
			<?php endforeach;?>
		
    <?php the_content(); ?>
    <!-- The last holder-->
	<?php endwhile; ?>
    
			<?php endif; ?>
    
		</div><!--Content-->

		<?php get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer(); ?>