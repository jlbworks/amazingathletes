<?php
global $mypages;

if(!isset($_GET['page'])){	
	?>
	<div class="user_form">	
	<?php
	echo "<ul>";
	foreach ($mypages as $key => $page) {
		echo '<li><a href="?page=' . $page . '">' . $key . '</a></li>';
	}
	echo "</ul>";
	?>
	</div>
<?php }
else { 
$page_content = get_user_meta($user->ID, 'page_content', true); 

foreach($mypages as $key => $val) {			
	if($val == $_GET['page']){				
		$content = (isset($page_content[$val]) ? $page_content[$val] : '');	
		$title = $key;		
		$page = $val;
		break;
	}			
}	

?>
<h2><?php echo $title;?></h2>
<div class="user_form">
	<form id="frm_edit_mypage" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >		
		<?php wp_editor( $content, $page, array( 'textarea_name' => $page) ); ?>
		<input type="hidden" name="mypage" value="<?php echo $page; ?>" />
		<input type="hidden" name="action" value="am2_edit_mypage" />
		<input type="submit" value="Submit" />
	</form>
</div>	
<?php }?>