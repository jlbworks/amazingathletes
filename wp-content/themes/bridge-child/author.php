<?php
global $wp_query;
global $mypages,$mypages_multi;

$author = get_query_var('author');
$author_name = get_query_var('author_name');
$mypage = get_query_var('mypage');
$locations = get_query_var( 'locations' );
if($locations) $mypage = 'locations';

$curauth = $wp_query->get_queried_object();
$_user_meta = get_user_meta($curauth->ID);
$user_meta = array();

foreach($_user_meta as $key => $um){
	$user_meta[$key] = $um[0];
}

$page_content = unserialize($user_meta['page_content']);

function am2_user_data(){
	$author = get_query_var('author');

	wp_localize_script('am2_main', 'author_object', array(		
		'video_url' => get_user_meta($author, 'video', true),
	));
}

add_action('wp_enqueue_scripts', 'am2_user_data', 12);

get_header();?>
<div class="content " style="min-height: 758px;">
						<div class="content_inner  ">
											<div class="full_width">
	<div class="full_width_inner">
							
					<div class="two_columns_25_75 clearfix grid2">
						<div class="column1">	<div class="column_inner">
		<aside class="sidebar">
							
			<div class="widget widget_text">			<div class="textwidget"><span class="icon-row">

    <?php 
	foreach($mypages as $key => $val){
		if(is_array($val)){ 
			$val_parent = $val['menu']; ?>
		<div class="side-nav">			
			<a href="<?php echo site_url();?>/<?php echo get_user_meta($curauth->ID,'franchise_slug',true);?>/<?php echo $val_parent;?>" class="sidebar-link">
             <span>
                 <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-locations-soccerball-icon.png" width="30px" class="spt-icons" id="sball2">
             </span>
             <span class="sidebar-nav">
                 <h2><?php echo $key;?></h2>
             </span></a>

			 <!-- submenu -->
			<?php foreach($val['submenu'] as $key2 => $val2){?>
				<div class="side-nav sub">					
					<a href="<?php echo site_url();?>/<?php echo get_user_meta($curauth->ID,'franchise_slug',true);?>/<?php echo $val2;?>" class="sidebar-link">
					<span>
						<img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-locations-soccerball-icon.png" width="30px" class="spt-icons" id="sball2">
					</span>
					<span class="sidebar-nav">
						<h2><?php echo $key2;?></h2>
					</span></a>
				</div>			
			<?php } ?>	 
    	</div>    	
	<?php }	
	else {	?>
		<div class="side-nav">
			<?php /*<a href="<?php echo site_url();?>/franchisee/<?php echo $author_name;?>/<?php echo $val;?>" class="sidebar-link">*/?>
			<a href="<?php echo site_url();?>/<?php echo get_user_meta($curauth->ID,'franchise_slug',true);?>/<?php echo $val;?>" class="sidebar-link">
             <span>
                 <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-locations-soccerball-icon.png" width="30px" class="spt-icons" id="sball2">
             </span>
             <span class="sidebar-nav">
                 <h2><?php echo $key;?></h2>
             </span></a>
    	</div>    	
    <?php } ?>
	<?php } ?>
  
	<?php /*<div class="side-nav"><a href="#" class="sidebar-link">
                         <span>
                             <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/rescources-golf-icon.png" width="30px" class="spt-icons" id="golf2">
                         </span>
                         <span class="sidebar-nav">
                             <h2>MEET THE TEAM</h2>
                         </span></a>
    </div>
	<div class="side-nav"><a href="#" class="sidebar-link">
                         <span>
                             <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png" width="30px" class="spt-icons" id="bsball2">
                         </span>
                         <span class="sidebar-nav">
                             <h2>GET STARTED</h2>
                         </span></a>
    </div>*/ ?>
	
</span> </div>
		</div><?php am2_user_social();?><div class="widget widget_text">			<div class="textwidget"><div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">	<div class="vc_empty_space  sidebar-spacer" style="height: 100px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

</div></div></div></div></div></div>
		</div>		</aside>
	</div>
</div>
						<div class="column2">
																	<div class="column_inner">
							<div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">	<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

<div class="qode_carousels_holder clearfix"><div class="qode_carousels" data-number-of-visible-items="4"><div class="caroufredsel_wrapper" style="display: block; text-align: left; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: 0; width: 1407px; margin: 0px; overflow: hidden; cursor: move; height: 302px;"><ul class="slides" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 6097px; opacity: 1; z-index: 0;"><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0295.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/duck-walks-e1458854686480.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0652.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0375.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0238.jpg" alt="carousel image"></span></div></li></ul></div></div></div><div class="vc_row wpb_row section vc_row-fluid vc_inner " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
	<div class="wpb_text_column wpb_content_element  copy-child-page">
		<div class="wpb_wrapper">
			<div class="welcome">welcome to<br/></div>
			<h1 class="entry-title" style="text-align: center;"><?php echo !empty($user_meta['alternative_title']) ? $user_meta['alternative_title'] : $user_meta['franchise_name'];?></h1>			
			<?php

			$programs = get_field('programs_description', 'option'); 

			/*******locations of this franchisee********/
			if($mypage == 'locations'){ 
				include(locate_template( 'includes/archives/franchisee-locations.php' ));
			}			

			else if($mypage == 'programs'){
				$_classes = get_posts(
					array(
						'post_type' => 'location_class',
						'posts_per_page' => -1,
						'post_status' => 'publish',
						'author' => $curauth->ID,
					)
				);	

				$classes = array();
				foreach($_classes as $_class){
					$classes[$_class->type] = $_class->type;
				}			
					
				foreach($programs as $program){
					foreach($classes as $class){
						if($program['program'] == $class){
							echo $program['description'];
						}
					}										
				}
			}

			else if($mypage == 'staff'){
				$staff = get_users(
					array(
						'role' => 'coach',
						'meta_key' => 'franchisee',		
						'meta_value' => $curauth->ID,
					)
				);				

				foreach($staff as $member){
					$user_photo = get_field('user_photo', 'user_' . $member->ID);	
								
					echo "<div class=\"entry-content\">";
					echo "<h2>{$member->display_name}</h2>";
					if($user_photo!=null){
						$image_url = wp_get_attachment_image_src($user_photo, 'medium');
						echo '<img src="'. $image_url[0] . '" style="float:left;padding:0px 10px 10px 0px;"/>';	
					}					
					echo $member->description;
					echo "</div>";
				}
			}

			else if(in_array($mypage, $mypages_multi) ){
				echo "<div class=\"posts\">";
				$ctg_id = get_term_by( 'name', array_search($mypage,$mypages), 'category')->term_id;
				$posts = get_posts(array(
					'post_type' => 'post',
					'post_status' => 'pubslish',
					'posts_per_page' => -1,
					'author' => (int)$curauth->ID,
					'category' => $ctg_id,
				));
				foreach($posts as $post){											
					echo "<h3><!--<a href=\"".add_query_arg( 'post_id', $post->ID, $_SERVER['REQUEST_URI']) ."\">-->".get_the_title($post->ID)."<!--</a>--></h3>";
					echo apply_filters( 'the_content', $post->post_content );					
				}
				echo "</div>";
			}

			/********mypages of this franchisee********/
			else if(isset($page_content[$mypage])) { 
				echo $page_content[$mypage];
			}

			/********home of this franchisee*********/
			else {  ?> 

				<div id="franchise_video">
				</div>
				<div id="franchise_about">
					<?php if(isset($page_content['about'])) {?>
						<?php $res = apply_filters( 'wp_trim_excerpt', $page_content['about'] ); echo mb_substr(strip_tags( $res ),0,500); ?>
					<?php } ?>		
					<a class="learn_more" href="<?php echo site_url();?>/franchisee/<?php echo $author_name; ?>/about">LEARN MORE</a>
					<?php am2_user_social($author);?>
				</div>
				<ul class="franchise_pages">
					<li>
						<a href="<?php echo site_url();?>/<?php echo get_user_meta($curauth->ID,'franchise_slug',true);?>/register"><img src="<?php echo get_stylesheet_directory_uri();?>/img/franchisee/register.jpg" /></a>
					</li>
					<li>
						<a href="<?php echo site_url();?>/<?php echo get_user_meta($curauth->ID,'franchise_slug',true);?>/programs"><img src="<?php echo get_stylesheet_directory_uri();?>/img/franchisee/programs.jpg" /></a>
					</li>
					<li>
						<a href="<?php echo site_url();?>/<?php echo get_user_meta($curauth->ID,'franchise_slug',true);?>/policies_and_procedures"><img src="<?php echo get_stylesheet_directory_uri();?>/img/franchisee/policies.jpg" /></a>
					</li>
				</ul>

			<?php } ?>
			

</div> 
	</div> 	<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

</div></div></div></div></div>
		
														 
							</div>
														
								
						</div>
						
					</div>
				</div>
	</div>	
			
	</div>
</div>

<!-- start:message -->
<div class="clearfix remodal remodal_user" id="remodal-message" data-remodal-id="message" >
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div class="col-1">
		<h3 class="title">
		</h3>
		<div class="message">
		</div>
		<a href="#ok" class="button remodal-confirm" data-remodal-action="confirm">OK</a>
	</div>

</div>
<?php get_footer();?>