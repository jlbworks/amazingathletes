var current_domain = window.location.host;
console.log(am2.current_domain);
var SITEURL = am2.current_domain;

var preloaderTpl = '<div class="progress progress-striped light active m-md"><img src="http://ibd-reg.com/wp-content/themes/stranica/images/heart.gif" alt="" /></div>';

var current_screen = '';

function am2_notify(json){
	if( json.type=='info' ){
		var notice_type='info';
		var notice_title = 'Info';
	}else if( json.success==true ){
		var notice_type='success';
		var notice_title = 'OK';
	}else{
		var notice_type='error';
		var notice_title = 'Greška';
	}
	
	if( typeof(json.title)!=="undefined" ){
		var notice_title = json.title;
	}
        
        if( typeof(json.title)!=="undefined" ){
		var delay = json.delay;
	}else{
            var delay = 3000;
        }
	
	if( typeof(json.message)=="undefined" ){
		var notice_text = "";
	}else{
		var notice_text = json.message;
	}
	
	var notice = new PNotify({
		title: notice_title,
		text: notice_text,
		type: notice_type,
		addclass: 'stack-topleft',
		delay: delay
	});
}

function split_hash(hash){
	var parts = hash.split('/');
	var page = parts[0];
	if( page.substring(0,1)=='#'){
		page = page.substring(1);
	}
	var args = parts[1];
	console.log(args);
	return {'page':page,'args':args};
}

function load_screen(hash){
	if( hash=='REFRESH' ){
		var url = current_screen;
	}else{
		var url = split_hash(hash);
	}
	
	current_screen = url;
	
	$('.page-header h2').fadeOut(400);
	/*
	$('#content-inner').fadeOut(400, function() {
		$('#preloader_page_change').show();
	});
	*/
	$.ajax({
		url: SITEURL+'/wp-admin/admin-ajax.php',
		//url: SITEURL+'/ajax-endpoint.php',
		type: 'POST',
		data: {
			action: 'account_screen_change',
			target_page: url.page,
			target_args: url.args
		},
		beforeSend: function(){
			$('#content-inner').empty().append(preloaderTpl);
		},
		error: function() {

		},
		success: function(html) {
			//$('#preloader_page_change').hide();
			$('#content-inner').show();
			//$('#content-inner').fadeIn(300);
			$('#content-inner').empty().append(html).fadeIn();
			if( typeof(html.success) !== "undefined" ){
				am2_notify(html);
			}
			$('.remodal-wrapper').remove();
		}
	});

		var ph=window.location.hash;
		console.log("ph::"+ph);
		$( ".nav-main li a" ).each(function(index,el){
			var atr = $(el).attr("href");
			if( typeof(atr)!=="undefined" || typeof(ph)!=="undefined" ){	
				if( atr && atr==ph ){
					//console.log(index+ atr+' !!! '+ph);
					$(el).parent("li").addClass('nav-active');
				}else{
					$(el).parent("li").removeClass("nav-active");
				}
			}
		});
}


function add_note_to_bolnica(bolnica_id,note){
	$.ajax({
		url: SITEURL+'/wp-admin/admin-ajax.php',
		type: 'POST',
		data: {
			action: 'submit_data',
			form_handler: 'add-note-to-bolnica',
			bolnica_id: bolnica_id,
			note: note
		},
		success: function(json) {
			//$('#modal-content-inner').empty().append(html).fadeIn();
		}
	});

}


function show_client_notes(bolnica_id){
	$.ajax({
		url: SITEURL+'/wp-admin/admin-ajax.php',
		type: 'POST',
		data: {
			action: 'submit_data',
			form_handler: 'show_client_notes',
			bolnica_id: bolnica_id,
		},
		success: function(html) {
			$('.client-notes-'+bolnica_id).html(html);
		}
	});
}

function show_more_client_notes(btn){
	var bolnica_id = $(btn).data('bolnica-id');
	if( $.isFunction( $(btn).isLoading ) ){
		$(btn).isLoading();
	}
	$.ajax({
		url: SITEURL+'/wp-admin/admin-ajax.php',
		type: 'POST',
		data: {
			action: 'submit_data',
			form_handler: 'show_more_client_notes',
			bolnica_id: bolnica_id,
		},
		success: function(html) {
			$('.client-notes-'+bolnica_id).html(html);
		}
	});
}

function delete_client_note(btn){
	var bolnica_id = $(btn).data('bolnica-id');
	var timestamp = $(btn).data('timestamp');
	$.ajax({
		url: SITEURL+'/wp-admin/admin-ajax.php',
		type: 'POST',
		data: {
			action: 'delete_object',
			object: 'client_note',
			bolnica_id: bolnica_id,
			timestamp: timestamp
		},
		success: function(html) {
			// remove from dom or refresh all
			show_client_notes(bolnica_id);
		}
	});
}

function empty_form(form) {
	$(form).find('input:visible,textarea').val('');
	$(form).find('select').select2('val','');
	$(form).find('textarea').text('');
}

function set_title(title){
	$('.page-header h2').empty().append(title).fadeIn();
}

function am2_show_preloader(elem){
    if(elem) {
        $(elem).find('.preloader_overlay').show();
    }
    else {
		$('.preloader_overlay').show();
	}
}

function am2_hide_preloader(elem){
	if(elem) {
		$(elem).find('.preloader_overlay').hide();
	}
	else {
		$('.preloader_overlay').hide();
	}
}

$( window ).load(function(){

	if( window.location.hash == "" ){
		// set home page here
		// window.location.hash = "#dashboard";
		// load_screen('dashboard');
		
	}else{
		var hash = window.location.hash;
		load_screen(hash);
	}

	$(window).on('hashchange', function() {
		var hash = window.location.hash;
		load_screen(hash);
	});
    
});