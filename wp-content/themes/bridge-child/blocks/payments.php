<?php 
global $current_user; 
get_currentuserinfo();

restrict_access('administrator,franchisee');

$args = array(
  'post_type'   => 'payment',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
);
if( is_role( 'franchisee'  ) ) {
  $args['author']  = get_current_user_id();
}
$payments = get_posts($args);

?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Payments</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','payments-edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New payments Entry</button>
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
                        <th><span>Customer Name</span></th>
                        <th><span>Franchise</span></th>
                        <th><span>Location</span></th>
                        <th><span>Class</span></th>
                        <th><span>Date</span></th>
                        <th><span>Paid amount</span></th>
                        <th><span>Type</span></th>
                        <th><span>Description</span></th>
                        <th><span>Actions</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($payments as $payment){
                        $franchise_id = get_post_meta( $payment->ID, 'payment_franchise_id', true );
                        $location_id = get_post_meta( $payment->ID, 'payment_location_id', true );
                        $customer_id = get_post_meta( $payment->ID, 'payment_customer_id', true );
                        $class_id = get_post_meta( $payment->ID, 'payment_class_id', true );

                        $franchise = get_user_meta( (int)$franchise_id, 'franchise_name', true);
                        $location = get_post( (int)$location_id );
                        $customer = get_post( (int)$customer_id );
                        $class = get_post( (int)$class_id );

                        ?>
                        <tr class="gradeA">
                            <td style="white-space:nowrap"><a class="am2-ajax-modal"
                                                              data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                                                              data-modal="<?php echo get_ajax_url('modal','payments-edit') .'&id='.$payment->ID; ?>"><?php echo $customer->post_title ?></a></td>
                            <td><?php echo $franchise; ?></td>
                            <td><?php echo $location->post_title; ?></td>
                            <td><?php echo $class->post_title; ?></td>
                            <td><?php echo get_post_meta( $payment->ID, 'payment_paid_date', true ); ?></td>
                            <td><?php echo get_post_meta( $payment->ID, 'payment_paid_amount', true ); ?></td>
                            <td><?php echo get_post_meta( $payment->ID, 'payment_type', true ); ?></td>
                            <td><?php echo get_post_meta( $payment->ID, 'payment_description', true ); ?></td>

                            <td>
                                <a class="am2-ajax-modal btn btn--primary is-smaller"
                                   data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                                   data-modal="<?php echo get_ajax_url('modal','payments-edit') .'&id='.$payment->ID; ?>"><i class="fa fa-pencil"></i></a>
                                <?php if( is_role('administrator') ){ ?>
                                    <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                                       data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                                       data-object="payment" data-id="<?php echo $payment->ID; ?>"><i class="fa fa-trash-o"></i></a>
                                <?php }; ?>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
<script type="text/javascript">

set_title('Payments');
</script>

<?php get_template_part('blocks/modal-template'); ?>