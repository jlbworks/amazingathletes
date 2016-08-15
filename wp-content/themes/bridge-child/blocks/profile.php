<?php 
global $current_user; 
get_currentuserinfo();

$profile = $current_user;

$first_name   = $profile->first_name;
$last_name    = $profile->last_name;
$email        = $profile->user_email;
$phone        = $profile->phone;
$website      = $profile->website;
$facebook   = $profile->facebook;
$linkedin   = $profile->linkedin;
$department   = $profile->department;
$responsibilities = $profile->responsibilities;
?>

<!-- CONTENT HEADER -->
<div class="layout context--pageheader">
    <div class="container clearfix">
        <div class="col-12 break-big">
            <h1>Profile</h1>
        </div>
    </div>
</div>

<div class="layout">
          <div class="container clearfix">
            <div class="col-12 break-big">
              <div class="validation-message">
                <ul>
                </ul>
              </div>
              <form id="profile-form" class="card-form no-inline-edit js-ajax-form">

                <div class="card-wrapper">
                  <h3 class="card-header">Information</h3>
                  <div class="card-inner">
                    <div class="card-table">

                      <div class="card-table-row">
                        <span class="card-table-cell fixed250">First Name</span>
                        <div class="card-table-cell">
                          <div class="card-form">
                            <fieldset>
                              <input type="text" name="first_name" class="form-control" title="Please enter your first name." value="<?php echo $first_name; ?>" placeholder="eg.: John" required/>
                            </fieldset>
                          </div>
                        </div>
                      </div>

                      <div class="card-table-row">
                        <span class="card-table-cell fixed250">Last Name</span>
                        <div class="card-table-cell">
                          <div class="card-form">
                            <fieldset>
                              <input type="text" name="last_name" class="form-control" title="Please enter your last name." value="<?php echo $last_name; ?>" placeholder="eg.: Doe" required/>
                            </fieldset>
                          </div>
                        </div>
                      </div>

                      <div class="card-table-row">
                        <span class="card-table-cell fixed250">Email</span>
                        <div class="card-table-cell">
                          <div class="card-form">
                            <fieldset>
                              <input type="email" name="email" class="form-control" title="Please enter an email address." value="<?php echo $email; ?>" placeholder="eg.: john@doe.com" required/>
                            </fieldset>
                          </div>
                        </div>
                      </div>

                      <div class="card-table-row">
                        <span class="card-table-cell fixed250">Website</span>
                        <div class="card-table-cell">
                          <div class="card-form">
                            <fieldset>
                              <input type="url" name="website" title="Please enter a valid url." class="form-control" value="<?php echo $website; ?>" placeholder="eg.: http://clubzone.com/" />
                            </fieldset>
                          </div>
                        </div>
                      </div>

                      <div class="card-table-row">
                        <span class="card-table-cell fixed250">Phone</span>
                        <div class="card-table-cell">
                          <div class="card-form">
                              <fieldset>
                                <input id="phone" name="phone" data-plugin-masked-input="" data-input-mask="(999) 999-9999" value="<?php echo $phone; ?>" placeholder="(123) 123-1234" class="form-control">
                            </fieldset>
                          </div>
                        </div>
                      </div>

                
              </div>
            </div>
          </div>
        <input type="hidden" name="form_handler" value="profile" />
        <div class="card-footer clearfix">
            <button class="right btn btn--primary" type="submit">Save</button>
        </div>
      </form>
    </div>

    <div class="col-12 break-big">
      <div class="validation-message">
        <ul>
        </ul>
      </div>
      <form id="user-pass-form" class="card-form no-inline-edit js-ajax-form">

        <div class="card-wrapper">
          <h3 class="card-header">Change Password</h3>
          <div class="card-inner">
            <div class="card-table">

              <div class="card-table-row">
                <span class="card-table-cell fixed250">New Password</span>
                <div class="card-table-cell">
                  <div class="card-form">
                    <fieldset>
                      <input type="p" name="password" class="form-control" placeholder="******" value="" required />
                       <input type="hidden" name="id" value="<?php echo $profile->ID; ?>" />
                        <input type="hidden" name="form_handler" value="user_changepassword" />
                    </fieldset>
                  </div>
                </div>
              </div>
          </div>
        </div>  
      </div>
      <div class="card-footer clearfix">
            <button class="right btn btn--primary" type="submit">Save</button>
        </div>
    </form>
  </div>
</div>
</div>



<script type="text/javascript">

$(document).ready(function () {

    $("#profile-form").validate({ // initialize the plugin
        // any other options,
        errorContainer: $("#profile-form").find( 'div.validation-message' ),
    		errorLabelContainer: $("#profile-form").find( 'div.validation-message ul' ),
    		wrapper: "li",
    });
 
    $("#profile-form").ajaxForm({ // initialize the plugin
        // any other options,
        beforeSubmit: function () {
            return $("#profile-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
      			am2_notify(json);
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json',
    });

});



$(document).ready(function () {

    $("#user-pass-form").validate({
        // any other options,
        errorContainer: $("#user-pass-form").find( 'div.validation-message' ),
        errorLabelContainer: $("#user-pass-form").find( 'div.validation-message ul' ),
        wrapper: "li",
    });

    $("#user-pass-form").ajaxForm({
        // any other options,
        beforeSubmit: function () {
            return $("#user-pass-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
            am2_notify(json);
            load_screen('profile');
        },
        url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
        type: 'post',
        dataType: 'json'
    });

});

</script>
<script type="text/javascript">
  set_title('My Profile');
</script>




