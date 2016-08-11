<?php
global $current_user; 
get_currentuserinfo();

restrict_access('administrator,admin_doctor');

$users = get_users();
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
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Email</th>
                            <th>Bolnica</th>
                            <th>Role</th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user){ ?>
                        <tr class="gradeA">
                          <td><a class="am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','user_edit') .'&id='.$user->ID; ?>"><?php echo $user->user_firstname; ?></a></td>
                          <td><?php echo $user->user_lastname; ?></td>
                          <td><?php echo formatEmail($user->user_email); ?></td>
                          <td><?php
                            if( $user->bolnica_id>0 ){
                              echo formatBolnicaTitle($user->bolnica_id);
                            }else{
                              echo '-';
                            }
                          ?></td>
                          <td><?php echo $user->role; ?></td>
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
// Prekopirati sa erp-a data-tables po potrebi.
</script>

<?php get_template_part('blocks/modal-template'); ?>