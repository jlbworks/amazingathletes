<div class="widget widget_text">
    <div class="textwidget">
	
	    <div id="displayText"><i class="fa fa-bars" aria-hidden="true"></i><p>FRANCHISEE MENU</p></div> 

<span id="toggleText" class="icon-row" >

    <?php if(in_array('franchisee',$user->roles) || in_array('coach',$user->roles)): ?>

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

    <?php endif; ?>
    <?php if(in_array('franchisee',$user->roles)): ?>

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
                $cityState = get_user_meta($current_user->ID,'city__state',true);
                $cityState = explode("|", $cityState);
            ?>

 <form style="margin-top:-40px;" name="xpressdocslink" action="http://www.xpressdocs.com/next/default_link.php" method="post" target="_blank">
 <input type="hidden" name="company" value="8bea036f"> <!--required -->
 <input type="hidden" name="userid" value="<?php echo $current_user->nickname; ?>"> <!-- required -->
 <input type="hidden" name="usertype" value="Agent"><!-- required --> 
 <input type="hidden" name="officeid" value="<?php echo $current_user->user_login; ?>"> <!-- required -->
 <input type="hidden" name="firstname" value="<?php the_field('display_name', 'user_'.$user_id); ?>"> <!-- required -->
 <input type="hidden" name="lastname" value="<?php the_field('individual_1_last_name', 'user_'.$user_id); ?>"> <!-- required -->
 <input type="hidden" name="email" value="<?php the_field('aa_email_address', 'user_'.$user_id); ?>"> <!-- required -->
 <input type="hidden" name="webpage" value="http://www.amazingathletes.com/<?php the_field('franchise_slug', 'user_'.$user_id); ?>?"> 
 <input type="hidden" name="directphone" value="<?php the_field('telephone', 'user_'.$user_id); ?>"><!-- required -->
 <input type="hidden" name="officename" value="<?php the_field('franchise_name', 'user_'.$user_id); ?>"><!-- required -->
 <input type="hidden" name="officeaddress1" value="<?php the_field('mailing_address', 'user_'.$user_id); ?>"> <!-- required -->
 <input type="hidden" name="officecity" value="<?php echo $cityState[1]; ?>"><!-- required -->
 <input type="hidden" name="officestate" value="<?php echo $cityState[0]; ?>"> <!-- required -->
 <input type="hidden" name="officezip" value="<?php the_field('zip_code', 'user_'.$user_id); ?>"><!-- required -->
 <input class="cps-button" type=submit value="CUSTOM PROSHOP"> 

 </form>
		</div>
    </div>

    <?php endif; ?>
    <?php if(in_array('coach',$user->roles) || in_array('franchisee',$user->roles)): ?>

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

    <?php endif; ?>
    <?php if(in_array('franchisee',$user->roles)): ?>

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

    <?php if(in_array('coach',$user->roles)): ?>

    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/my-staff/?user_id=<?php echo $user->ID; ?>" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png" width="30px" class="spt-icons" id="bsball2"
                data-mouseover="<?php echo site_url();?>/wp-content/uploads/2016/03/active-logout-baseball-icon.png"
                data-mouseout="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png">
            </span>
            <span class="sidebar-nav">
                <h2>Coach Information</h2>
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
</div>



