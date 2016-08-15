<?php
global $current_user; 
get_currentuserinfo(); 

$id = $_REQUEST['id'];

restrict_access('administrator,doctor,admin_doctor');

echo( "<div>In Development</div>" );
return;

$pacijent = get_post($id);

$first_name     = $pacijent->first_name;
$last_name      = $pacijent->last_name;
$datum_rodjenja = $pacijent->datum_rodjenja;
$address        = $pacijent->address;
$city           = $pacijent->city;
$zip            = $pacijent->zip;

$contact_email  = $pacijent->contact_email;
$phone          = $pacijent->phone;

$doktor         = $pacijent->doktor;
$bolnica        = $pacijent->bolnica;

?>

<div class="card-wrapper">
    <h3 class="card-header">Pacijent<?php if( !empty($first_name) ) echo " : $first_name"." ".$last_name; ?></h3>
    <div class="card-inner">
        <form id="pacijent-form" class="card-form no-inline-edit js-ajax-form">
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
            <!-- INPUT DEFAULT (GREEN AND BOLD) -->
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Ime pacijenta <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="text" name="first_name" class="form-control" title="Please enter pacijent title." value="<?php echo esc_attr( $first_name ); ?>" placeholder="eg.: Marko" required/>
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Prezime pacijenta <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="text" name="last_name" class="form-control" title="Please enter pacijent title." value="<?php echo esc_attr( $last_name ); ?>" placeholder="eg.: Marin" required/>
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Datum rođenja <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="text" data-js="datepicker-format" name="datum_rodjenja" class="form-control" title="Please enter pacijent title." value="<?php echo esc_attr( $datum_rodjenja ); ?>" placeholder="eg.: Marin" required/>
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Adresa <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="text" name="address" class="form-control" title="Please enter address." value="<?php echo esc_attr( $address ); ?>" placeholder="eg.: Kralja Zvonimira 123" />
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card-table-row">
                <span class="card-table-cell fixed250">Grad <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="text" name="city" class="form-control" title="Please enter city." value="<?php echo esc_attr( $city ); ?>" placeholder="eg.: Zagreb" required/>
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card-table-row">
                <span class="card-table-cell fixed250">ZIP / Poštanski broj <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="text" name="zip" class="form-control" title="Please enter city." value="<?php echo esc_attr( $zip ); ?>" placeholder="eg.: 10000" />
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card-table-row">
                <span class="card-table-cell fixed250">Broj telefona <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input id="phone" name="phone" title="Unesite broj telefona." data-plugin-masked-input="" data-input-mask="(999) 999-9999" value="<?php echo esc_attr( $phone ); ?>" placeholder="(123) 123-1234" class="form-control" />
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card-table-row">
                <span class="card-table-cell fixed250">Kontakt Email<span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="text" name="contact_email" class="form-control" value="<?php echo esc_attr( $contact_email ); ?>" placeholder="eg.: contact@pacijent.com" />
                            <button data-js="submit-field" type="submit"><i class="fa fa-check"></i></button>
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="doktor" value="<?php echo $current_user->ID; ?>" />
            <input type="hidden" name="bolnica" value="<?php echo get_user_meta($current_user->ID,'bolnica_id',true); ?>" />
            <input type="hidden" name="form_handler" value="pacijent" />
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

    $("#pacijent-form").validate({
        // any other options,
        errorContainer: $("#pacijent-form").find( 'div.validation-message' ),
    		errorLabelContainer: $("#pacijent-form").find( 'div.validation-message ul' ),
    		wrapper: "li",
    });

    $("#pacijent-form").ajaxForm({
        // any other options,
        beforeSubmit: function () {
            //$('#sales_reps').val();
            return $("#pacijent-form").valid(); // TRUE when form is valid, FALSE will cancel submit
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

