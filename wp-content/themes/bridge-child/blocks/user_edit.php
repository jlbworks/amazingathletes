<?php 
global $wpdb;
global $current_user; 

restrict_access('administrator,admin_doctor');

$id = $_REQUEST['id'];
$profile = get_user_by( 'id', $id );

$first_name 	= $profile->user_firstname;
$last_name 		= $profile->user_lastname;
$email	 			= $profile->user_email;
$phone	 			= $profile->phone;
$website      = $profile->website;

$bolnica_id   = $profile->bolnica_id;

$role         = $profile->role;
$password     = '';

$linkedin   = $profile->linkedin;

$bolnice = get_posts(array(
  'post_type'   => 'bolnice',
  'post_status' => 'publish',
  'posts_per_page'=>-1
));
foreach($bolnice as $bolnica){
  $bolnica_options[$bolnica->ID] = $bolnica->post_title;
}


$capabilities = $profile->{$wpdb->prefix . 'capabilities'};

?>

<div class="card-wrapper">
    <h3 class="card-header">Podaci</h3>
    <div class="card-inner">
      <form id="user-form" class="card-form no-inline-edit js-ajax-form">
      <div class="validation-message"><ul></ul></div>
          <div class="card-table">
              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Ime <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="first_name" class="form-control" title="Please enter your first name." value="<?php echo esc_attr( $first_name ); ?>" placeholder="eg.: Marko" required />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Prezime <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="last_name" class="form-control" title="Plase enter your last name." value="<?php echo $last_name; ?>" placeholder="eg.: Marin" required/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Email <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="email" name="email" class="form-control" title="Please enter an email address." value="<?php echo $email; ?>" placeholder="eg.: marko@gmail.com" required/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <?php if( !$id>0 ) { ?>
              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Lozinka <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="password" name="password" class="form-control" title="Please enter account password." value="<?php echo $password; ?>" placeholder="eg.: lozinka123" required/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>
              <?php } ?>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Website</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="website" class="form-control" value="<?php echo $website; ?>" placeholder="eg.: http://clubzone.com/" />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Telefon</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input id="phone" name="phone" data-plugin-masked-input="" data-input-mask="(999) 999-9999" value="<?php echo $phone; ?>" placeholder="(123) 123-1234" class="form-control">
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">LinkedIn</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="url" name="linkedin" title="Please enter a valid url." class="form-control" value="<?php echo $linkedin; ?>" placeholder="eg.: http://linkedin.com/myprofile" />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Uloga</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset class="radio-default">
                              <div class="col-12">
                                <span style="display:block">Doktor</span>
                                <input type="radio" name="role" checked="checked" id="radio-role1" value="doctor" <?php if( $role=='doctor' ){ ?>checked="checked"<?php }; ?> />
                                <label for="radio-role1"><i></i></label>
                              </div>
                              <div class="col-12">
                                <span style="display:block">Admin Doktor</span>
                                <input type="radio" name="role" id="radio-role2" value="admin_doctor" <?php if( $role=='admin_doctor' ){ ?>checked="checked"<?php }; ?> />
                                <label for="radio-role2"><i></i></label>
                              </div>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Bolnica</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset class="select-dropdown-wrapper" style="width: 100%;">
                              <?php echo dropdown( 'bolnica_id', $bolnica_id, $bolnica_options, array('data-plugin-selectTwo'=>'','class'=>"form-control populate",'required'=>'') );?>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <input type="hidden" name="id" value="<?php echo $id; ?>" />
              <input type="hidden" name="form_handler" value="user_edit" />
              </div>
              <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Odustani</button>
                <button class="right btn btn--primary" type="submit">Snimi</button>
              </div>
         </form>
        
    </div>
</div>

<script type="text/javascript">

set_title('Bolnica');

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
            am2.main.notify('pnotify','success', json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            inst.destroy();
            load_screen('REFRESH');
        },
        url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
        type: 'post',
        dataType: 'json'
    });

});

</script>