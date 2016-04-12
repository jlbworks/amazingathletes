(function($){
    $(document).ready(function(){      

        $(document).on('click', 'a[href="#logout"]', function(e){
            e.preventDefault();             
            
            if(ajax_talking) return;    

            $.post(am2_ajax_url, {action: 'am2_logout'}, function(resp){
                if(resp=='adios!'){
                    $('#login_box').addClass('logged_out').removeClass('logged_in');  
                    
                    am2_alert('You have logged out successfully. Bye!', 'Log out', true);               
                }
                ajax_talking = false;
            });
            ajax_talking = true;
        });    

        $('#frm_create_team').validate({
            rules: {
                'team_name': { required: true  },           
                'team_password' : { required : true, minlength: 6},
                'team_password2' : { required : true, equalTo: "#team_password" }
            },
            /*errorPlacement: function(error, element) {
                element.siblings(".error").html(error);
            },*/
            debug: true
        });

        $('#frm_create_team').on("submit", function(){
            if(!$(this).valid()) return;
            if(ajax_talking) return;

            var serialized_form = $(this).serialize();              

            $.post(am2_ajax_url, serialized_form, function(resp){
                if(resp.success){
                    /*$('[data-remodal-id="create_team_success"]').remodal().open();                
                    
                    $(document).on('confirmation', '[data-remodal-id="create_team_success"]', function () {
                      console.log('Confirmation button is clicked');
                      //window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
                      if(resp.redirect){
                        window.location.href = resp.redirect;
                      } else {
                        window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
                      }
                    });
                    
                    $(document).on('closed', '[data-remodal-id="create_team_success"]', function (e) {
                        console.log(e);
                      // Reason: 'confirmation', 'cancellation'
                      console.log('Modal is closed' + (e.reason ? ', reason: ' + e.reason : ''));
                      //window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
                      if(resp.redirect){
                        window.location.href = resp.redirect;
                      } else {
                        window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
                      }
                    });*/
                    if(resp.redirect){
                        window.location.href = resp.redirect;
                      } else {
                        window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
                      }
                } else {
                    alert(resp.error);
                }
                console.log(resp);
                ajax_talking = false;
            });
            ajax_talking = true;
        });

        $('#frm_register').validate({
            rules: {
                'email': { required: true, email: true  },
                //'username': { required: true },
                'reg_firstname': {required: true},
                'reg_lastname': {required: true},
                'reg_password' : { required : true, minlength: 6},
                'password2' : { required : true, equalTo: "#reg_password" }
            },
             messages: {
                 'password2' : {
                    required: "Please enter a value", equalTo: 'Passwords do not match'
                 }
            },
            /*errorPlacement: function(error, element) {
                element.siblings(".error").html(error);
            },*/
            debug: true
        });

        $('#frm_register').on("submit", function(){
            if(!$(this).valid()) return;
            if(ajax_talking) return;

            var serialized_form = $(this).serialize();              

            $.post(am2_ajax_url, serialized_form, function(resp){
                if(resp.success){
                    $('[data-remodal-id="registration_success"] .message').text(resp.error);
                    $('[data-remodal-id="registration_success"]').remodal().open();             
                    $('#login_box').addClass('logged_in').removeClass('logged_out');  
                    $('.user_name').text( resp.debug.first_name + " " + resp.debug.last_name /*resp.debug.user_name*/);
                    
                    $(document).on('confirmation', '[data-remodal-id="registration_success"]', function () {
                      console.log('Confirmation button is clicked' , resp.redirect);                  
                      
                      if(resp.redirect){
                        window.location.href = resp.redirect;
                      } else {
                        window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
                      }
                      
                    });
                    
                    $(document).on('closed', '[data-remodal-id="registration_success"]', function (e) {                 
                      // Reason: 'confirmation', 'cancellation'
                        console.log('Modal is closed' + (e.reason ? ', reason: ' + e.reason : ''), resp.redirect );                     
                        
                        if(resp.redirect){
                            window.location.href = resp.redirect;
                        } else {
                            window.location.reload(true); //window.location.href = window.location.href.split('#')[0];
                        }
                    });
                } else {
                    alert(resp.error);
                }
                console.log(resp);
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

            $.post(am2_ajax_url, serialized_form, function(resp){
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

            $.post(am2_ajax_url, {action: 'ajax_forgotPassword', forgot_password: $('#forgot_password').val()}, function(resp){
                if(resp.success){       
                    $(".forgot_password_wrap").slideToggle();   
                }

                alert(resp.message);
                ajax_talking = false;
            });
            ajax_talking = true;
        });

        $('.btn-close-modal').click(function(){
            var $remodal = $(this).closest('[data-remodal-id]').remodal();
            console.log($remodal);
            $remodal.close();
        });
    });    
})(jQuery);
