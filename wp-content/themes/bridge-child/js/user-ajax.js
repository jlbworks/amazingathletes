(function($){
    $(document).ready(function(){   

        var xhr;
        var select_state, $select_state;
        var select_city, $select_city;
        var val_city ;   
        var ajax_talking = false;

        $select_state = $('[name="franchise_state"]').selectize({
            onChange: function(value) {
                loadCities(value);
            }
        });

        $select_city = $('[name="franchise_city"]').selectize({            
            valueField: 'name',
            labelField: 'name',
            searchField: ['name'],
            maxItems:1      
        });    

        if($select_city.length > 0 && $select_state.length > 0){
            select_city  = $select_city[0].selectize;
            select_state = $select_state[0].selectize;

            if($select_state.val() == '') select_city.disable();
            else {
                val_city = $select_city.val();
                loadCities($select_state.val());            
            }

            $select_state.on('change', function(){
                $('[name="franchise_city_state"]').val($select_state.val() + '|' +  $select_city.val() );
            });
            $select_city.on('change', function(){
                $('[name="franchise_city_state"]').val($select_state.val() + '|' +  $select_city.val() );
            });
        }

        $('#frm_franchisee_account').validate({ /* ... */ });

        $('#frm_franchisee_account').ajaxForm({
          beforeSubmit: function() {            
            return $('#frm_franchisee_account').valid();
          },
          success: function(resp) {
            alert(resp);
          }
        });        

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

        function loadCities(value){
            if (!value.length) return;
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
                        select_city.setValue(val_city);
                        //console.log(results);
                    },
                    error: function() {
                        callback();
                    }
                })
            });
        }

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

    });    
})(jQuery);
