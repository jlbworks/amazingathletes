(function($){
	
	var xhr;
	var select_state, $select_state;
	var select_city, $select_city;
	var val_city ;
	
	function initialize_field( $el ) {
		
		//$el.doStuff();

		//console.log($el.find('cc_state') , $el.find('cc_city'));

		$select_state = $el.find('.cc_state').selectize({
			onChange: function(value) {
		        loadCities(value);
		    }
		});

		$select_city = $el.find('input.cc_city').selectize({		 	
		    valueField: 'name',
		    labelField: 'name',
		    searchField: ['name'],
		    maxItems:1/*,
			create:function (input){
               return { name:input, zip:-1};
           }	*/
		 });

		select_city  = $select_city[0].selectize;
		select_state = $select_state[0].selectize;

		if($select_state.val() == '') select_city.disable();
		else {
			val_city = $select_city.val();
			loadCities($select_state.val());			
		}

		$el.find('.cc_state').on('change', function(){
			console.log('cc_state change');
			$el.find('.cc_city_state').val($el.find('.cc_state').val() + '|' +  $el.find('.cc_city').val() );
		});
		$el.find('.cc_city').on('change', function(){
			console.log('cc_state change');
			$el.find('.cc_city_state').val($el.find('.cc_state').val() + '|' +  $el.find('.cc_city').val() );
		});
	}

	function loadCities(value){
		if (!value.length) return;
        select_city.disable();
        select_city.clearOptions();
        select_city.load(function(callback) {
            xhr && xhr.abort();
            xhr = $.ajax({
                url: am2_acf_admin_ajax_url,
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
	
	
	if( typeof acf.add_action !== 'undefined' ) {
	
		/*
		*  ready append (ACF5)
		*
		*  These are 2 events which are fired during the page load
		*  ready = on page load similar to $(document).ready()
		*  append = on new DOM elements appended via repeater field
		*
		*  @type	event
		*  @date	20/07/13
		*
		*  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
		*  @return	n/a
		*/
		
		acf.add_action('ready append', function( $el ){
			
			// search $el for fields of type 'city-state'
			acf.get_fields({ type : 'city-state'}, $el).each(function(){
				
				initialize_field( $(this) );
				
			});
			
		});
		
		
	} else {
		
		
		/*
		*  acf/setup_fields (ACF4)
		*
		*  This event is triggered when ACF adds any new elements to the DOM. 
		*
		*  @type	function
		*  @since	1.0.0
		*  @date	01/01/12
		*
		*  @param	event		e: an event object. This can be ignored
		*  @param	Element		postbox: An element which contains the new HTML
		*
		*  @return	n/a
		*/
		
		$(document).on('acf/setup_fields', function(e, postbox){

			
			$(postbox).find('.field[data-field_type="city-state"]').each(function(){
				
				initialize_field( $(this) );
				
			});
		
		});
	
	
	}


})(jQuery);
