<?php
/**
 * Instagram class for MAKE
 */
class Make_Instagram {

	/**
	 * THE CONSTRUCT.
	 *
	 * @return  void
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ), 30 );

	}

	/**
	 * Let's add all of our resouces to make our magic happen.
	 */
	public function load_resources() {

	}

	/**
	 * Load the Maker Faire data feed.
	 * Might update this at some point so that you can pass in any user.
	 *
	 * @return OBJECT Instagram response
	 */
	public function load_data() {

		$base_url = 'https://api.instagram.com/v1/tags/makerfaire/media/recent';
		$params = array(
			'access_token' => '227901753.1fb234f.b4dd629a578c47cda3f6fd579935190e',
			'count' => 3
		);

		// Build the URL
		$url = add_query_arg( $params, $base_url );

		// Request the data
		$response = wp_remote_get( $url );
		$json = wp_remote_retrieve_body( $response );
		
		// Parse the JSON
		$data = json_decode( $json );

		// Send it off...
		return $data->data;
	}

        public function getFirstImage() {
          $ps = $this->load_data(); 

          // make sure $output exists, otherwise we may get an error in local environment
	  if(!isset($output) || !is_string($output)) {
             $output = "";
	  }

          $img = $ps[0];
          
          $output .= "<li><a href=\"" . esc_url( $img->link ) . "\" target=\"_blank\" class=\"instagram-link\">"
                  .  "  <img src=\"" . esc_url( $img->images->standard_resolution->url ) . "\" height=\"182\" width=\"180\" alt=\"image description\">"    
                  .  "</a></li>";
       
          return $output;
        }

	public function show_images() {
		// TODO:	This whole function is a bit of a mess of entangled php and html.
		//			Would do a lot cleaner with some sort of templating engine.

		$ps = $this->load_data();

		// make sure $output exists, otherwise we may get an error in local environment
		if(!isset($output) || !is_string($output)) {
			$output = "";
		}


		$images_per_page = 3;
		$num_images = count($ps);
        $pages = array_chunk($ps, $images_per_page);
        $num_pages = count($pages);
		?>
		<?php
		$output ="<div class=\"item-holder\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col-xs-4\"><div class=\"social-holder twitter\"><div class=\"title\"><h1><a href=\"http://twitter.com/makerfaire\" target=\"_blank\">#MakerFaire</a></h1></div><div id=\"recent-twitter\"></div><a href=\"http://twitter.com/makerfaire\" target=\"_blank\" class=\"follow\">Follow us on Twitter</a></div></div>";
		
		$output .="<div class=\"col-xs-8\">
							<div class=\"social-holder instagram\">
								<div class=\"title\">
									<h1>Instagram, <a href=\"http://instagram.com/makerfaire\" target=\"_blank\">#makerfaire</a></h1>
								</div>";
					foreach( $pages as $page ) {			
							$output .= "<ul class=\"img-list\">";
							foreach( $page as $img ) {
						$output .= "<li><a href=\"" . esc_url( $img->link ) . "\" target=\"_blank\" class=\"instagram-link\"><img src=\"" . esc_url( $img->images->standard_resolution->url ) . "\" height=\"182\" width=\"180\" alt=\"image description\"></a></li>";
							}
						$output .= "</ul>";
					}
						$output .= "<a href=\"http://instagram.com/makerfaire\" target=\"_blank\" class=\"follow\">Follow us on Instagram</a>
							</div>
						</div>";
		$output .="</div></div></div>";
	
		return $output;
	}

}

$instagram = new Make_Instagram();

function make_show_images() {
	$instagram = new Make_Instagram();
	return $instagram->show_images();
}

add_shortcode( 'show_instagram', 'make_show_images' );

?>