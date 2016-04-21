(function($){
    $(document).ready(function(){   

        var xhr;
        var select_state, $select_state;
        var select_city, $select_city;
        var val_city ;   
        var ajax_talking = false;

        loadDigitalArtwork();

        var city_state_selects = []

        $select_state = $('.am2_cc_state').selectize({
            onChange: function(value) {
                if (!value.length) return;

                $select_city.addClass('loading');

                select_city.disable();
                select_city.clearOptions();
                select_city.load(function(callback) {
                    xhr && xhr.abort();
                    xhr = $.ajax({
                        url: ajax_login_object.ajaxurl,
                        data: {
                            action: 'am2_get_state_cities',
                            stateID: value,
                        },
                        // url: 'https://jsonp.afeld.me/?url=http://api.sba.gov/geodata/primary_city_links_for_state_of/' + value + '.json',
                        success: function(results) {
                            select_city.enable();
                            callback(results);
                            $select_city.removeClass('loading');
                            select_city.setValue(val_city);
                            //console.log(results);
                        },
                        error: function() {
                            callback();
                        }
                    })
                });
            }
        });

        $select_city = $('.am2_cc_city').selectize({            
            valueField: 'name',
            labelField: 'name',
            searchField: ['name'],
            maxItems:1      
        });  

        $select_coaches = $('.am2_coaches').selectize({   
            multiple:true,
            maxItems:null,         
            // valueField: 'name',
            // labelField: 'name',
            // searchField: ['name'],
            //maxItems:1      
        });   

        if($select_city.length > 0 && $select_state.length > 0){
            select_city  = $select_city[0].selectize;
            select_state = $select_state[0].selectize;

            if($select_state.val() == '') select_city.disable();
            else {
                value = $select_state.val();
                val_city = $select_city.val();
                if (!value.length) return;

                $select_city.addClass('loading');

                select_city.disable();
                select_city.clearOptions();
                select_city.load(function(callback) {
                    xhr && xhr.abort();
                    xhr = $.ajax({
                        url: ajax_login_object.ajaxurl,
                        data: {
                            action: 'am2_get_state_cities',
                            stateID: value,
                        },
                        // url: 'https://jsonp.afeld.me/?url=http://api.sba.gov/geodata/primary_city_links_for_state_of/' + value + '.json',
                        success: function(results) {
                            select_city.enable();
                            callback(results);
                            $select_city.removeClass('loading');
                            select_city.setValue(val_city);
                            //console.log(results);
                        },
                        error: function() {
                            callback();
                        }
                    })
                });        
            }

            $select_state.on('change', function(){
                $('.cc_city_state').val($select_state.val() + '|' +  $select_city.val() );
            });
            $select_city.on('change', function(){
                $('.cc_city_state').val($select_state.val() + '|' +  $select_city.val() );
            });
        }

        $('#frm_franchisee_account').validate({ rules: {
        //password: "required",
        password2: {
          equalTo: "#password"
        }
      }});

        $('#frm_franchisee_account').ajaxForm({
          beforeSubmit: function() {            
            am2_show_preloader();
            return $('#frm_franchisee_account').valid();
          },
          success: function(resp) {
            am2_hide_preloader();
            alert(resp);
          },
          error: function() {
            am2_hide_preloader();
          }
        });     

        $('#frm_user_account').validate({ rules: {
        //password: "",
        password2: {
          equalTo: "#password"
        }
      }});

        $('#frm_user_account').ajaxForm({
          beforeSubmit: function() {    
            am2_show_preloader();        
            return $('#frm_user_account').valid();
          },
          success: function(resp) {
            am2_hide_preloader();
            alert(resp);
          },
          error: function() {
            am2_hide_preloader();
          }
        });   

        $('#frm_edit_location').validate({ /* ... */ });

        $('#frm_edit_location').ajaxForm({
          beforeSubmit: function() {            
            am2_show_preloader();
            return $('#frm_edit_location').valid();
          },
          success: function(resp) {
            am2_hide_preloader();
            alert(resp.message);
            location.href = permalink + '?loc_id=' + resp.loc_id;
          },
          error: function() {
            am2_hide_preloader();
          }
        });     

        $('#frm_edit_location [name="address"], #frm_edit_location [name="city"], #frm_edit_location [name="state"], #frm_edit_location [name="zip"]').on('change', function(){
            $.get('https://maps.googleapis.com/maps/api/geocode/json?address='+encodeURIComponent($('[name="address"]').val() + ", " + $('[name="city"]').val() + ", " + $('[name="state"]').val() + " " + $('[name="zip"]').val()),function(res){                
                console.log($('[name="address"]').val() + ", " + $('[name="city"]').val() + ", " + $('[name="state"]').val() + " " + $('[name="zip"]').val());
                if(typeof res.results[0].geometry.location != 'undefined'){
                    $('.latlng').val(res.results[0].geometry.location.lat + "," + res.results[0].geometry.location.lng);    
                    initMap();     
                }                
            });
        });

        $(document).on('click','#btn_delete_franchisee_photo', function(e){
            e.preventDefault();
            delete_digital_artwork($(this).data('attid'));
        });

        $(document).on('click', 'a[href="#logout"]', function(e){
            e.preventDefault();             
            
            if(ajax_talking) return;    

            $.post(ajax_login_object.ajaxurl, {action: 'am2_logout'}, function(resp){
                if(resp=='adios!'){
                    $('#login_box').addClass('logged_out').removeClass('logged_in');  
                    
                    am2_alert('You have logged out successfully. Bye!', 'Log out', true);               
                }
                ajax_talking = false;
            });
            ajax_talking = true;
        });    

        $('#frm_login').validate({
            rules: {
                'username': { required: true },
                'password' : { required : true }            
            },
            /*errorPlacement: function(error, element) {
                element.siblings(".error").html(error);
            },*/
            debug: true
        });

        $('#frm_login').on("submit", function(){                        
            if(!$(this).valid()) return;
            if(ajax_talking) return;

            var serialized_form = $(this).serialize();              

            $.post(ajax_login_object.ajaxurl, serialized_form, function(resp){
                if(resp.loggedin){
                    $('#login_box').addClass('logged_in').removeClass('logged_out');                        
                    
                    am2_alert("You have logged in successfully. Welcome!", "Log in", resp.redirect);
                    
                } else {
                    am2_alert(resp.message, "Log in", false);
                    
                }
                console.log(resp);
                ajax_talking = false;
            });
            ajax_talking = true;
        });

        $(".show_forgot_password").click(function(e){
            e.preventDefault();
            $(".forgot_password_wrap").show();
        });

        $("#new_password").click(function(){
            if(ajax_talking) return;

            $.post(ajax_login_object.ajaxurl, {action: 'ajax_forgotPassword', forgot_password: $('#forgot_password').val()}, function(resp){
                if(resp.success){       
                    $(".forgot_password_wrap").slideToggle();   
                }

                alert(resp.message);
                ajax_talking = false;
            });
            ajax_talking = true;
        });

        $('.btn_toggle_add_coach').on('click', function(e){
            e.preventDefault();
            $('.add_coach_wrap').slideToggle();
        });

         $('.btn_add_coach').on('click', function(e){
            e.preventDefault();
            $.post(ajax_login_object.ajaxurl, {action: 'am2_add_coach', first_name: $('#first_name').val(), last_name: $('#last_name').val(), coach_email: $('#coach_email').val() }, function(resp){
                if(resp.status == 'success') {
                    alert('Successfully added coach');
                    var select_coaches = $select_coaches[0].selectize;
                    console.log(resp);
                    select_coaches.addOption({value: resp.user_id, text: $('#first_name').val() + ' ' + $('#last_name').val()});
                    select_coaches.addItem(resp.user_id);
                    select_coaches.refreshOptions();
                } else {
                    alert('Error');
                }
            });
         });

    });    
    
    function initMap() {
      var myLatLng = $('.latlng').val().split(',');
      myLatLng = {lat: parseFloat(myLatLng[0]), lng: parseFloat(myLatLng[1])};
      console.log(myLatLng);

      // Create a map object and specify the DOM element for display.
      var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        scrollwheel: false,
        zoom: 15
      });

      // Create a marker and set its position.
      var marker = new google.maps.Marker({
        map: map,
        position: myLatLng,
        title: 'Hello World!'
      });
    }

    //Delete image
    function delete_digital_artwork(attach_id){
       jQuery.ajax({
            url:ajax_login_object.ajaxurl,
            type:'POST',
            data:'action=ajax_delete_field&attachid=' + attach_id,
            success:function(results)
            {                     
                jQuery('input[name="digital_file_name"]').val('');

                jQuery('#btn_delete_franchisee_photo').fadeOut(400, function(){ 
                    jQuery(this).parent().empty().append('<div id="digital_image_upload" style="display:none;">Upload</div>'); 
                    jQuery('#digital_image_upload').fadeIn(); 
                    loadDigitalArtwork();
                });
            }
        });
    }

    function loadDigitalArtwork(){
        if(typeof uploadOptions === 'undefined') return;
        
        uploadOptions['request']['params']['field'] = 'franchisee_photo';
        jQuery('#digital_image_upload').fineUploader(uploadOptions).on('complete', function(event, id, fileName, responseJSON) {
           if (responseJSON.success) {
             jQuery(this).parent().delay(1000).fadeOut(400, function(){
                  jQuery(this).empty().append('<div class="upload_success"><img src="'+responseJSON.file_url+'" /></div>').append("<a class='delete_button button' id='btn_delete_franchisee_photo' data-attid="+responseJSON.file_id+" >Delete file</a>").fadeIn();
                  jQuery('input[name="digital_file_name"]').val(responseJSON.file_name);
              });
           }
        });
    }                

    function am2_alert(message, title, reload_redirect, callback){      

        $('[data-remodal-id="message"] .title').html(title);
        $('[data-remodal-id="message"] .message').html(message);
        $('[data-remodal-id="message"]').remodal().open();
        
        $(document).off('confirmation', '[data-remodal-id="message"]').on('confirmation', '[data-remodal-id="message"]', function () {
          console.log('Confirmation button is clicked');      
          if(reload_redirect === true){
                window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
          } else if(reload_redirect === false) {
             
          } else {
                window.location.href = reload_redirect;     
          }
              
          if(callback) callback();
            
        });
        
        $(document).off('closed', '[data-remodal-id="message"]').on('closed', '[data-remodal-id="message"]', function (e) {     
          // Reason: 'confirmation', 'cancellation'
          console.log('Modal is closed' + (e.reason ? ', reason: ' + e.reason : ''));     
          if(reload_redirect === true){     
            window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
          } else if(reload_redirect) {
            window.location.href = reload_redirect;     
          }     
            
        });
    }

    function am2_show_preloader(){
        $('#preloader_wrap').show();
    }

    function am2_hide_preloader(){
        $('#preloader_wrap').hide();
    }
    
})(jQuery);
