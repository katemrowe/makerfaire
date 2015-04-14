<?php
/**
 * Template Name: Makers By Topic
 */
global $wp_query;
$topic_slug = $wp_query->query_vars['t_slug'];
$category = get_term_by('slug',$topic_slug,'category');
$search_category = $category->name.':'.$category->term_id;

$f = $wp_query->query_vars['f'];
$search_criteria['field_filters'][] = array( 'key' => '147', 'value' => array( $search_category));
$entries=GFAPI::get_entries(20,$search_criteria);

// Load Categories
$fieldtopics=RGFormsModel::get_field($form,'147');



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
			
			<?php foreach ($entries as $entry) :

			$project_name = isset($entry['151']) ? $entry['151']  : '';
			$entry_id = isset($entry['id']) ? $entry['id']  : '';
			$topicsarray = array();
			foreach($fieldtopics['inputs'] as $topic)
			{
				if (strlen($entry[$topic['id']]) > 0)  $topicsarray[] = $lead[$topic['id']];
			}
				?>
						<hr>
			<div class="row">
			<div class="span2"></div><div class="span6">
			<h3><a href="/maker/entry/<?php echo $entry_id; ?>"><?php echo $project_name;?></a></h3>
			<ul class="unstyled"><li>Topics: 
				<?php echo  implode(',',$topicsarray);?>
			</li>
			</ul>
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