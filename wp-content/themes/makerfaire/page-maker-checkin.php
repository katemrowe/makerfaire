<?php get_header(); 

//determine the parent page slug
 $par_post = get_post($post->post_parent);
 $slug = $par_post->post_name;
 
 $entryID = (isset($_GET['entryID'])?$_GET['entryID']:'');
 
 
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
                                        <?php
                                        //form submitted? update database
                                        if(isset($_POST['submit'])){
                                           $entryID    = (isset($_POST['entryID'])   && $_POST['entryID']   != ''     ? $_POST['entryID']     :0);
                                           $latitude   = (isset($_POST['latitude'])  && $_POST['latitude']  != ''    ? $_POST['latitude']    :0);
                                           $longitude  = (isset($_POST['longitude']) && $_POST['longitude'] !=''  ? $_POST['longitude']   :0);
                                           $geotext    = (isset($_POST['geotext'])     ? $_POST['geotext']     :'');
                                           $comments   = (isset($_POST['comments'])    ? $_POST['comments']    :'');
                                           //update the database with submitted info
                                           $sql = "INSERT INTO `maker_checkin`(`entry_id`, `latitude`, `longitude`, `geotext`, `comments`) VALUES "
                                                   . "($entryID,$latitude,$longitude,'$geotext','$comments')";

                                          $wpdb->get_results($sql);
                                          echo '<h2>Thank you for your submission</h2>';
                                        }else{
                                            ?>
                                            <?php the_content(); ?>

                                            <div class="clear"></div>
                                            <p>Hello <?php echo $entryID; ?>,<br/><br/>
                                            Please wait while we get your location.    
                                           <br/><br/>

                                            <form id="geolocation" method="POST" action="">
                                                <input id="entryID"   name="entryID"   type="hidden" value ="<?php echo $entryID; ?>" />
                                                Latitude: 
                                                <input id="latitude"  name="latitude"  type="text" />
                                                Longitude: 
                                                <input id="longitude" name="longitude" type="text"  /><br/>
                                                Text from GeoLocation: <br/>
                                                <input style="width:500px;height:200px" type="textarea" rows="4" cols="50" id="geotext" name="geotext" /><br/>
                                                Comments: <br/>
                                                <input style="width:500px;height:200px"  type="textarea" rows="4" cols="50"id="comments" name="comments" /><br/>
                                                <input type="submit" name="submit" value="Submit your location." />
                                            </form>

                                            <script>
                                            var x = document.getElementById("demo");
                                            jQuery(document).ready(function(){
                                                getLocation();
                                            });

                                            function getLocation() {
                                                if (navigator.geolocation) {
                                                    navigator.geolocation.getCurrentPosition(showPosition);
                                                } else { 
                                                    x.innerHTML = "Geolocation is not supported by this browser.";
                                                }
                                            }

                                            function showPosition(position) {
                                               jQuery('#latitude').val(position.coords.latitude);
                                               jQuery('#longitude').val(position.coords.longitude);
                                               
                                               jQuery('#geotext').val();
                                               var output = '';
                                               output = 'Returned Data: <br/>' + 
                                                        'Latitude: '  +         position.coords.latitude  + "\n"+
                                                        'Longitude: ' +         position.coords.longitude + "\n"+
                                                        'Accuracy: '  +         position.coords.accuracy  + '\n'+
                                                        'Altitude: '  +         position.coords.altitude  + '\n'+
                                                        'Altitude Accuracy: ' + position.coords.altitudeAccuracy + '\n'+
                                                        'Heading as degrees clockwise from North: ' +   position.coords.heading	+ '\n'+
                                                        'Speed (meters): '  +  position.coords.speed + '\n'+
                                                        'Timestamp: '       +  position.timestamp;
                                               jQuery('#geotext').val(output);

                                            }
                                            </script>
					<?php 
                                        }
                                       ?>

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

		<?php //get_sidebar(); ?>

	</div>

</div><!--Container-->

<?php get_footer(); ?>
