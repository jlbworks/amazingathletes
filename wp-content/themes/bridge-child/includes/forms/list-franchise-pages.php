<?php
global $mypages, $mypages_multi, $mypages_optional; 

if(!isset($_GET['page'])){	
	?>
	<div class="user_form">	
	<?php
	echo "<ul>";
	foreach ($mypages as $key => $val) {
		if(is_array($val)){ 
			$val_parent = $val['menu'];
			echo '<li><a href="?page=' . $val_parent . '">' . $key . '</a></li>';
		}
		else 
			echo '<li><a href="?page=' . $val . '">' . $key . '</a></li>';
	}
	echo "</ul>";
	?>
	<br/>
	<h2>Add custom page</h2>
	<form id="frm_add_mypage" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
		<input type="hidden" name="action" value="am2_add_mypage" />
		<input type="text" name="page_name" placeholder="Page name" />		
		<input type="submit" value="Add page" />
	</form>
	</div>
<?php }
else { 
	$show_editor = (!in_array($_GET['page'], $mypages_multi) || (in_array($_GET['page'], $mypages_multi) && (isset($_GET['post_id']) || isset($_GET['add']) ) ) );
	$page_content = get_user_meta($user->ID, 'page_content', true); 
	$content = '';

	foreach($mypages as $key => $val){
		if(is_array($val)){ 
			$val_parent = $val['menu'];
			if($val_parent == $_GET['page']){	
				$title = $key;		
				$page = $val_parent;
	
				if(!in_array($_GET['page'], $mypages_multi)){
					$content = (isset($page_content[$val_parent]) ? $page_content[$val_parent] : '');							
				}	
				else if(isset($_GET['post_id'])) {
					$content_post = get_post($_GET['post_id']);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);	
				}
				break;
			} 
		}
		else {
			if($val == $_GET['page']){										
				$title = $key;		
				$page = $val;

				if(!in_array($_GET['page'], $mypages_multi)){
					$content = (isset($page_content[$val]) ? $page_content[$val] : '');							
				}	
				else if(isset($_GET['post_id'])) {
					$content_post = get_post($_GET['post_id']);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);												
				}
				break;
			}
		}						
	}	

?>
<h2><?php echo $title;?></h2>
<div class="user_form">	
	<form id="frm_edit_mypage" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >	
		<?php if(in_array($_GET['page'], $mypages_optional)){
			$_mypage = str_replace("-", "_", $_GET['page']);
			$show_mypage = "show_{$_mypage}";
			echo "<label><input type=\"checkbox\" name=\"{$show_mypage}\" value=\"1\" ".($user->$show_mypage == 1 ? 'checked' : '')."/>Show ".$_GET['page']."</label>";
			echo "<input type=\"hidden\" name=\"mypage\" value=\"{$_GET['page']}\" />";
		}?>	
		<br/><br/>
		<?php if($show_editor) { ?>
		<?php wp_editor( $content, $page, array(
			'media_buttons' => true,
    		'dfw' => true,
			'textarea_name' => $page,
			"drag_drop_upload" => true
			) ); ?>
		<?php } ?>
		<input type="hidden" name="mypage" value="<?php echo $page; ?>" />
		<input type="hidden" name="post_id" value="<?php echo (isset($_GET['post_id']) ? $_GET['post_id'] : 0);?>" />		
		<input type="hidden" name="action" value="am2_edit_mypage" />		
		<input type="submit" value="Submit" class="button"/>
	</form>

	<?php if(in_array($_GET['page'], $mypages_multi)){ ?>
	<a href="<?php echo remove_query_arg('post_id', add_query_arg( 'add', '', $_SERVER['REQUEST_URI']) ); ?>" class="button">Add new</a>
	<div class="posts">
		<?php 		
		//$ctg_id = get_term_by( 'name', $_GET['page'], 'category')->term_id;

		$args = array(
			//'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'author' => (int)$user->ID,
			'post_type' => $_GET['page'],
		);
		$posts = get_posts($args);	
					
		foreach($posts as $post){						
			echo "<h3><a href=\"".remove_query_arg('add', add_query_arg( 'post_id', $post->ID, $_SERVER['REQUEST_URI'])) ."\">".get_the_title($post->ID)."</a></h3>";
			echo apply_filters( 'the_excerpt', $post->post_content );
		}		
		?>
	</div>
	<?php } ?>
</div>	
<?php }?>