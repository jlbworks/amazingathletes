(function($){
    $(document).ready(function(){   

        var xhr;
        var select_state, $select_state;
        var select_city, $select_city;
        var val_city ;   
        var ajax_talking = false;
        var loc_state = null;
        var state_name = "";

        loadDigitalArtwork();

        var city_state_selects = [];

        if(window.location.protocol + '//' + window.location.hostname !== window.location.href){
            //$('a[href="'+window.location.href.split('?')[0]+'"]').addClass('current');
            $('a').each(function(){
            	try{
            		var link = $(this).attr('href').replace(/\/$/, "");;
	            	var url = window.location.href.split('?')[0].replace(/\/$/, "");;

	            	if(link == url){
	            		$(this).addClass('current');
	            	}	
            	}
            	catch(exc){}
            });
        }
        
        try{
            var myId = getVideoId(author_object.video_url);
            console.log(myId);

            $('#franchise_video').html('<iframe width="100%" height="315" src="//www.youtube.com/embed/' + myId + '" frameborder="0" allowfullscreen></iframe>');
        } catch (exc) {
            console.log(exc);
        }

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

        $('#frm_edit_mypage input[type="submit"]').on('mousedown',function(e){
            tinyMCE.triggerSave();
        });

        $('#frm_edit_mypage').ajaxForm({
          beforeSubmit: function() {            
            am2_show_preloader();            
            return true; //$('#frm_edit_mypage').valid();
          },
          success: function(resp) {
            am2_hide_preloader();            
            alert(resp.status);
            if(typeof (resp.post_id) != 'undefined') {                
                window.location.href = updateQueryStringParameter(window.location.href, 'post_id', resp.post_id );
            }
          },
          error: function() {
            am2_hide_preloader();
          }
        });     

        $('#frm_franchisee_account').validate({ rules: {
    
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

        $('#frm_user_password').validate({ rules: {
            //password: "required",
            password2: {
                equalTo: "#password"
            }
        }});

        $('#frm_user_password').ajaxForm({
          beforeSubmit: function() {    
            am2_show_preloader();        
            return $('#frm_user_password').valid();
          },
          success: function(resp) {
            am2_hide_preloader();
            alert(resp);
          },
          error: function() {
            am2_hide_preloader();
          }
        });   

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
                if(typeof res != 'undefined' && typeof res.results != 'undefined' && res.length > 0){
                    $('.latlng').val(res.results[0].geometry.location.lat + "," + res.results[0].geometry.location.lng);    
                    initMap();     
                }                
            });
        });

        $(document).on('click','#btn_delete_user_photo', function(e){
            e.preventDefault();
            delete_digital_artwork($(this).data('attid'), $(this).data('user-id'));
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

            if($.trim($('#first_name').val()) == '' || $.trim($('#first_name').val()) == '' || $.trim($('#coach_email').val()) == ''){
                alert("Please fill all the fields");
                return;
            }

            if(!isValidEmailAddress($.trim($('#coach_email').val())) ){
                alert("Please enter a valid email address");
                return;   
            }

            $.post(ajax_login_object.ajaxurl, {action: 'am2_add_coach', first_name: $('#first_name').val(), last_name: $('#last_name').val(), coach_email: $('#coach_email').val(), loc_id: $('[name="loc_id"]').val() }, function(resp){
                if(resp.status == 'success') {

                    alert('Successfully added coach');

                    var select_coaches = $select_coaches[0].selectize;                    
                    select_coaches.addOption({value: resp.user_id, text: $('#first_name').val() + ' ' + $('#last_name').val()});
                    select_coaches.addItem(resp.user_id);
                    select_coaches.refreshOptions();

                    $('.add_coach_wrap').slideToggle();
                } else {
                    alert('Error');
                }
            });
         });

         $('#frm_edit_staff').on('submit', function(e){
            e.preventDefault();

            if($.trim($('#first_name').val()) == '' || $.trim($('#first_name').val()) == '' || $.trim($('#coach_email').val()) == ''){
                alert("Please fill all the fields");
                return;
            }

            if(!isValidEmailAddress($.trim($('#coach_email').val())) ){
                alert("Please enter a valid email address");
                return;   
            }

            $.post(ajax_login_object.ajaxurl, 
                {
                action: $(this).find('[name="action"]').val(), 
                first_name: $('#first_name').val(), 
                last_name: $('#last_name').val(), 
                coach_email: $('#coach_email').val(), 
                coach_description: $('#coach_description').val(), 
                user_id: $('#user_id').val(),
                attid: $('#btn_delete_user_photo').data('attid')
                }, 
                
                function(resp){
                if(resp.status == 'success') {

                    alert('Successfully edited staff member');
            
                } else {
                    alert('Error');
                }
            });
         });

        if($('.dynamic-locaion-content').length > 0){
            $('.dynamic-locaion-content').html(
                '<form id="frmFilterMap">' +
                    '<input type="text" name="franchise_name" id="txtFranchiseName" placeholder="franchise name" />'+
                    '<input type="text" name="zip_code" id="txtZipCode" placeholder="zip code" />'+
                    '<input type="hidden" name="state" id="hidState" />'+
                    '<input type="hidden" name="action" id="hidAction" value="am2_filter_locations" />'+
                    '<input type="submit" value="filter" />'+
                '</form><br/>'+
                '<div class="list">'+
                '<div class="state"></div>'+
                '</div>'
            );

            $('#frmFilterMap').on('submit', function(e){
                e.preventDefault();                
                
                am2_show_preloader();
                $.get(ajax_login_object.ajaxurl, $(this).serialize(), function(resp){
                    am2_hide_preloader();
                    console.log(resp);

                    var init = Object.keys( resp) .length > 0 ? '' : 'There are no results for your query in '+ state_name;

                    $('.dynamic-locaion-content .list .state').html(init);

                    $.each(resp, function(k,v){                        
	                	var $ul_child = $('<ul class="locations" data-id="'+ k +'"></ul>');

		                $.each(v, function(k2,v2){                        
		                	$li_child = $('<li class="franchise"></li>');
		                	$li_child.append('<a>'+v2.meta.post_title+'</a>');
		                	$li_child.append(
		                	'<div class="franchise_details">' +
			                	'<span class="franchise_address">' + v2.meta.address + ', ' + k + ', ' + loc_state + " " + v2.meta.zip + '</span><br/>' +
			                	'<a href="'+ajax_login_object.site_url+'/choose-class/?location_id='+v2.id+'" class="h1 franchise_register">Register Now</a><br/>' +
			                	'<span class="franchise_name"><a href="'+v2.meta_franchisee.url+'">' + v2.meta_franchisee.franchise_name + '</a></span><br/>' +
			                	'<span class="franchise_footer">' + v2.meta.director + ' | ' + v2.meta.telephone + '</span><br/>' +
		                	'</div>'
		                	);
		                    
		                    $ul_child.append($li_child);
		                });                      

		                $('.dynamic-locaion-content .list .state').append($ul_child);                        
		            });
                    $('.dynamic-locaion-content .list .state .locations').show();
                });
            });            
        }


         $('#regions path, #text-abb text').on('click', function(){            
            loc_state = $('#text-abb text#'+$(this).attr('id')).text();

            $('#hidState').val(loc_state);

            if($(this).is('text')) {
                loc_state = $(this).text();
                $('#regions path').attr('class','');
            	$('#regions path[id="'+$(this).attr('id')+'"]').attr('class','selected');
            }   
            else {
            	$('#regions path').attr('class','');
            	$(this).attr('class','selected');
            	console.log(this);
            }            

            am2_show_preloader();            
            $.get(ajax_login_object.ajaxurl, {action:'am2_get_state_locations', am2_state:loc_state}, function(resp){
                console.log(resp);                

                $.each(ajax_login_object.states, function(k,v){
                	if(v.state_code == loc_state){
                		state_name = v.state;
                	}
                });

                var $state = $('<div class="state"></div>');

                $state.append('<h1 class="state_title" style="text-align: center;"><span class="td"><img src="'+ajax_login_object.theme_url+'/img/states/'+ loc_state +'.png" /></span><span class="td">'+state_name+'</span></h1>')
                
                if(Object.keys(resp).length>0){
                	var $ul = $('<select class="cities"></select>');
                
	                $.each(resp, function(k,v){
	                    var $li = $('<option value="'+k+'" data-id="'+ k +'"></option>');
	                    $li.append(k);                    
	                    
	                    $ul.append($li);
	                });      

	                $state.append($ul);

	                $state.append('<span class="h1">Choose a Location</span>');
	                
	                $.each(resp, function(k,v){
	                	var $ul_child = $('<ul class="locations" data-id="'+ k +'"></ul>');

		                $.each(v, function(k2,v2){                        
		                	$li_child = $('<li class="franchise"></li>');
		                	$li_child.append('<a>'+v2.meta.post_title+'</a>');
		                	$li_child.append(
		                	'<div class="franchise_details">' +
			                	'<span class="franchise_address">' + v2.meta.address + ', ' + k + ', ' + loc_state + " " + v2.meta.zip + '</span><br/>' +
			                	'<a href="'+ajax_login_object.site_url+'/choose-class/?location_id='+v2.id+'" class="h1 franchise_register">Register Now</a><br/>' +
			                	'<span class="franchise_name"><a href="'+v2.meta_franchisee.url+'">' + v2.meta_franchisee.franchise_name + '</a></span><br/>' +
			                	'<span class="franchise_footer">' + v2.meta.director + ' | ' + v2.meta.telephone + '</span><br/>' +
		                	'</div>'
		                	);
		                    
		                    $ul_child.append($li_child);
		                });                      

		                $state.append($ul_child);
		            });

	                $('.dynamic-locaion-content .list').html($state);

                    var options = $('select.cities option');
                    var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
                    arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
                    options.each(function(i, o) {
                      o.value = arr[i].v;
                      $(o).text(arr[i].t);
                    });  

                    $('select.cities').html(options);

	                $('html, body').animate({scrollTop: $('.dynamic-locaion-content').eq(0).offset().top},500); 	                

	                $('.state .cities').off('change').on('change', function(e){	                	
	                	//$('.state .cities li').removeClass('selected');
	                	//$(this).addClass('selected');
	                	var data_id = $(this).val();// $(this).find('[value="'+$(this).val()+'"]').data('id');
	                	var $locations = $('.state .locations[data-id="'+data_id+'"]').eq(0);

	                	console.log($(this).val());

	                	$('.state .locations').hide();
	                	$('.state .locations[data-id="'+data_id+'"]').show();                        	
	                	
	                	if($locations.length>0){
	               			$('html, body').animate({scrollTop: $locations.offset().top},500);                	
	               		}

	                }).trigger('change');

	                $('.state .cities').selectize();
	                
                } else {
                	$('.dynamic-locaion-content .list').html($state);
                }                           

                am2_hide_preloader();
            });
         });

         $(document).on('click', '.state .franchise a', function(e){
            $('.state .franchise a').removeClass('selected');
            $(this).addClass('selected');
            $(this).siblings('.franchise_details').slideToggle();                	
        });     

        if(ajax_login_object.aa_state != "" && $('#map_base').length>0){
            console.log('aa_state set');
            $('#map_base').find('text:contains("'+ajax_login_object.aa_state.toUpperCase()+'")').trigger('click');
        } 
        else if( $('#map_base').length>0 ) {
            console.log('please select state on the map');
            $('.dynamic-locaion-content .list .state').html('Please choose a state on the map');
        }

    });    

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };
    
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
    function delete_digital_artwork(attach_id, user_id){
       jQuery.ajax({
            url:ajax_login_object.ajaxurl,
            type:'POST',
            data:'action=ajax_delete_field&attachid=' + attach_id + '&user_id=' + user_id,
            success:function(results)
            {                     
                jQuery('input[name="digital_file_name"]').val('');

                jQuery('#btn_delete_user_photo').fadeOut(400, function(){ 
                    jQuery(this).parent().empty().append('<div id="digital_image_upload" style="display:none;">Upload</div>'); 
                    jQuery('#digital_image_upload').fadeIn(); 
                    loadDigitalArtwork();
                });
            }
        });
    }

    function loadDigitalArtwork(){
        console.log('loadDigitalArtwork');
        if(typeof uploadOptions === 'undefined') return;
        console.log('loadDigitalArtwork continued');
        
        uploadOptions['request']['params']['field'] = 'user_photo';
        jQuery('#digital_image_upload').fineUploader(uploadOptions).on('complete', function(event, id, fileName, responseJSON) {
           if (responseJSON.success) {
             jQuery(this).parent().delay(1000).fadeOut(400, function(){
                  jQuery(this).empty().append('<div class="upload_success"><img src="'+responseJSON.file_url+'" width="175"/></div>').append("<a class='delete_button button' id='btn_delete_user_photo' data-attid="+responseJSON.file_id+" >Delete file</a>").fadeIn();
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
        $('#preloader_overlay').show();
    }

    function am2_hide_preloader(){
        $('#preloader_overlay').hide();
    }

    function getVideoId(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);

        if (match && match[2].length == 11) {
            return match[2];
        } else {
            return 'error';
        }
    }


    
})(jQuery);

function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}
