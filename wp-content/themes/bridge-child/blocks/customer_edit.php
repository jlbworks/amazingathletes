<?php 
global $wpdb;
global $current_user; 

restrict_access('super_admin,administrator,franchisee');

$id = $_REQUEST['id'];
$profile = get_user_by( 'id', $id );

$childs_first_name = get_post_meta( $id, 'childs_first_name', true );
$childs_last_name = get_post_meta( $id, 'childs_last_name', true );
$childs_birthday = get_post_meta( $id, 'childs_birthday', true );
$childs_gender = get_post_meta( $id, 'childs_gender', true );
$childs_shirt_size = get_post_meta( $id, 'childs_shirt_size', true );
$classroom_number_or_teachers_name = get_post_meta( $id, 'classroom_number_or_teachers_name', true );
$parents_name = get_post_meta( $id, 'parents_name', true );
$address = get_post_meta( $id, 'address', true );
$current_state = get_post_meta( $id, 'state', true );
$city = get_post_meta( $id, 'city', true );
$zip_code = get_post_meta( $id, 'zip_code', true );
$telephone = get_post_meta( $id, 'telephone', true );
$email = get_post_meta( $id, 'email', true );
$liability_release = get_post_meta( $id, 'liability_release', true );
$photo_release = get_post_meta( $id, 'photo_release', true );
$comments_or_questions = get_post_meta( $id, 'comments_or_questions', true );
$paid_tuition = get_post_meta( $id, 'paid_tuition', true );
$franchise_id = get_post_meta( $id, 'franchise_id', true );
$location_id = get_post_meta( $id, 'location_id', true );

$locations = array();
if( !$franchise_id &&  is_role( 'franchisee' )) {
    $location_args = array(
        'post_type' => 'location',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'author'            => get_current_user_id()
    );
    $locations = get_posts( $location_args );
}
elseif( $franchise_id ) {
    $location_args = array(
        'post_type' => 'location',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'author'            => $franchise_id
    );
    $locations = get_posts( $location_args );
}

$role         = $profile->roles[0];
$password     = '';

$capabilities = $profile->{$wpdb->prefix . 'capabilities'};

$franchise_args = array(
    'role' => 'franchisee'
);
if( is_role( 'franchisee' ) ) {
    $franchise_args['include'] = array(
        get_current_user_id(),
    );
}

$franchises = get_users( $franchise_args );

?>

<div class="card-wrapper">
    <h3 class="card-header">User info</h3>
    <div class="card-inner">
      <form id="customer-form" class="card-form no-inline-edit js-ajax-form">
      <div class="validation-message"><ul></ul></div>
          <div class="card-table">
              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Child's first name <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="childs_first_name" class="form-control" title="Please enter child's first name." value="<?php echo esc_attr( $childs_first_name ); ?>" placeholder="eg.: John" required />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Child's last name <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="childs_last_name" class="form-control" title="Please enter child's last name." value="<?php echo esc_attr( $childs_last_name ); ?>" placeholder="eg.: Doe" required />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Child's birthday<span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" data-js="datepicker-format" name="childs_birthday" class="form-control" title="Please choose child's birthday." value="<?php echo esc_attr( $childs_birthday ); ?>" required />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Child's gender <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <select name="childs_gender" data-js="select" class="form-control" title="Please choose child's gender." required>
                                  <option value="M" <?php selected( $childs_gender, 'M' ); ?>>M</option>
                                  <option value="F" <?php selected( $childs_gender, 'F' ); ?>>F</option>
                              </select>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Child's Shirt Size <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <select name="childs_shirt_size" data-js="select" class="form-control" title="Please choose child's shirt size." required>
                                  <option value="x-small" <?php selected( $childs_shirt_size, 'x-small' ); ?>>Child X-Small (2-4)</option>
                                  <option value="small" <?php selected( $childs_shirt_size, 'small' ); ?>>Child Small (6-8)</option>
                                  <option value="medium" <?php selected( $childs_shirt_size, 'medium' ); ?>>Child Medium (10-12)</option>
                              </select>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Classroom # or Teacher's Name</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="classroom_number_or_teachers_name" class="form-control" value="<?php echo esc_attr( $classroom_number_or_teachers_name ); ?>" />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Parent's name<span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="parents_name" class="form-control" title="Please enter parents name." value="<?php echo esc_attr( $parents_name ); ?>" required />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Address<span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="address" class="form-control" title="Please enter an address." value="<?php echo esc_attr( $address ); ?>" required />
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">State<span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <select name="state" data-js="select" class="am2_cc_state" title="Please choose a state." required>
                                  <option value=""></option>
                                  <?php
                                  $states_db = $wpdb->get_results("SELECT DISTINCT * FROM states ORDER BY state ASC");
                                  $states = array();
                                  if ($states_db) {
                                      foreach ($states_db AS $state) {?>
                                          <option <?php echo ($state->state_code == $current_state ? 'selected' : ''); ?> value="<?php echo $state->state_code; ?>"><?php echo $state->state; ?></option>
                                      <?php }

                                  } ?>
                              </select>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">City<span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="city" class="form-control" title="Please enter a city." value="<?php echo $city  ?>" required/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">ZIP Code<span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="text" name="zip_code" class="form-control" title="Please enter a ZIP code." value="<?php echo $zip_code; ?>" required/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Primary Phone Number <span class="required">*</span></span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input id="phone" name="telephone" data-plugin-masked-input="" data-input-mask="(999) 999-9999" title="Please enter a phone number." value="<?php echo $telephone; ?>" placeholder="(123) 123-1234" class="form-control" required>
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
                              <input type="email" name="email" class="form-control" title="Please enter an email address." value="<?php echo $email; ?>" placeholder="eg.: john@gmail.com" required/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Liability Release</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="checkbox" name="liability_release" class="form-control" title="This field is required." value="1" <?php checked( '1', $liability_release, 1 ); ?>" required/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Photo Release</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="checkbox" name="photo_release" class="form-control" value="1" <?php checked( '1', $photo_release, 1 ); ?>"/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Comments or Questions</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <textarea type="checkbox" name="comments_or_questions" class="form-control">
                                <?php echo $comments_or_questions; ?>
                              </textarea>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Already paid tuition</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <input type="checkbox" name="paid_tuition" class="form-control" value="1" <?php checked( '1', $paid_tuition, 1 ); ?>/>
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <?php if( current_user_can( 'administrator' ) ): ?>
              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Franchise</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <select id="franchise_id" name="franchise_id" class="form-control" title="You must select a franchise." required>
                                  <option value=""></option>
                                  <?php foreach( $franchises as $franchisee ) : ?>
                                      <option value="<?php echo $franchisee->ID; ?>" <?php selected($franchise_id, $franchisee->ID, true ); ?>><?php echo $franchisee->first_name . ' ' . $franchisee->last_name; ?></option>
                                  <?php endforeach; ?>
                              </select>
                              <!-- /# -->
                              <i class="fieldset-overlay" data-js="focus-on-field"></i>
                          </fieldset>
                      </div>
                  </div>
              </div>
              <?php endif; ?>

              <div class="card-table-row">
                  <span class="card-table-cell fixed250">Location</span>
                  <div class="card-table-cell">
                      <div class="card-form">
                          <fieldset>
                              <select id="location_id" name="location_id"  class="am2_cc_state" title="Please select a location." required>
                                  <option value=""></option>
                                  <?php
                                  if ( $locations ) {
                                      foreach ( $locations AS $location ) {?>
                                          <option <?php echo ($location->ID == $location_id ? 'selected' : ''); ?> value="<?php echo $location->ID; ?>"><?php echo $location->post_title; ?></option>
                                      <?php }
                                  } ?>
                              </select>
                          </fieldset>
                      </div>
                  </div>
              </div>

              <input type="hidden" name="id" value="<?php echo $id; ?>" />
              <input type="hidden" name="form_handler" value="customer_edit" />
              </div>
              <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Cancel</button>
                <button class="right btn btn--primary" type="submit">Save</button>
              </div>
          <?php am2_add_preloader(); ?>
         </form>
        
    </div>
</div>

<script type="text/javascript">

set_title('Customer');

$(document).ready(function () {

    var form = $("#customer-form");
    form.validate({
        // any other options,
       /* errorContainer: $("#customer-form").find( 'div.validation-message' ),
        errorLabelContainer: $("#customer-form").find( 'div.validation-message ul' ),
        wrapper: "li",*/
    });

    form.ajaxForm({
        // any other options,
        beforeSubmit: function () {
            am2_show_preloader(form);
            return $("#customer-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
            am2.main.notify('pnotify','success', json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            if(inst) {
                inst.destroy();
                load_screen('REFRESH');
            }
            else {
                empty_form(form);
            }
            am2_hide_preloader(form);
        },
        url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
        type: 'post',
        dataType: 'json'
    });

    $('[data-js="select"]').select2({
        width: '100%',
    });

    $('#location_id').select2({
        placeholder: 'Select a location',
        width: '100%'
    });

    $('#franchise_id').select2({
        placeholder: 'Select a franchise',
        width: '100%',
        minimumResultsForSearch: -1
    })
        .on('select2:select', function() {
            $.ajax({
                url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
                type: 'POST',
                dataType: 'json',
                data: {
                    form_handler: 'get_locations',
                    franchise_id: $('#franchise_id').val()
                },
                beforeSend: function() {
                    am2_show_preloader(form);
                },
                success: function(data) {
                    var placeholder = data.length == 1 ? "No locations found for this franchise" : "Choose location";

                    $('#location_id').html('').select2({
                        placeholder: placeholder,
                        width: '100%',
                        data: data
                    });
                    am2_hide_preloader(form);
                }
            })
        });

});

function addClientNote(){
    var note = $('#textarea_client_note').val();
    $('#textarea_client_note').val('');
    $.ajax({
        url: '<?php echo site_url();?>/admin/admin-ajax.php?action=submit_data',
        type: 'POST',
        dataType: 'json',
        data: {form_handler:'add-note-to-customer',company_id:'<?php echo $id;?>',note: note},
    })
        .done(function() {
            show_candidate_notes('<?php echo $id;?>');
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    return false;
}


</script>