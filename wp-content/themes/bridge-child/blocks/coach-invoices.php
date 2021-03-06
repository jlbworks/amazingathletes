<?php 
global $current_user; 
get_currentuserinfo();

restrict_access('super_admin,administrator,franchisee,coach');

$args = array(
  'post_type'   => 'invoice',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
  'meta_query' => array(
    array(
        'key' => 'invoice_type',
        'value' => 'coach',
        'compare' => '='
    )
   ),
);

if( is_role( 'franchisee'  ) || is_role( 'coach'  ) ) {
  $args['author']  = get_current_user_id();
}
$coach_invoices = get_posts($args);

?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Coach Invoices</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','coach-invoice-add') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New Coach Invoice</button>
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
                        <th><span>Coach Name</span></th>
                        <th><span>Franchise</span></th>
                        <th><span>Location</span></th>
                        <th><span>Date Created</span></th>
                        <th><span>Total amount</span></th>
                        <th><span>Status</span></th>
                        <th><span>Actions</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($coach_invoices as $coach_invoice){
                        $franchise_id = get_post_meta( $coach_invoice->ID, 'franchise_id', true );
                        $coach_id = get_post_meta( $coach_invoice->ID, 'coach_id', true );
                        $location_id = get_post_meta( $coach_invoice->ID, 'location_id', true );
                        //$customer_id = get_post_meta( $payment->ID, 'payment_customer_id', true );
                        //$class_id = get_post_meta( $payment->ID, 'payment_class_id', true );

                        $franchise = get_user_meta( (int)$franchise_id, 'franchise_name', true);
                        $location = get_post( (int)$location_id );
                        $coach = get_user_by('id', $coach_id );
                        $coach_name = $coach->display_name;
                        if(!empty($coach->first_name) || !empty($coach->last_name)) {
                            $coach_name = $coach->first_name . ' ' . $coach->last_name;
                        }
                        //$customer = get_post( (int)$customer_id );
                        //$class = get_post( (int)$class_id );

                        ?>
                        <tr class="gradeA">
                            <td style="white-space:nowrap"><?php echo $coach_name ?></td>
                            <td><?php echo $franchise; ?></td>
                            <td><?php echo $location->post_title; ?></td>
                            <td><?php echo get_the_date( 'd.m.Y H:i:s', $coach_invoice->ID );?></td>
                            <td><?php echo $coach_invoice->grand_total; ?></td>
                            <td><?php echo $coach_invoice->status; ?></td>
                            <td>
                                <a class="btn btn--primary is-smaller"
                                   data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                                   href="#coach-invoice/?id=<?php echo $coach_invoice->ID; ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                                       data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                                       data-object="invoice" data-id="<?php echo $coach_invoice->ID; ?>"><i class="fa fa-trash-o"></i></a>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
<script type="text/javascript">

set_title('Payments');

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
                    columns: [0,1,2,3,4,5,6,7]
                }
            },
        ]
    });
});
</script>

<?php get_template_part('blocks/modal-template'); ?>