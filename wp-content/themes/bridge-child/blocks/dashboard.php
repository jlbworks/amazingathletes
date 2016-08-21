<?php
restrict_access( 'administrator,franchisee' );

$args = array(
  'role' => 'franchisee'
);
$total_franchises = count(get_users($args));


$args = array(
  'post_type'   => 'location',
  'post_status' => 'publish',
  'posts_per_page'=>-1
);
if( is_role( 'franchisee' ) ) {
    $args['author'] = get_current_user_id();
}
$total_locations = count(get_posts($args));


$args = array(
 'role' => 'coach'
);
if( is_role( 'franchisee' ) ) {
    $args['meta_key'] = 'franchisee';
    $args['meta_value'] = get_current_user_id();
    $args['meta_compare'] = '=';
}
$total_coaches = count(get_users($args));

$args = array(
    'post_type'   => 'customer',
    'post_status' => 'publish',
    'posts_per_page'=>-1
);
if( is_role( 'franchisee' ) ) {
    $args['author'] = get_current_user_id();
}
$total_customers = count(get_posts($args));


?>

<div class="layout">
    <div class="container clearfix">

        <div class="col-12 break-big attendance">
            <?php include( 'attendance-edit.php' ); ?>
        </div>

        <div class="col-12 break-big information">
            <div class="card-wrapper">
                <h3 class="card-header">Information</h3>
                <div class="card-inner">
                    <div class="card-table">
                        <?php if( !is_role( 'franchisee' ) ): ?>
                            <div class="card-table-row">
                                <span class="card-table-cell fixed250">Total Franchises</span>
                                <div class="card-table-cell">
                                    <form class="card-form no-inline-edit js-ajax-form">
                                        <fieldset>
                                            <?php echo $total_franchises; ?>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card-table-row">
                            <span class="card-table-cell fixed250">Total Locations</span>
                            <div class="card-table-cell">
                                <form class="card-form no-inline-edit js-ajax-form">
                                    <fieldset>
                                        <?php echo $total_locations; ?>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                        <div class="card-table-row">
                            <span class="card-table-cell fixed250">Total Coaches</span>
                            <div class="card-table-cell">
                                <form class="card-form no-inline-edit js-ajax-form">
                                    <fieldset>
                                        <?php echo $total_coaches; ?>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                        <div class="card-table-row">
                            <span class="card-table-cell fixed250">Total Customers</span>
                            <div class="card-table-cell">
                                <form class="card-form no-inline-edit js-ajax-form">
                                    <fieldset>
                                        <?php echo $total_customers; ?>
                                        <a class="text-muted text-uppercase" href="#customers">(view all)</a>
                                    </fieldset>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 break-big payment">
            <?php include( 'payments-edit.php' ); ?>
        </div>

    </div>
</div>

<script type="text/javascript">
  set_title('Dashboard');
</script>