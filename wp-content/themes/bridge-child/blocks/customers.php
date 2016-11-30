<?php
global $current_user; 
get_currentuserinfo();

restrict_access('super_admin,administrator,franchisee');

$args = array(
    'post_type'   => 'customer',
    'post_status' => 'publish',
    'posts_per_page'=> -1,
);
if(is_role('franchisee')) {
    $args['meta_query']  = array(
        array( 'key'=>'franchise_id','value'=> get_current_user_id() )
    );
}
$customers = get_posts($args);
?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Customers</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','customer_edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New Customer</button>
            </div>
        </div>
    </div>

    <!-- PRODUCT INFORMATION -->
    <div class="layout">
        <div class="container clearfix">
            <div class="col-1 break-big">
                <!-- TABLE (LIST OF USERS) -->
                <table class="table js-responsive-table" id="datatable-editable">
                    <thead>
                        <tr>
                            <th>Parents name</th>
                            <th>Child's name</th>
                            <th>Franchise</th>
                            <th>Location</th>
                            <th>City</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customers as $customer){
                            $franchise = get_userdata( get_post_meta( $customer->ID, 'franchise_id', true ) );
                            $franchise_name = get_user_meta( $franchise->ID, 'franchise_name', true );
                            $location = get_post( get_post_meta( $customer->ID, 'location_id', true ) );
                            ?>
                        <tr class="gradeA">
                          <td><a class="am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','customer_edit') .'&id='.$customer->ID; ?>"><?php echo get_post_meta($customer->ID, 'parents_name',true); ?></a></td>
                          <td><?php echo get_post_meta($customer->ID, 'childs_first_name',true) . " " . get_post_meta($customer->ID, 'childs_last_name',true) ?></td>
                          <td><?php echo $franchise_name; ?></td>
                          <td><?php echo $location->post_title ?></td>
                          <td><?php echo get_post_meta($customer->ID, 'city',true); ?></td>
                          <td><?php echo get_post_meta($customer->ID, 'email',true); ?></td>
                          <td>
                            <a class="am2-ajax-modal btn btn--primary is-smaller"
                            data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                            data-modal="<?php echo get_ajax_url('modal','customer_edit') .'&id='.$customer->ID; ?>"><i class="fa fa-pencil"></i></a>

                            <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                            data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                            data-object="customer" data-id="<?php echo $customer->ID; ?>"><i class="fa fa-trash-o"></i></a>
                          </td>
                        </tr>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script type="text/javascript">    
set_title('Users Management');

$(document).ready(function() {
    $('#datatable-editable').DataTable({
        dom: 'Blfrtip',
        "paging":   false,
        "ordering": false,
        "info":     false,
        buttons: [
            {
                extend: 'csv',
                className: 'btn btn--secondary',
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
            },
        ]
    });
});
</script>

<?php get_template_part('blocks/modal-template'); ?>