<?php
global $current_user; 
get_currentuserinfo();

restrict_access('administrator,super_admin');

$customers = get_users();
?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Users Management</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','user_edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New User</button>
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
                            <th>Email</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Role</th>
                            <th>Franchise Name</th>
                            <th>Telephone</th>
                            <th>Address</th>
                            <th>ZIP</th>
                            <th>State, City</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customers as $user){ ?>
                        <tr class="gradeA">
                          <td><?php echo formatEmail($user->user_email); ?></td>
                          <td><a class="am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','user_edit') .'&id='.$user->ID; ?>"><?php echo $user->user_firstname; ?></a></td>
                          <td><?php echo $user->user_lastname; ?></td>
                          
                          <td><?php echo ucwords($user->roles[0]); ?></td>
                          <td><?php echo get_user_meta($user->ID, 'franchise_name',true); ?></td>
                          <td><?php echo get_user_meta($user->ID, 'telephone',true); ?></td>
                          <td><?php echo get_user_meta($user->ID, 'mailing_address',true); ?></td>
                          <td><?php echo get_user_meta($user->ID, 'zip_code',true); ?></td>
                          <td><?php echo get_user_meta($user->ID, 'city__state',true); ?></td>

                            <td>
                            <a class="am2-ajax-modal btn btn--primary is-smaller"
                            data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                            data-modal="<?php echo get_ajax_url('modal','user_edit') .'&id='.$user->ID; ?>"><i class="fa fa-pencil"></i></a>
                            &nbsp;
                            <a class="am2-ajax-modal btn btn--secondary is-smaller"
                            data-original-title="Change password" data-placement="top" data-toggle="tooltip"
                            data-modal="<?php echo get_ajax_url('modal','user-changepassword') .'&id='.$user->ID; ?>"><i class="fa fa-lock"></i></a>
                            &nbsp;
                            <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                            data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                            data-object="user" data-id="<?php echo $user->ID; ?>"><i class="fa fa-trash-o"></i></a>
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

     $('#datatable-editable thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );

    var table = $('#datatable-editable').DataTable({
        dom: 'Blfrtip',
        "paging":   false,
        "ordering": false,
        "info":     false,
        responsive: true,
        buttons: [
            {
                extend: 'csv',
                className: 'btn btn--secondary',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8]
                }
            },
        ]
    });
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
});
</script>

<?php get_template_part('blocks/modal-template'); ?>