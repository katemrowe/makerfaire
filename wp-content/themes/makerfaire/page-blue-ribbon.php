<?php get_header(); ?>

<div class="clear"></div>
<?php
    // Output the featured image.
    if ( has_post_thumbnail() ) :			
                    the_post_thumbnail();			
    endif;?>
<div class="container">

	<div class="row">
                <div class="content col-xs-12">   
                    
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <article <?php post_class(); ?>>
                                     <?php the_content(); ?>
                            </article>
			<?php endwhile; ?>
                            <ul class="pager">
                                    <li class="previous"><?php previous_posts_link('&larr; Previous Page'); ?></li>
                                    <li class="next"><?php next_posts_link('Next Page &rarr;'); ?></li>
                            </ul>
			<?php else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		<!-- start blue ribbon data -->
                <div id="ribbonPage">       
                    
                 <div ng-controller="ribbonController" class="my-controller">                         
                    <select ng-init="query.faireData.year = years[0]" ng-model="query.faireData.year">
                        <option ng-repeat="year in years" value="{{year}}">{{year}}</option>
                    </select>
                     <select ng-model="query.faireData.faire">
                        <option value=" " selected>All Faires</option>
                        <option ng-repeat="faire in faires" value="{{faire}}">{{faire}}</option>
                    </select>
                    <select ng-model="query.faireData.ribbonType">
                        <option value="" selected>All Ribbons</option>
                        <option value="blue">Blue</option>
                        <option value="red">Red</option>
                    </select>
                    <div class="textSearch fancybox-wrap">
                        <input ng-model="query.$" placeholder="Search Winners">
                    </div>

                     <br/><br/>

                    <!--| filter:year -->
                     <div class="ribbData col-xs-12 col-sm-4 col-md-3" dir-paginate="ribbon in ribbons | filter:query |itemsPerPage: 50" current-page="currentPage">                         
                          
                         <a href="/mfarchives/{{ribbon.entryID}}">
                              <img class="projImg" fallback-src="/wp-content/uploads/2015/10/grey-makey.png" ng-src="{{ribbon.project_photo}}"></a>
                              <div class="ribbons">
                             
                                <div class="blueRibbon" ng-if="ribbon.blueCount > 0">
                                    {{ribbon.blueCount}}
                                </div>
                                <div class="redRibbon" ng-if="ribbon.redCount > 0">
                                    {{ribbon.redCount}}
                                </div>
                              </div>
                           </a>
                         <div class="makerData">
                             <div class="projName">
                             {{ribbon.project_name}}
                             </div><br>{{ribbon.maker_name}}
                             <span ng-repeat="faire in ribbon.faireData" class="{{faire.ribbonType}}data"> {{faire.faire}} {{faire.year}}</span>                             
                         </div>
                     </div>   
                 </div>
                 
                    <div class="text-center">
                    <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="<?php echo get_stylesheet_directory_uri();?>/partials/dirPagination.tpl.html"></dir-pagination-controls>
                    </div>
       
                </div>
                <div class="container-fluid">
  
                </div><!--Content-->
	</div>
</div><!--Container-->

<?php get_footer(); ?>
