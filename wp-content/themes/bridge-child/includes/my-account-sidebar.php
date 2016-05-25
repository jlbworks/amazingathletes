<div class="widget widget_text">            
    <div class="textwidget"><span class="icon-row">

    <?php if(in_array('franchisee',$user->roles)): ?>
   
    <div style="/*padding-top: 40px;*/" class="side-nav">
        <a href="<?php echo site_url();?>/my-account/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-account-volleyball-icon.png" width="30px" class="spt-icons" id="fball2">
            </span>
            <span class="sidebar-nav">
            <h2>MY ACCOUNT</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/appointments/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-locations-soccerball-icon.png" width="30px" class="spt-icons" id="hockey2">
            </span>
            <span class="sidebar-nav">
                <h2>MY APPOINTMENTS</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/locations/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png" width="30px" class="spt-icons" id="hockey2">
            </span>
            <span class="sidebar-nav">
                <h2>MY LOCATIONS</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/my-account/my-pages/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-pages-football-icon.png" width="30px" class="spt-icons" id="hockey2">
            </span>
            <span class="sidebar-nav">
                <h2>MY PAGES</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/resources/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/sports-store-hockey-puck-icon.png" width="30px" class="spt-icons" id="hockey2">
            </span>
            <span class="sidebar-nav">
                <h2>RESOURCES</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="https://playlearnperform.com/my-account/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/rescources-golf-icon.png" width="30px" class="spt-icons" id="hockey2">
            </span>
            <span class="sidebar-nav">
                <h2>SPORTS STORE</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/registration/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-account-volleyball-icon.png" width="30px" class="spt-icons" id="hockey2">
            </span>
            <span class="sidebar-nav">
                <h2>REGISTRATION</h2>
            </span>
        </a>
    </div>
    <div class="side-nav">
        <a href="<?php echo site_url();?>/testimonials/" class="sidebar-link">
            <span>
                <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/my-locations-soccerball-icon.png" width="30px" class="spt-icons" id="hockey2">
            </span>
            <span class="sidebar-nav">
                <h2>TESTIMONIALS</h2>
            </span>
        </a>
    </div>
    <?php endif; ?>

    <div class="side-nav"><a href="<?php $logout_url = site_url(); echo wp_logout_url($logout_url); ?>" class="sidebar-link">
                         <span>
                             <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png" width="30px" class="spt-icons" id="bsball2">
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

</div><?php am2_user_social();?><?php am2_franchisee_info();?>
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