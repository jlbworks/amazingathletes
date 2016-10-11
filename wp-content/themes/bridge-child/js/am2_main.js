var remodal_popup;
var class_costs = {
    "Standard Registration Form" : "parent_pay_monthly",
    "Session Registration Form" : "parent_pay_session",
    "3rd Party Registrations" : "contracts_events"
};
/*var class_costs = {
    "Parent-Pay" : "parent_pay_monthly",
    "Session" : "parent_pay_session",
    "Contracts/Events" : "contracts_events"
};*/
var classes_with_special_title = ['Contract','Camp']; 

(function($){
    $(document).ready(function(){

        var xhr;
        var select_state, $select_state;
        var select_city, $select_city;
        var val_city ;
        var ajax_talking = false;
        var loc_state = null;
        var state_name = "";

        //loadDigitalArtwork();

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

        $('.sidebar-link').on('mouseover',function(e){
            var $img = $(this).find('img');                     
            $img.attr('src', $img.data('mouseover'));
        });

        $('.sidebar-link:not(.current)').on('mouseout',function(e){
            var $img = $(this).find('img');                        
            $img.attr('src', $img.data('mouseout'));
        });

        $('.sidebar-link.current img').each(function(){
           $(this).attr('src', $(this).data('mouseover'));
        });

        $('.sidebar-link.current').closest('.side-nav').find('.side-nav.sub').show();

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
            if(typeof(tinyMCE)!='undefined')
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
            if(typeof (resp.post_id) != 'undefined' && resp.post_id != 0) {
                window.location.href = updateQueryStringParameter(window.location.href, 'post_id', resp.post_id );
            }
          },
          error: function() {
            am2_hide_preloader();
          }
        });

        $('#frm_add_mypage').ajaxForm({
          beforeSubmit: function() {
            am2_show_preloader();
            return true; //$('#frm_edit_mypage').valid();
          },
          success: function(resp) {
            am2_hide_preloader();
            alert(resp.status);
            if(typeof (resp.mypage_slug) != 'undefined') {
                window.location.href = updateQueryStringParameter(window.location.href, 'page', resp.mypage_slug );
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


        $('[data-button="delete"]').click(function(e) {
            var delete_button = this;
            e.preventDefault();
            if (confirm('Are you sure?')) {
                $(delete_button).closest('[data-form="frm_delete_location"]').ajaxSubmit({
                  beforeSubmit: function() {
                    am2_show_preloader();
                    return $(delete_button).closest('[data-form="frm_delete_location"]').valid();
                  },
                  success: function(resp) {
                    am2_hide_preloader();
                    alert(resp.message);
                    location.href = permalink + '?deleted=true';
                  },
                  error: function() {
                    am2_hide_preloader();
                  }
                });
            }
        });



        /*$(document).on('click','#btn_delete_user_photo', function(e){
            e.preventDefault();
            delete_digital_artwork($(this).data('attid'), $(this).data('user-id'));
        });*/

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

            $.post(ajax_login_object.ajaxurl, {
                action    : 'am2_add_coach',
                first_name: $('#first_name').val(),
                last_name : $('#last_name').val(),
                coach_email: $('#coach_email').val(),
                loc_id: $('[name="looc_id"]').val()
            }, function(resp) {
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

        $('#frm_edit_staff').validate({ /* ... */ });
        $('#frm_edit_staff').ajaxForm({
          beforeSubmit: function() {
            am2_show_preloader();
            return $('#frm_edit_staff').valid();
          },
          success: function(resp) {
            am2_hide_preloader();
            alert(resp.message);
            location.href = permalink + '?user_id=' + resp.user_id;
          },
          error: function() {
            am2_hide_preloader();
          }
        });

         /*$('#frm_edit_staff').on('submit', function(e){
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
         });*/

        if($('.dynamic-locaion-content').length > 0){
            $('.dynamic-locaion-content').html(
                '<form id="frmFilterMap">' +
                    '<input type="text" name="franchise_name" id="txtFranchiseName" placeholder="franchise name" />'+
                    '<input type="text" name="zip_code" id="txtZipCode" placeholder="enter zip code" />'+
                    '<input type="hidden" name="am2_state" id="hidState" />'+
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
                    console.log(resp);

                    $.each(ajax_login_object.states, function(k,v){
                        if(v.state_code == loc_state){
                            state_name = v.state;
                        }
                });

                var $state = $('<div class="state"></div>');

                if(loc_state){
                    $state.append('<h1 class="state_title" style="text-align: center;"><div class="td"><img src="'+ajax_login_object.theme_url+'/img/states/'+ loc_state +'.png" /></div><span class="td">'+state_name+'</span></h1>')
                }
                

                if(Object.keys(resp).length>0){
                	var $ul = $('<select class="cities"></select>');

                    var i=0;
	                $.each(resp, function(k,v){                        
	                    var $li = $('<option value="'+k+'" data-id="'+ k +'" '+(i++==0?'selected':'')+'></option>');
	                    $li.append(k);

	                    $ul.append($li);
	                });

	                $state.append($ul);

	                $state.append('<span class="h1">'+state_name+' Providers</span>');

                    var $ul_child = $('<ul class="locations state" ></ul>');
                    $state.append($ul_child);
                    $('.dynamic-locaion-content .list').html($state);

                    $ul_child = $('ul.locations');

	                $.each(resp, function(k,v){
	                	
	                	// var $ul_child = $('<ul class="locations" data-id="'+ k +'"></ul>');

		                $.each(v, function(k2,v2){
                            var $franchise = $('#franchise_'+v2.meta_franchisee.franchise_slug);

                            console.log('#franchise_'+v2.meta_franchisee.franchise_slug, $franchise.length, v2.meta_franchisee.franchise_photo);

                            if($franchise.length>0){                                
                                var $li_child = $franchise;
                                if($li_child.find('.franchise_cities').find('.franchise_city:contains("'+k+'")').length<1){
                                    $li_child.find('.franchise_cities').append('<span class="franchise_city"><a data-fancybox-type=""  href="'+ajax_login_object.site_url+'/'+v2.meta_franchisee.franchise_slug+'/locations/?city='+k+'">'+ k +'</a></span>');
                                }                                                                
                            }
                            else {
                                console.log('f0',v2.meta_franchisee.franchise_photo);
                                var $li_child = $('<li class="franchise" id="franchise_'+v2.meta_franchisee.franchise_slug+'"></li>');
                                $li_child.append(
                                    '<div class="franchise_left">'+
                                        (v2.meta_franchisee.franchise_photo ? 
                                        '<img src="' + v2.meta_franchisee.franchise_photo + '"/>' :
                                        '<img src="' + ajax_login_object.theme_url  + '/images/no-image.jpg"/>' )                                        
                                        +
                                    '</div>'+
                                    '<div class="franchise_right">' +
                                        '<h3 class="franchise_name"><a href="'+ ajax_login_object.site_url + '/' + v2.meta_franchisee.franchise_slug+'">' + v2.meta_franchisee.franchise_name + '</a></h3>' +
                                        '<span class="franchise_owner">' + v2.meta_franchisee.franchisee + ', Owner</span><br/>'+
                                        '<span class="franchise_tel">' + v2.meta_franchisee.franchise_phone + '</span><br/>' +
                                        '<a href="mailto:' + v2.meta_franchisee.franchise_email + '" class="franchise_email">' + v2.meta_franchisee.franchise_email + '</a><br/>' +  
                                        //'<a href="'+ajax_login_object.site_url+'/choose-class/?location_id='+v2.id+'" class="h1 franchise_register">Register Now</a><br/>' +
                                        '<div class="franchise_cities"></div>'+                                                                                
                                    '</div>'
                                );   
                                $li_child.find('.franchise_cities').append('<span class="franchise_city"><a data-fancybox-type="" href="'+ajax_login_object.site_url+'/'+v2.meta_franchisee.franchise_slug+'/locations/?city='+k+'">'+ k +'</a></span>');
                                $ul_child.append($li_child);           
                            }                            
                                                                     

		                	
		                	/*$li_child.append('<a>'+v2.meta.post_title + ' - ' + v2.meta.address + '</a>');
		                	$li_child.append(
		                	'<div class="franchise_details">' +
			                	'<span class="franchise_address">' + v2.meta.address + ' - ' + k + ' - ' + loc_state + " " + v2.meta.zip + '</span><br/>' +
			                	'<a href="'+ajax_login_object.site_url+'/choose-class/?location_id='+v2.id+'" class="h1 franchise_register">Register Now</a><br/>' +
			                	'<span class="franchise_name"><a href="'+ ajax_login_object.site_url + '/' + v2.meta_franchisee.franchise_slug+'">' + v2.meta_franchisee.franchise_name + '</a></span><br/>' +
			                	'<span class="franchise_footer">' + v2.meta.director + ' | ' + v2.meta.telephone + '</span><br/>' +
		                	'</div>'
		                	);*/

		                   
		                });
		                
		            });
                    

	                

                    /*var options = $('select.cities option');
                    var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
                    arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
                    options.each(function(i, o) {
                      o.value = arr[i].v;
                      $(o).text(arr[i].t);
                    });*/

                    //$('select.cities').html(options);

	                $('html, body').animate({scrollTop: $('.dynamic-locaion-content').eq(0).offset().top},500);

	                $('.state .cities').off('change').on('change', function(e){
                        var that = this;
                        $('.franchise').hide();
                        $('.franchise_city').filter(function() {return $(this).text() == $(that).val()}).closest('.franchise').show();                             

	                	//$('.state .cities li').removeClass('selected');
	                	//$(this).addClass('selected');
	                	// var data_id = $(this).val();// $(this).find('[value="'+$(this).val()+'"]').data('id');
	                	// var $locations = $('.state .locations[data-id="'+data_id+'"]').eq(0);

	                	// console.log($(this).val());

	                	// //$('.state .locations').hide();
	                	// $('.state .locations[data-id="'+data_id+'"]').show();

	                	// if($locations.length>0){
	               		// 	$('html, body').animate({scrollTop: $locations.offset().top},500);
	               		// }

	                }).trigger('change');

	                $('.state .cities').selectize();

                    $('a[data-fancybox-type="iframe"]').fancybox();

                } else {
                	$('.dynamic-locaion-content .list').html((state_name ? 'There are no locations for your query in '+ state_name : 'No locations in this area' ));
                }

                am2_hide_preloader();
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

                $state.append('<h1 class="state_title" style="text-align: center;"><div class="td"><img src="'+ajax_login_object.theme_url+'/img/states/'+ loc_state +'.png" /></div><span class="td">'+state_name+'</span></h1>')
                

                if(Object.keys(resp).length>0){
                	var $ul = $('<select class="cities"></select>');

                    var i=0;
	                $.each(resp, function(k,v){                        
	                    var $li = $('<option value="'+k+'" data-id="'+ k +'" '+(i++==0?'selected':'')+'></option>');
	                    $li.append(k);

	                    $ul.append($li);
	                });

	                $state.append($ul);

	                $state.append('<span class="h1">'+state_name+' Providers</span>');

                    var $ul_child = $('<ul class="locations state" ></ul>');
                    $state.append($ul_child);
                    $('.dynamic-locaion-content .list').html($state);

                    $ul_child = $('ul.locations');

	                $.each(resp, function(k,v){
	                	
	                	// var $ul_child = $('<ul class="locations" data-id="'+ k +'"></ul>');

		                $.each(v, function(k2,v2){
                            var $franchise = $('#franchise_'+v2.meta_franchisee.franchise_slug);

                            console.log('#franchise_'+v2.meta_franchisee.franchise_slug, $franchise.length, v2.meta_franchisee.franchise_photo);

                            if($franchise.length>0){                                
                                var $li_child = $franchise;
                                if($li_child.find('.franchise_cities').find('.franchise_city:contains("'+k+'")').length<1){
                                    $li_child.find('.franchise_cities').append('<span class="franchise_city"><a data-fancybox-type=""  href="'+ajax_login_object.site_url+'/'+v2.meta_franchisee.franchise_slug+'/locations/?city='+k+'">'+ k +'</a></span>');
                                }                                                                
                            }
                            else {
                                console.log('f0',v2.meta_franchisee.franchise_photo);
                                var $li_child = $('<li class="franchise" id="franchise_'+v2.meta_franchisee.franchise_slug+'"></li>');
                                $li_child.append(
                                    '<div class="franchise_left">'+
                                        (v2.meta_franchisee.franchise_photo ? 
                                        '<img src="' + v2.meta_franchisee.franchise_photo + '"/>' :
                                        '<img src="' + ajax_login_object.theme_url  + '/images/no-image.jpg"/>' )                                        
                                        +
                                    '</div>'+
                                    '<div class="franchise_right">' +
                                        '<h3 class="franchise_name"><a href="'+ ajax_login_object.site_url + '/' + v2.meta_franchisee.franchise_slug+'">' + v2.meta_franchisee.franchise_name + '</a></h3>' +
                                        '<span class="franchise_owner">' + v2.meta_franchisee.franchisee + ', Owner</span><br/>'+
                                        '<span class="franchise_tel">' + v2.meta_franchisee.franchise_phone + '</span><br/>' +
                                        '<a href="mailto:' + v2.meta_franchisee.franchise_email + '" class="franchise_email">' + v2.meta_franchisee.franchise_email + '</a><br/>' +  
                                        //'<a href="'+ajax_login_object.site_url+'/choose-class/?location_id='+v2.id+'" class="h1 franchise_register">Register Now</a><br/>' +
                                        '<div class="franchise_cities"></div>'+                                                                                
                                    '</div>'
                                );   
                                $li_child.find('.franchise_cities').append('<span class="franchise_city"><a data-fancybox-type="" href="'+ajax_login_object.site_url+'/'+v2.meta_franchisee.franchise_slug+'/locations/?city='+k+'">'+ k +'</a></span>');
                                $ul_child.append($li_child);           
                            }                            
                                                                     

		                	
		                	/*$li_child.append('<a>'+v2.meta.post_title + ' - ' + v2.meta.address + '</a>');
		                	$li_child.append(
		                	'<div class="franchise_details">' +
			                	'<span class="franchise_address">' + v2.meta.address + ' - ' + k + ' - ' + loc_state + " " + v2.meta.zip + '</span><br/>' +
			                	'<a href="'+ajax_login_object.site_url+'/choose-class/?location_id='+v2.id+'" class="h1 franchise_register">Register Now</a><br/>' +
			                	'<span class="franchise_name"><a href="'+ ajax_login_object.site_url + '/' + v2.meta_franchisee.franchise_slug+'">' + v2.meta_franchisee.franchise_name + '</a></span><br/>' +
			                	'<span class="franchise_footer">' + v2.meta.director + ' | ' + v2.meta.telephone + '</span><br/>' +
		                	'</div>'
		                	);*/

		                   
		                });
		                
		            });
                    

	                

                    /*var options = $('select.cities option');
                    var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
                    arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
                    options.each(function(i, o) {
                      o.value = arr[i].v;
                      $(o).text(arr[i].t);
                    });*/

                    //$('select.cities').html(options);

	                $('html, body').animate({scrollTop: $('.dynamic-locaion-content').eq(0).offset().top},500);

	                $('.state .cities').off('change').on('change', function(e){
                        var that = this;
                        $('.franchise').hide();
                        $('.franchise_city').filter(function() {return $(this).text() == $(that).val()}).closest('.franchise').show();                             

	                	//$('.state .cities li').removeClass('selected');
	                	//$(this).addClass('selected');
	                	// var data_id = $(this).val();// $(this).find('[value="'+$(this).val()+'"]').data('id');
	                	// var $locations = $('.state .locations[data-id="'+data_id+'"]').eq(0);

	                	// console.log($(this).val());

	                	// //$('.state .locations').hide();
	                	// $('.state .locations[data-id="'+data_id+'"]').show();

	                	// if($locations.length>0){
	               		// 	$('html, body').animate({scrollTop: $locations.offset().top},500);
	               		// }

	                }).trigger('change');

	                $('.state .cities').selectize();

                    $('a[data-fancybox-type="iframe"]').fancybox();

                } else {
                	$('.dynamic-locaion-content .list').html($state);
                }

                am2_hide_preloader();
            });
         });

         $('.js-induce-change-select-class').on('change',function(e){          
             console.log($.inArray($(this).val(), classes_with_special_title)==-1);   
             $('[name="special_event_title"]').closest('div.special_event_title_wrap').toggleClass('hidden', $.inArray($(this).val(), classes_with_special_title)==-1);
         });

         $(document).on('click', '.state .franchise > a, .state .franchise > h3', function(e){
            $('.state .franchise > a, .state .franchise > h3').removeClass('selected');
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
    /*function delete_digital_artwork(attach_id, user_id){
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
    }*/

    /*function loadDigitalArtwork(){
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
    }   */

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

    $('#franchisee_email').val($('#hid_franchisee_email').val());

    $(document).on('change','[data-remodal-id="popup"] .content .payment_options', function(){
        $('.payment_details > div').hide();
        $('.payment_details > .'+$(this).val()).show();
    });

    $('#frm_registration').validate();

    $('#frm_registration').on('submit', function(e){
        e.preventDefault();
        if($('#frm_registration').valid()){
            $('#frm_registration').ajaxSubmit({
                beforeSubmit: function() {
                    console.log('before_submit');
                    am2_show_preloader();                    
                },
                success: function(resp) {
                    console.log('success_submit');
                    am2_hide_preloader();
                    show_payment_options(resp.paid_tuition);           
                },
                error: function() {
                    console.log('error');
                    am2_hide_preloader();
                }
            });
        }        
    });

    $('.tabs li').on('click', function(){
        var id = $(this).attr('id').replace('tab_','');        
        $('.tab_content').hide();
        $('.tab_content_' + id).show();        
    });

    $('.tabs li:first-child').click();

    $('.accord').on('click', function(){
        var id = $(this).attr('id').replace('accord_','');        
        $('.accord_content').hide();
        $('.accord_content_' + id).show();        
    });

    function show_payment_options(paid_tuition){           

        $.get(ajax_login_object.theme_url + '/includes/modals/payment-options.html', function(resp_payopt){
            $('head').append(resp_payopt);
            $.get(ajax_login_object.theme_url + '/includes/modals/popup.html', function(resp_popupmodal){
                var template = wp.template( 'payment-options' );            

                $('body').append(resp_popupmodal);            
                
                var class_id = getParameterByName('class_id');
                var loc_id = getParameterByName('location_id');

                var d1 = $.Deferred();
                var d2 = $.Deferred();

                var resp_class;
                var resp_author;
                
                $.post(ajax_login_object.ajaxurl, { action: 'am2_ajax_get_postmeta', post_id: class_id }, function(resp){
                    resp_class=resp;
                    d1.resolve();                                                       
                }); 

                $.post(ajax_login_object.ajaxurl, { action: 'am2_ajax_get_authormeta', post_id: loc_id }, function(resp){
                    resp_author=resp;                
                    d2.resolve();
                });

                $.when( d1, d2 ).done(function(){                

                    var payment_type = class_costs[resp_class.meta.registration_option];    
                    var registration_fee = !paid_tuition ? parseInt(resp_class.meta[payment_type + '_registration_fee']) : 0;
                    var monthly_tuition = 0;
                    var session_tuition = 0;
                    try {
                        monthly_tuition = parseInt(resp_class.meta[payment_type + '_monthly_tuition']);                
                        session_tuition = parseInt(resp_class.meta[payment_type + '_session_tuition']);
                    }   
                    catch(exc){
                        console.log(exc, monthly_tuition, session_tuition); 
                    }                   
                    
                    var tuition = ((monthly_tuition) ? monthly_tuition : ((session_tuition) ? session_tuition : 0));           
                    var franchise_name = resp_author.meta.franchise_name;    
                    var individual_1_first_name = resp_author.meta.individual_1_first_name;            
                    var individual_1_last_name = resp_author.meta.individual_1_last_name;  
                    var contact_number = resp_author.meta.telephone;
                    var contact_email = resp_author.meta.aa_email_address;
                    var one_time_payment_url = resp_class.meta.one_time_credit_card_payment_url;
                    var recurring_credit_card_payments_url = resp_class.meta.recurring_credit_card_payments_url;

                    $('[data-remodal-id="popup"] .content').html( template( {
                        amount_due : registration_fee + tuition,
                        franchise_name : franchise_name,
                        contact_name : individual_1_first_name + ' ' + individual_1_last_name,
                        contact_number : contact_number,
                        contact_email : contact_email,
                        registration_fee : registration_fee,
                        tuition : tuition,
                        payment_link_onetime : one_time_payment_url,
                        payment_link_auto : recurring_credit_card_payments_url
                    } ) ) ;
                    
                    remodal_popup = $('[data-remodal-id=popup]').remodal();
                    remodal_popup.open();
                });             
            }); 
        });        
    }

    $('input[name="child-birthday"]').datetimepicker({
        timepicker: false,
        format:'m-d-Y'
    });
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

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

