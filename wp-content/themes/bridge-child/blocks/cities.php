<?php 
global $current_user; 
get_currentuserinfo();

restrict_access('administrator,franchisee,coach');

$hash_query = str_replace('?','',$_REQUEST['target_args']);
parse_str($hash_query,$hash_query);


?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Cities</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','cities-edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New Cities Entry</button>
            </div>
        </div>
    </div>

        
<script type="text/javascript">

set_title('Cities');

$(document).ready(function() {
    // $('#datatable-editable').DataTable({
    //     dom: 'Blfrtip',
    //     "paging":   false,
    //     "ordering": false,
    //     "info":     false,
    //     buttons: [
    //         {
    //             extend: 'csv',
    //             className: 'btn btn--secondary',
    //             exportOptions: {
    //                 columns: [0,1,2,3]
    //             }
    //         },
    //     ]
    // });
});
</script>

<?php get_template_part('blocks/modal-template'); ?>