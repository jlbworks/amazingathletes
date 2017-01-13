<div class="widget widget_text">
    <div class="textwidget"><span class="icon-row">

    <?php if(in_array('franchisee',$user->roles)): ?>

    <div style="/*padding-top: 40px;*/" class="side-nav">
        <a href="<?php echo site_url();?>/my-account/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/rescources-golf-icon.png"  width="30px" class="spt-icons" id="golf2" 
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-rescources-golf-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/rescources-golf-icon.png">
            </span>
            <span class="sidebar-nav">
            <h2>DASHBOARD</h2>
            </span>
        </a>
    </div>

    <div style="/*padding-top: 40px;*/" class="side-nav">
        <a href="<?php echo site_url();?>/my-account/profile/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-account-volleyball-icon.png" width="30px" class="spt-icons" id="vball2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-my-account-volleyball-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/my-account-volleyball-icon.png">
            </span>
            <span class="sidebar-nav">
            <h2>PROFILE</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/my-calendar/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-locations-soccerball-icon.png" width="30px" class="spt-icons" id="sball2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-my-locations-soccerball-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/my-locations-soccerball-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>MY CALENDAR</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/locations/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png" width="30px" class="spt-icons" id="bsball2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-logout-baseball-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>MY LOCATIONS</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/my-pages/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-pages-football-icon.png" width="30px" class="spt-icons" id="fball2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-my-pages-football-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/my-pages-football-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>MY WEBPAGE</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/resources/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/sports-store-hockey-puck-icon.png" width="30px" class="spt-icons" id="hockey2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-sports-store-hockey-puck-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/sports-store-hockey-puck-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>RESOURCES</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="http://playlearnperform.com/login/" target=_blank; class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/rescources-golf-icon.png" width="30px" class="spt-icons" id="golf2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-rescources-golf-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/rescources-golf-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>PRO SHOP</h2>
            </span>
        </a>
    </div>
	<div class="side-nav">
		<div class="sidebar-link">
			<?php 
$current_user = wp_get_current_user(); 
$user_id = "user_".$current_user->ID;
?>

 <form style="margin-top:-40px;" name="xpressdocslink" action="http://www.xpressdocs.com/next/default_link.php" method="post" target="_blank">
 <input type="hidden" name="company" value="8bea036f"> <!--required -->
 <input type="hidden" name="userid" value="<?php echo $current_user->ID; ?>"> <!-- required -->
 <input type="hidden" name="usertype" value="Agent"><!-- required --> 
 <input type="hidden" name="officeid" value="<?php echo $current_user->user_login; ?>"> <!-- required -->
 <input type="hidden" name="firstname" value="<?php the_field('display_name', $user_id); ?>"> <!-- required -->
 <input type="hidden" name="lastname" value="<?php the_field('individual_1_last_name', $user_id); ?>"> <!-- required -->
 <input type="hidden" name="email" value="<?php the_field('aa_email_address', $user_id); ?>"> <!-- required -->
 <input type="hidden" name="webpage" value="www.amazingathletes.com/<?php the_field('franchise_slug', $user_id); ?>?"> 
 <input type="hidden" name="directphone" value="<?php the_field('telephone', $user_id); ?>"><!-- required -->
 <input type="hidden" name="officename" value="<?php the_field('franchise_name', $user_id); ?>"><!-- required -->
 <input type="hidden" name="officeaddress1" value="<?php the_field('mailing_address', $user_id); ?>"> <!-- required -->
 <input type="hidden" name="officecity" value="<?php the_field('city_state_city', $user_id); ?>"><!-- required -->
 <input type="hidden" name="officestate" value="<?php the_field('city_state_state', $user_id); ?>"> <!-- required -->
 <input type="hidden" name="officezip" value="<?php the_field('zip_code', $user_id); ?>"><!-- required -->
 <input class="cps-button" type=submit value="CUSTOM PROSHOP"> 

 </form>
		</div>
    </div>
	<div class="side-nav">
        <a href="<?php echo site_url();?>/amp/#dashboard" target=_blank; class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-pages-football-icon.png" width="30px" class="spt-icons" id="fball2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-my-pages-football-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/my-pages-football-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>AMP</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/my-staff/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png" width="30px" class="spt-icons" id="bsball2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-logout-baseball-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>MY STAFF</h2>
            </span>
        </a>
    </div>
    <?php endif; ?>

    <div class="side-nav"><a href="<?php $logout_url = site_url(); echo wp_logout_url($logout_url); ?>" class="sidebar-link">
                         <span>
                             <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-pages-football-icon.png" width="30px" class="spt-icons" id="fball2"
                              data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-my-pages-football-icon.png"
                                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/my-pages-football-icon.png">
                         </span>
                         <span class="sidebar-nav">
                             <h2>LOGOUT</h2>
                         </span></a>
    </div>
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

</span>
</div>

</div><?php am2_user_social();?><?php am2_franchisee_info(['show_address' => false]);?>
<div class="widget widget_text">
    <div class="textwidget">
        <div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;">
            <div class=" full_section_inner clearfix">
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">
                            <div class="vc_empty_space  sidebar-spacer" style="height: 100px">
                                <span class="vc_empty_space_inner"><span class="empty_space_image"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



