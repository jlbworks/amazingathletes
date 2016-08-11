<?php 
global $wpdb;
global $current_user; 

if( $_REQUEST['id']>0 ){
  $id = $_REQUEST['id'];
}else{
  $id = $current_user->ID;
}

$profile = get_user_by( 'id', $id );

$first_name 	= $profile->user_firstname;
$last_name 		= $profile->user_lastname;
$email	 			= $profile->user_email;
$phone	 			= $profile->phone;
$website      = $profile->website;

$password     = '';

$capabilities = $profile->{$wpdb->prefix . 'capabilities'};

?>

<div class="card-wrapper">
    <h3 class="card-header">Promjeni lozinku za <?php echo $profile->first_name.' '.$profile->last_name; ?></h3>
    <div class="card-inner">
        <form id="user-form" class="card-form no-inline-edit js-ajax-form">
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
              <!-- INPUT DEFAULT (GREEN AND BOLD) -->
              <?php if( $id>0 ){ ?>
              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Nova Lozinka <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="password" name="password" class="form-control" title="Please enter new password." value="<?php echo $password; ?>" placeholder="eg.: password" required/>
                          </fieldset>
                      </div>
                  </div>
              </div>
              <?php }; ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="form_handler" value="user_changepassword" />
          </div>
          <div class="card-footer clearfix">
              <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Odustani</button>
              <button class="right btn btn--primary" type="submit">Snimi</button>
          </div>
        </form>
    </div>
</div>


<script type="text/javascript">

set_title('Change password');

$(document).ready(function () {

    $("#user-form").validate({
        // any other options,
        errorContainer: $("#user-form").find( 'div.validation-message' ),
        errorLabelContainer: $("#user-form").find( 'div.validation-message ul' ),
        wrapper: "li",
    });

    $("#user-form").ajaxForm({
        // any other options,
        beforeSubmit: function () {
            return $("#user-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
            am2_notify(json);
            $.magnificPopup.close();
            load_screen('users-management');
        },
        url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
        type: 'post',
        dataType: 'json'
    });

});

</script>