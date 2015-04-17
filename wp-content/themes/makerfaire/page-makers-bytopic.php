<?php
/**
 * Template Name: Makers By Topic
 */
global $wp_query;
$topic_slug = $wp_query->query_vars['t_slug'];
$category = get_term_by('slug',$topic_slug,'category');
$search_category = $category->name.':'.$category->term_id;
$currentpage = $wp_query->query_vars['offset'];
$page_size = 10;
$offset=($currentpage-1)*$page_size;
$total_count = 0;
$f = $wp_query->query_vars['f'];
$search_criteria = array( 'key' => '147', 'value' =>  $search_category);
$search_value['field_filters'][] = array('key' => '147', 'value' => $search_category);
$sorting_criteria = array('key' => '151', 'direction' => 'ASC' );
$paging_criteria = array('offset' => $offset, 'page_size' => $page_size );
$entries=search_entries_bytopic(20,$search_criteria,$sorting_criteria,$paging_criteria,$total_count);

$total_count=GFAPI::count_entries(20,$search_value);

// Load Categories
$cats_tags = get_categories(array('hide_empty' => 0));




get_header(); ?>
<div class="clear"></div>

<div class="container">

	<div class="row">

		<div class="content span8">
			<div class="span7">
			<h1> <small><?php echo  $topic_slug; ?></small></h1>
			<?php pagination_display();?>
			</div>
			<div class="span2">
			TOPIC:	<?php echo $topic_slug;?>
			PAGE: <?php echo $currentpage;?>
			OFFSET: <?php echo $offset;?>
			TOTAL :<?php echo $total_count;?>
			</div>
			
			<?php foreach ($entries as $entry) :
			$project_name = isset($entry['151']) ? $entry['151']  : '';
			$entry_id = isset($entry['id']) ? $entry['id']  : '';
			
				?>
						<hr>
			<div class="row">
			<div class="span6">
			<h3><a href="/maker/entry/<?php echo $entry_id; ?>"><?php echo $project_name;?></a></h3>
			
			</div>
			</div>
			<?php endforeach;?>
			<div class="span7">
			<?php pagination_display();?>
			</div>
		</div>
		<!--Content-->

		<?php get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer();

/* Support Functions */
function search_entries_bytopic( $form_id, $search_criteria = array(), $sorting = null, $paging = null, $total_count ) {

	global $wpdb;
	$sort_field = isset( $sorting['key'] ) ? $sorting['key'] : 'date_created'; // column, field or entry meta


	//initializing rownum
	$sql = sort_by_field_query( $form_id, $search_criteria, $sorting, $paging);
	
	GFCommon::log_debug( $sql );
	//getting results
	$results = $wpdb->get_results( $sql );
	
	$leads = GFFormsModel::build_lead_array( $results );
	
	return $leads;
}


function sort_by_field_query( $form_id, $searching, $sorting, $paging ) {
	global $wpdb;
	$sort_field_number = rgar( $sorting, 'key' );
	$sort_direction    = isset( $sorting['direction'] ) ? $sorting['direction'] : 'DESC';
	$offset          = isset( $paging['offset'] ) ? $paging['offset'] : 0;
	$page_size       = isset( $paging['page_size'] ) ? $paging['page_size'] : 20;
	$search_key          = isset( $searching['key'] ) ? $searching['key'] : '';
	$search_value       = isset( $searching['value'] ) ? $searching['value'] : '';
	
	if ( ! is_numeric( $sort_field_number ) || ! is_numeric( $offset ) || ! is_numeric( $page_size ) ) {
		return '';
	}
	$lead_detail_table_name = GFFormsModel::get_lead_details_table_name();
	$lead_table_name        = GFFormsModel::get_lead_table_name();

	$field_number_min = $sort_field_number - 0.0001;
	$field_number_max = $sort_field_number + 0.0001;
	
	$searchfield_number_min = $search_key - 0.0001;
	$searchfield_number_max = $search_key + 0.9999;
	
	
	$sql = "
		
	SELECT sorted.sort,sorted.value, l.*, d.field_number, d.value
            FROM $lead_table_name l
            INNER JOIN $lead_detail_table_name d ON d.lead_id = l.id
			INNER JOIN (
            SELECT @rownum:=@rownum+1 as sort, l.lead_id as id, l.value
			FROM (Select @rownum:=0) r, wp_rg_lead_detail l
				INNER JOIN (
						SELECT
						lead_id as id
						from $lead_detail_table_name
						WHERE (field_number BETWEEN '$searchfield_number_min' AND '$searchfield_number_max' AND value IN ( '$search_value' ))
						AND form_id=20
					) filtered on l.lead_id=filtered.id
				WHERE field_number  between $field_number_min AND $field_number_max AND l.form_id=20
		ORDER BY l.value ASC LIMIT $offset,$page_size ) sorted on sorted.id=l.id
        order by sorted.sort
	";

	return $sql;
}

function pagination_display () {
?>
<style>
.pagination {
	background: none;
	border-radius: 0;
	bottom: 0;
	line-height: 22px;
	margin: 0;
	padding: 0;
	text-align: center;
	width: 100%;
}
.pagination li  {
	display: block;
	margin:0px;
	float:left;
}
.pagination li a {
	background: none;
	border-radius: 0;
	display: block;
	height: auto;
	overflow: none;
	text-indent: 0;
	transition: all 0.3s ease 0s;
	width: auto;
}
</style>
<div class="btn-group pull-right"><nav ><ul class="pagination pull-right">
<li>
<a href="#" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
</a>
</li>
<li class="active"><a href="#">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
<li><a href="#">5</a></li>
<li>
<a href="#" aria-label="Next">
<span aria-hidden="true">&raquo;</span>
</a>
</li>
</ul>
</nav>
</div>
<?php 
}



?>