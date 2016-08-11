<?php 
global $wpdb;
global $current_user; 

restrict_access('administrator,admin_doctor');

$id = $_REQUEST['id'];
$profile = get_user_by( 'id', $id );

$first_name 	= $profile->user_firstname;
$last_name 		= $profile->user_lastname;
$email	 			= $profile->user_email;
$phone	 			= get_user_meta($id, 'telephone',true);
$franchise_name	    = get_user_meta($id, 'franchise_name',true);
$address            = get_user_meta($id, 'mailing_address',true);
$zip_code           = get_user_meta($id, 'zip_code',true);
$city_state           = get_user_meta($id, 'city__state', true);
$city_state = explode( '|', $city_state );

$role         = $profile->roles[0];
$password     = '';

$capabilities = $profile->{$wpdb->prefix . 'capabilities'};

?>

<div class="card-wrapper">
    <h3 class="card-header">User info</h3>
    <div class="card-inner">
      <form id="user-form" class="card-form no-inline-edit js-ajax-form">
      <div class="validation-message"><ul></ul></div>
          <div class="card-table">
              <div class="card-table-row">
                  <span class="card-table-cell fixed250">First name <span class="required">*</span></span>
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
                  <span class="card-table-cell fixed250">Last name <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="last_name" class="form-control" title="Please enter your last name." value="<?php echo $last_name; ?>" placeholder="eg.: Marin" required/>
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
                  <span class="card-table-cell fixed250">Password <span class="required">*</span></span>
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
                  <span class="card-table-cell fixed250">Franchise name</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="franchise_name" class="form-control" value="<?php echo $franchise_name; ?>"/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Telephone</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input id="phone" name="telephone" data-plugin-masked-input="" data-input-mask="(999) 999-9999" value="<?php echo $phone; ?>" placeholder="(123) 123-1234" class="form-control">
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Address</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="mailing_address" class="form-control" value="<?php echo $address; ?>"/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">State</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <select name="state"  placeholder="Select a state..." class="am2_cc_state" required style="">
                                  <option value=""></option>
                                  <option value="">Select a state...</option>
                                  <?php
                                  $states_db = $wpdb->get_results("SELECT DISTINCT * FROM states ORDER BY state ASC");
                                  $states = array();
                                  if ($states_db) {
                                      foreach ($states_db AS $state) {?>
                                          <option <?php echo ($state->state_code == $city_state[0] ? 'selected' : ''); ?> value="<?php echo $state->state_code; ?>"><?php echo $state->state; ?></option>
                                      <?php }

                                  } ?>
                              </select>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">City</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="city" class="form-control" value="<?php echo $city_state[1];  ?>"/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">ZIP</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="zip_code" class="form-control" value="<?php echo $zip_code; ?>"/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <input type="hidden" name="id" value="<?php echo $id; ?>" />
              <input type="hidden" name="form_handler" value="user_edit" />
              </div>
              <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Cancel</button>
                <button class="right btn btn--primary" type="submit">Save</button>
              </div>
         </form>
        
    </div>
</div>

<script type="text/javascript">

set_title('User');

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