<?php
/*
Plugin Name: US MAP
Plugin URI: http://www.html5interactivemaps.com/
Description: US Map Plugin, cutomize the 50 states plus DC through the admin panel and use the short code in your page.
Version: 1.7
Author: Art101
Author URI: http://www.html5interactivemaps.com/
*/

class WP_Map {

	public function __construct()
	{
		$this->constant();
		$this->options = get_option( 'wp_map' );
		add_action('admin_menu', array($this, 'wp_map_options_page'));
	 	add_action( 'admin_footer', array( $this,'add_js_to_wp_footer' ) );
	 	add_action( 'wp_footer', array( $this,'add_span_tag' ) );
	 	add_action( 'wp_enqueue_scripts', array( $this,'map_frontend' ) );
		add_action( 'admin_enqueue_scripts', array($this,'init_admin_script') );
		add_shortcode( 'us_wp_map', array( $this, 'us_wp_map' )  );
		$this->default = array(
			 'border_color' => '#6b8b9e',
			 'shadow_color' => '#000000',
			 'shadow_opacity' => 50,
			 'short_names' => '#666666',
			 'hover_shadow' => '#666666',
			 'lake_color' => '#66CCFF',

			 'up_color_1' => '#e0f3ff', 
			 'over_color_1' => '#8fbee8',
			 'down_color_1' => '#477cb2',
			 'url_1' => '#',
			 'open_url_1' => '_self',
			 'hover_content_1' => 'ALABAMA',
			 'enable_region_1' => 1,

			 'up_color_2' => '#e0f3ff',
			 'over_color_2' => '#8fbee8' ,
			 'down_color_2' => '#477cb2',
			 'url_2' => '#',
			 'open_url_2' => '_self' ,
			 'hover_content_2' => 'ALASKA',
			 'enable_region_2' => 1,

			 'up_color_3' => '#e0f3ff',
			 'over_color_3' => '#8fbee8',
			 'down_color_3' => '#477cb2',
			 'url_3' => '#',
			 'open_url_3' => '_self' ,
			 'hover_content_3' => 'ARIZONA',
			 'enable_region_3' => 1,

			 'up_color_4' => '#e0f3ff',
			 'over_color_4' => '#8fbee8',
			 'down_color_4' => '#477cb2',
			 'url_4' => '#',
			 'open_url_4' => '_self' ,
			 'hover_content_4' => 'ARKANSAS',
			 'enable_region_4' => 1,

			 'up_color_5' => '#e0f3ff',
			 'over_color_5' => '#8fbee8',
			 'down_color_5' => '#477cb2',
			 'url_5' => '#',
			 'open_url_5' => '_self' ,
			 'hover_content_5' => 'CALIFORNIA',
			 'enable_region_5' => 1,

			 'up_color_6' => '#e0f3ff',
			 'over_color_6' => '#8fbee8',
			 'down_color_6' => '#477cb2',
			 'url_6' => '#',
			 'open_url_6' => '_self' ,
			 'hover_content_6' => 'COLORADO',
			 'enable_region_6' => 1,

			 'up_color_7' => '#e0f3ff',
			 'over_color_7' => '#8fbee8',
			 'down_color_7' => '#477cb2',
			 'url_7' => '#',
			 'open_url_7' => '_self' ,
			 'hover_content_7' => 'CONNECTICUT',
			 'enable_region_7' => 1,

			 'up_color_8' => '#e0f3ff',
			 'over_color_8' => '#8fbee8' ,
			 'down_color_8' => '#477cb2',
			 'url_8' => '#',
			 'open_url_8' => '_self' ,
			 'hover_content_8' => 'DELAWARE',
			 'enable_region_8' => 1,

			 'up_color_9' => '#e0f3ff',
			 'over_color_9' => '#8fbee8' ,
			 'down_color_9' => '#477cb2',
			 'url_9' => '#',
			 'open_url_9' => '_self' ,
			 'hover_content_9' => 'FLORIDA',
			 'enable_region_9' => 1,

			 'up_color_10' => '#e0f3ff',
			 'over_color_10' => '#8fbee8' ,
			 'down_color_10' => '#477cb2',
			 'url_10' => '#',
			 'open_url_10' => '_self' ,
			 'hover_content_10' => 'GEORGIA',
			 'enable_region_10' => 1,

			 'up_color_11' => '#e0f3ff',
			 'over_color_11' => '#8fbee8' ,
			 'down_color_11' => '#477cb2',
			 'url_11' => '#',
			 'open_url_11' => '_self' ,
			 'hover_content_11' => 'HAWAII',
			 'enable_region_11' => 1,

			 'up_color_12' => '#e0f3ff',
			 'over_color_12' => '#8fbee8' ,
			 'down_color_12' => '#477cb2',
			 'url_12' => '#',
			 'open_url_12' => '_self' ,
			 'hover_content_12' => 'IDAHO',
			 'enable_region_12' => 1,

			 'up_color_13' => '#e0f3ff',
			 'over_color_13' => '#8fbee8' ,
			 'down_color_13' => '#477cb2',
			 'url_13' => '#',
			 'open_url_13' => '_self' ,
			 'hover_content_13' => 'ILLINOIS',
			 'enable_region_13' => 1,

			 'up_color_14' => '#e0f3ff',
			 'over_color_14' => '#8fbee8' ,
			 'down_color_14' => '#477cb2',
			 'url_14' => '#',
			 'open_url_14' => '_self' ,
			 'hover_content_14' => 'INDIANA',
			 'enable_region_14' => 1,

			 'up_color_15' => '#e0f3ff',
			 'over_color_15' => '#8fbee8' ,
			 'down_color_15' => '#477cb2',
			 'url_15' => '#',
			 'open_url_15' => '_self' ,
			 'hover_content_15' => 'IOWA',
			 'enable_region_15' => 1,

			 'up_color_16' => '#e0f3ff',
			 'over_color_16' => '#8fbee8' ,
			 'down_color_16' => '#477cb2',
			 'url_16' => '#',
			 'open_url_16' => '_self' ,
			 'hover_content_16' => 'KANSAS',
			 'enable_region_16' => 1,

			 'up_color_17' => '#e0f3ff',
			 'over_color_17' => '#8fbee8' ,
			 'down_color_17' => '#477cb2',
			 'url_17' => '#',
			 'open_url_17' => '_self' ,
			 'hover_content_17' => 'KENTUCKY',
			 'enable_region_17' => 1,

			 'up_color_18' => '#e0f3ff',
			 'over_color_18' => '#8fbee8' ,
			 'down_color_18' => '#477cb2',
			 'url_18' => '#',
			 'open_url_18' => '_self' ,
			 'hover_content_18' => 'LOUISIANA',
			 'enable_region_18' => 1,

			 'up_color_19' => '#e0f3ff',
			 'over_color_19' => '#8fbee8' ,
			 'down_color_19' => '#477cb2',
			 'url_19' => '#',
			 'open_url_19' => '_self' ,
			 'hover_content_19' => 'MAINE',
			 'enable_region_19' => 1,

			 'up_color_20' => '#e0f3ff',
			 'over_color_20' => '#8fbee8' ,
			 'down_color_20' => '#477cb2',
			 'url_20' => '#',
			 'open_url_20' => '_self' ,
			 'hover_content_20' => 'MARYLAND',
			 'enable_region_20' => 1,

			 'up_color_21' => '#e0f3ff',
			 'over_color_21' => '#8fbee8' ,
			 'down_color_21' => '#477cb2',
			 'url_21' => '#',
			 'open_url_21' => '_self' ,
			 'hover_content_21' => 'MASSACHUSETTS',
			 'enable_region_21' => 1,

			 'up_color_22' => '#e0f3ff',
			 'over_color_22' => '#8fbee8' ,
			 'down_color_22' => '#477cb2',
			 'url_22' => '#',
			 'open_url_22' => '_self' ,
			 'hover_content_22' => 'MICHIGAN',
			 'enable_region_22' => 1,

			 'up_color_23' => '#e0f3ff',
			 'over_color_23' => '#8fbee8' ,
			 'down_color_23' => '#477cb2',
			 'url_23' => '#',
			 'open_url_23' => '_self' ,
			 'hover_content_23' => 'MINNESOTA',
			 'enable_region_23' => 1,

			 'up_color_24' => '#e0f3ff',
			 'over_color_24' => '#8fbee8' ,
			 'down_color_24' => '#477cb2',
			 'url_24' => '#',
			 'open_url_24' => '_self' ,
			 'hover_content_24' => 'MISSISSIPPI',
			 'enable_region_24' => 1,

			 'up_color_25' => '#e0f3ff',
			 'over_color_25' => '#8fbee8' ,
			 'down_color_25' => '#477cb2',
			 'url_25' => '#',
			 'open_url_25' => '_self' ,
			 'hover_content_25' => 'MISSOURI',
			 'enable_region_25' => 1,

			 'up_color_26' => '#e0f3ff',
			 'over_color_26' => '#8fbee8' ,
			 'down_color_26' => '#477cb2',
			 'url_26' => '#',
			 'open_url_26' => '_self' ,
			 'hover_content_26' => 'MONTANA',
			 'enable_region_26' => 1,

			 'up_color_27' => '#e0f3ff',
			 'over_color_27' => '#8fbee8' ,
			 'down_color_27' => '#477cb2',
			 'url_27' => '#',
			 'open_url_27' => '_self' ,
			 'hover_content_27' => 'NEBRASKA',
			 'enable_region_27' => 1,

			 'up_color_28' => '#e0f3ff',
			 'over_color_28' => '#8fbee8' ,
			 'down_color_28' => '#477cb2',
			 'url_28' => '#',
			 'open_url_28' => '_self' ,
			 'hover_content_28' => 'NEVADA',
			 'enable_region_28' => 1,

			 'up_color_29' => '#e0f3ff',
			 'over_color_29' => '#8fbee8' ,
			 'down_color_29' => '#477cb2',
			 'url_29' => '#',
			 'open_url_29' => '_self' ,
			 'hover_content_29' => 'NEW HAMPSHIRE',
			 'enable_region_29' => 1,

			 'up_color_30' => '#e0f3ff',
			 'over_color_30' => '#8fbee8' ,
			 'down_color_30' => '#477cb2',
			 'url_30' => '#',
			 'open_url_30' => '_self' ,
			 'hover_content_30' => 'NEW JERSEY',
			 'enable_region_30' => 1,

			 'up_color_31' => '#e0f3ff',
			 'over_color_31' => '#8fbee8' ,
			 'down_color_31' => '#477cb2',
			 'url_31' => '#',
			 'open_url_31' => '_self' ,
			 'hover_content_31' => 'NEW MEXICO',
			 'enable_region_31' => 1,

			 'up_color_32' => '#e0f3ff',
			 'over_color_32' => '#8fbee8' ,
			 'down_color_32' => '#477cb2',
			 'url_32' => '#',
			 'open_url_32' => '_self' ,
			 'hover_content_32' => 'NEW YORK',
			 'enable_region_32' => 1,

			 'up_color_33' => '#e0f3ff',
			 'over_color_33' => '#8fbee8' ,
			 'down_color_33' => '#477cb2',
			 'url_33' => '#',
			 'open_url_33' => '_self' ,
			 'hover_content_33' => 'NORTH CAROLINA',
			 'enable_region_33' => 1,

			 'up_color_34' => '#e0f3ff',
			 'over_color_34' => '#8fbee8' ,
			 'down_color_34' => '#477cb2',
			 'url_34' => '#',
			 'open_url_34' => '_self' ,
			 'hover_content_34' => 'NORTH DAKOTA',
			 'enable_region_34' => 1,

			 'up_color_35' => '#e0f3ff',
			 'over_color_35' => '#8fbee8' ,
			 'down_color_35' => '#477cb2',
			 'url_35' => '#',
			 'open_url_35' => '_self' ,
			 'hover_content_35' => 'OHIO',
			 'enable_region_35' => 1,

			 'up_color_36' => '#e0f3ff',
			 'over_color_36' => '#8fbee8' ,
			 'down_color_36' => '#477cb2',
			 'url_36' => '#',
			 'open_url_36' => '_self' ,
			 'hover_content_36' => 'OKLAHOMA',
			 'enable_region_36' => 1,

			 'up_color_37' => '#e0f3ff',
			 'over_color_37' => '#8fbee8' ,
			 'down_color_37' => '#477cb2',
			 'url_37' => '#',
			 'open_url_37' => '_self' ,
			 'hover_content_37' => 'OREGON',
			 'enable_region_37' => 1,

			 'up_color_38' => '#e0f3ff',
			 'over_color_38' => '#8fbee8' ,
			 'down_color_38' => '#477cb2',
			 'url_38' => '#',
			 'open_url_38' => '_self' ,
			 'hover_content_38' => 'PENNSYLVANIA',
			 'enable_region_38' => 1,

			 'up_color_39' => '#e0f3ff',
			 'over_color_39' => '#8fbee8' ,
			 'down_color_39' => '#477cb2',
			 'url_39' => '#',
			 'open_url_39' => '_self' ,
			 'hover_content_39' => 'RHODE ISLAND',
			 'enable_region_39' => 1,

			 'up_color_40' => '#e0f3ff',
			 'over_color_40' => '#8fbee8' ,
			 'down_color_40' => '#477cb2',
			 'url_40' => '#',
			 'open_url_40' => '_self' ,
			 'hover_content_40' => 'SOUTH CAROLINA',
			 'enable_region_40' => 1,

			 'up_color_41' => '#e0f3ff',
			 'over_color_41' => '#8fbee8' ,
			 'down_color_41' => '#477cb2',
			 'url_41' => '#',
			 'open_url_41' => '_self' ,
			 'hover_content_41' => 'SOUTH DAKOTA',
			 'enable_region_41' => 1,

			 'up_color_42' => '#e0f3ff',
			 'over_color_42' => '#8fbee8' ,
			 'down_color_42' => '#477cb2',
			 'url_42' => '#',
			 'open_url_42' => '_self' ,
			 'hover_content_42' => 'TENNESSEE',
			 'enable_region_42' => 1,

			 'up_color_43' => '#e0f3ff',
			 'over_color_43' => '#8fbee8' ,
			 'down_color_43' => '#477cb2',
			 'url_43' => '#',
			 'open_url_43' => '_self' ,
			 'hover_content_43' => 'TEXAS',
			 'enable_region_43' => 1,

			 'up_color_44' => '#e0f3ff',
			 'over_color_44' => '#8fbee8' ,
			 'down_color_44' => '#477cb2',
			 'url_44' => '#',
			 'open_url_44' => '_self' ,
			 'hover_content_44' => 'UTAH',
			 'enable_region_44' => 1,

			 'up_color_45' => '#e0f3ff',
			 'over_color_45' => '#8fbee8' ,
			 'down_color_45' => '#477cb2',
			 'url_45' => '#',
			 'open_url_45' => '_self' ,
			 'hover_content_45' => 'VERMONT',
			 'enable_region_45' => 1,

			 'up_color_46' => '#e0f3ff',
			 'over_color_46' => '#8fbee8' ,
			 'down_color_46' => '#477cb2',
			 'url_46' => '#',
			 'open_url_46' => '_self' ,
			 'hover_content_46' => 'VIRGINIA',
			 'enable_region_46' => 1,

			 'up_color_47' => '#e0f3ff',
			 'over_color_47' => '#8fbee8' ,
			 'down_color_47' => '#477cb2',
			 'url_47' => '#',
			 'open_url_47' => '_self' ,
			 'hover_content_47' => 'WASHINGTON',
			 'enable_region_47' => 1,

			 'up_color_48' => '#e0f3ff',
			 'over_color_48' => '#8fbee8' ,
			 'down_color_48' => '#477cb2',
			 'url_48' => '#',
			 'open_url_48' => '_self' ,
			 'hover_content_48' => 'WEST VIRGINIA',
			 'enable_region_48' => 1,

			 'up_color_49' => '#e0f3ff',
			 'over_color_49' => '#8fbee8' ,
			 'down_color_49' => '#477cb2',
			 'url_49' => '#',
			 'open_url_49' => '_self' ,
			 'hover_content_49' => 'WISCONSIN',
			 'enable_region_49' => 1,

			 'up_color_50' => '#e0f3ff',
			 'over_color_50' => '#8fbee8' ,
			 'down_color_50' => '#477cb2',
			 'url_50' => '#',
			 'open_url_50' => '_self' ,
			 'hover_content_50' => 'WYOMING',
			 'enable_region_50' => 1,

			 'up_color_51' => '#FF0000',
			 'over_color_51' => '#8fbee8' ,
			 'down_color_51' => '#477cb2',
			 'url_51' => '#',
			 'open_url_51' => '_self' ,
			 'hover_content_51' => 'WASHINGTON DC',
			 'enable_region_51' => 1,);

		if(isset($_POST['wp_map']) && !isset($_POST['preview_map']))	{
			update_option('wp_map', array_map('stripslashes_deep', $_POST));
			$this->options = array_map('stripslashes_deep', $_POST);
		}
		if(isset($_POST['wp_map']) && isset($_POST['restore_default']))	{
			update_option('wp_map', $this->default);
			$this->options = $this->default;
		}
		
		if(!is_array($this->options)){
			$this->options = $this->default;
		}
	}

	protected function constant(){
		
		define( 'WPMMAP_VERSION',   '1.0' );
		define( 'WPMMAP_DIR',       plugin_dir_path( __FILE__ ) );
		define( 'WPMMAP_URL',       plugin_dir_url( __FILE__ ) );

	}

	public function us_wp_map(){
		ob_start();
		include 'templates/map.php';
		?>
		<script type="text/javascript">
			<?php include 'states-config.php'; ?>
		</script>
		<script type="text/javascript" src="<?php echo WPMMAP_URL . 'map-interact.js'; ?>"></script>
		<?php
		$html = ob_get_clean();
		return $html;
	}

	public function wp_map_options_page() {
		add_menu_page('US Map', 'US Map', 'manage_options', 'wp-map', array($this, 'options_screen'), WPMMAP_URL . 'images/map-icon.png');
	}

	public function options_screen()
	{
		include 'templates/admin.php';
	}

	public function admin_ajax_url(){
		$url_action = admin_url( '/' ) . 'admin-ajax.php';
		echo '<div style="display:none" id="wpurl">'. $url_action.'</div>';
	}

	public function add_js_to_wp_footer(){ ?>
		<span class="map-tip" id="map-tip" style="margin-top:-32px"></span>		
		<script type="text/javascript">
			<?php include 'states-config.php'; ?>
		</script>
	<?php }

	public function map_frontend(){
		wp_enqueue_style( 'wp-mapstyle-frontend', WPMMAP_URL . 'map-style.css', false, '1.0', 'all' );
	}

	public function add_span_tag(){
		?>
		<span class="map-tip" id="map-tip"></span>		
		<?php
	}

	public function stripslashes_deep($value) {
			$value = is_array($value) ?
				array_map(array($this, 'stripslashes_deep'), $value) : stripslashes($value);
				return $value;
		}

	public function init_admin_script(){
		if(isset($_GET['page']) && $_GET['page'] == 'wp-map'):
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_style('thickbox'); // call to media files in wp
		wp_enqueue_script('thickbox');
		wp_enqueue_script( 'media-upload'); 
		wp_enqueue_style( 'wp-map-style', WPMMAP_URL . 'style.css', false, '1.0', 'all' );
		wp_enqueue_style( 'wp-mapstyle', WPMMAP_URL . 'map-style.css', false, '1.0', 'all' );
		wp_enqueue_style( 'wp-tinyeditor', WPMMAP_URL . 'tinyeditor.css', false, '1.0', 'all' );
		wp_enqueue_script( 'wp-map-interact', WPMMAP_URL . 'map-interact.js', 10, '1.0', true );
		wp_enqueue_script( 'wp-map-tiny.editor', WPMMAP_URL . 'js/tinymce.min.js', 10, '1.0', true );
		wp_enqueue_script( 'wp-map-script', WPMMAP_URL . 'js/scripts.js', array( 'wp-color-picker' ), false, true );
		endif;	
	}
}

$wp_map = new WP_Map();