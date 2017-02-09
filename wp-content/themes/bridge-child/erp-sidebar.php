    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="javascript:void(0)" class="sidebar-toggle js-sidebar-toggle"> <span>Navigation</span><i class="fa fa-bars"></i></a>
        <ul class="menu">
            <?php if( is_role('administrator') ){ ?>
            <li> 
                <a href="#dashboard"><i class="fa fa-home" aria-hidden="true"></i> <span>Dashboard</span></a> 
            </li>
            <?php }else{ ?>
            <li>
                <a href="#dashboard"><i class="fa fa-home" aria-hidden="true"></i> <span>Dashboard</span> </a>
            </li>          
            <?php } if( is_role('administrator') ){ ?>
            <li>
                <a href="#users-management"><i class="fa fa-user-md" aria-hidden="true"></i> <span>Users</span></a>
            </li>
            <?php } if( is_role('administrator') || is_role('franchisee') ){ ?>
            <li>
                <a href="#customers"><i class="fa fa-briefcase" aria-hidden="true"></i> <span>Customers</span> </a>
            </li>
            <?php } if( is_role('administrator') || is_role('franchisee') ){ ?>
            <li>
                <a href="#payments"><i class="fa fa-users" aria-hidden="true"></i> <span>Payments</span> </a>
            </li>
            <?php } if( is_role('administrator') ||  is_role('franchisee') ){ ?>
            <li>
                <a href="#attendance"><i class="fa fa-users" aria-hidden="true"></i> <span>Attendance</span> </a>
            </li>
            <?php } if( is_role('administrator') ||  is_role('franchisee') || is_role('coach') ){ ?>
            <li>
                <a href="#roster"><i class="fa fa-users" aria-hidden="true"></i> <span>Roster</span> </a>
            </li>
            <?php } if( is_role('administrator') ||  is_role('franchisee') ||  is_role('coach') ){ ?>
            <li>
                <a href="#coach-invoices"><i class="fa fa-users" aria-hidden="true"></i> <span>Coach Invoices</span> </a>
            </li>
            <?php } if( is_role('administrator') ||  is_role('franchisee')){ ?>
            <li>
                <a href="#location-invoices"><i class="fa fa-users" aria-hidden="true"></i> <span>Location Invoices</span> </a>
            </li>

            <?php } if( is_role('administrator') ||  is_role('franchisee') ||  is_role('super_admin') ){ ?>

            <li>
                <a href="#rss"><i class="fa fa-archive" aria-hidden="true"></i> <span>RSS Reports</span></a>
            </li>
            <?php } if( is_role('administrator') || is_role('super_admin') ){ ?>
            <li>
                <a href="#cities"><i class="fa fa-archive" aria-hidden="true"></i> <span>Cities</span></a>
            </li>
            <?php } ?>
        </ul>
    </div>