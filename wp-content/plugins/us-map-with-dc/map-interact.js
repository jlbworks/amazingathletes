﻿// Quick feature detection
function isTouchEnabled() {
 	return (('ontouchstart' in window)
      	|| (navigator.MaxTouchPoints > 0)
      	|| (navigator.msMaxTouchPoints > 0));
}
jQuery(function(){
			addEvent('state_1');
			addEvent('state_2');
			addEvent('state_3');
			addEvent('state_4');
			addEvent('state_5');
			addEvent('state_6');
			addEvent('state_7');
			addEvent('state_8');
			addEvent('state_9');
			addEvent('state_10');
			addEvent('state_11');
			addEvent('state_12');
			addEvent('state_13');
			addEvent('state_14');
			addEvent('state_15');
			addEvent('state_16');
			addEvent('state_17');
			addEvent('state_18');
			addEvent('state_19');
			addEvent('state_20');
			addEvent('state_21');
			addEvent('state_22');
			addEvent('state_23');
			addEvent('state_24');
			addEvent('state_25');
			addEvent('state_26');
			addEvent('state_27');
			addEvent('state_28');
			addEvent('state_29');
			addEvent('state_30');
			addEvent('state_31');
			addEvent('state_32');
			addEvent('state_33');
			addEvent('state_34');
			addEvent('state_35');
			addEvent('state_36');
			addEvent('state_37');
			addEvent('state_38');
			addEvent('state_39');
			addEvent('state_40');
			addEvent('state_41');
			addEvent('state_42');
			addEvent('state_43');
			addEvent('state_44');
			addEvent('state_45');
			addEvent('state_46');
			addEvent('state_47');
			addEvent('state_48');
			addEvent('state_49');
			addEvent('state_50');
			addEvent('state_51');
})
jQuery(function(){
	if(jQuery('#lakes').find('path').eq(0).attr('fill') != 'undefined'){
		jQuery('#lakes').find('path').attr({'fill':states_config['default']['lakescolor']}).css({'stroke':states_config['default']['bordercolor']});
	}
	jQuery('.map-tip').css({
		'box-shadow':'1px 2px 4px '+states_config['default']['namesShadowColor'],
		'-moz-box-shadow':'2px 3px 6px '+states_config['default']['namesShadowColor'],
		'-webkit-box-shadow':'2px 3px 6px '+states_config['default']['namesShadowColor'],
	});
	if(jQuery('#shadow').find('path').eq(0).attr('fill') != 'undefined'){
		var shadowOpacity = states_config['default']['shadowOpacity'];
		var shadowOpacity = parseInt(shadowOpacity);
		if (shadowOpacity >=100){shadowOpacity = 1;}else if(shadowOpacity <=0){shadowOpacity =0;}else{shadowOpacity = shadowOpacity/100;}
		
		jQuery('#shadow').find('path').attr({'fill':states_config['default']['shadowcolor']}).css({'fill-opacity':shadowOpacity})
	}
});

function addEvent(id,relationId){
	var _obj = jQuery('#'+id);
	var _Textobj = jQuery('#'+id+','+'#'+states_config[id]['namesId']);
	var _h = jQuery('#map').height();

	jQuery('#'+['text-abb']).attr({'fill':states_config['default']['namescolor']});

		_obj.attr({'fill':states_config[id]['upcolor'],'stroke':states_config['default']['bordercolor']});
		_Textobj.attr({'cursor':'default'});
		if(states_config[id]['enable'] == true){
			if (isTouchEnabled()) {
				_Textobj.on('touchstart', function(e){
					var touch = e.originalEvent.touches[0];
					var x=touch.pageX-10, y=touch.pageY+(-15);
					var maptipw=jQuery('#map-tip').outerWidth(), maptiph=jQuery('#map-tip').outerHeight(), 
					x=(x+maptipw>jQuery(document).scrollLeft()+jQuery(window).width())? x-maptipw-(20*2) : x
					y=(y+maptiph>jQuery(document).scrollTop()+jQuery(window).height())? jQuery(document).scrollTop()+jQuery(window).height()-maptiph-10 : y
					if(states_config[id]['target'] != 'none'){
						jQuery('#'+id).css({'fill':states_config[id]['downcolor']});
					}
					jQuery('#map-tip').show().html(states_config[id]['hover']);
					jQuery('#map-tip').css({left:x, top:y})
				})
				_Textobj.on('touchend', function(){
					jQuery('#'+id).css({'fill':states_config[id]['upcolor']});
					if(states_config[id]['target'] == '_blank'){
						window.open(states_config[id]['url']);	
					}else if(states_config[id]['target'] == '_self'){
						window.parent.location.href=states_config[id]['url'];
					}
					jQuery('#map-tip').hide();
				})
			}
			_Textobj.attr({'cursor':'pointer'});
			_Textobj.hover(function(){
				//moving in/out effect
				jQuery('#map-tip').show().html(states_config[id]['hover']);
				_obj.css({'fill':states_config[id]['overcolor']})
			},function(){
				jQuery('#map-tip').hide();
				jQuery('#'+id).css({'fill':states_config[id]['upcolor']});
			})
			if(states_config[id]['target'] != 'none'){
				//clicking effect
				_Textobj.mousedown(function(){
					jQuery('#'+id).css({'fill':states_config[id]['downcolor']});
				})
			}
			_Textobj.mouseup(function(){
				jQuery('#'+id).css({'fill':states_config[id]['overcolor']});
				if(states_config[id]['target'] == '_blank'){
					window.open(states_config[id]['url']);	
				}else if(states_config[id]['target'] == '_self'){
					window.parent.location.href=states_config[id]['url'];
				}
			})
			_Textobj.mousemove(function(e){
				var x=e.pageX+10, y=e.pageY+15;
				var maptipw=jQuery('#map-tip').outerWidth(), maptiph=jQuery('#map-tip').outerHeight(), 
				x=(x+maptipw>jQuery(document).scrollLeft()+jQuery(window).width())? x-maptipw-(20*2) : x
				y=(y+maptiph>jQuery(document).scrollTop()+jQuery(window).height())? jQuery(document).scrollTop()+jQuery(window).height()-maptiph-10 : y
				jQuery('#map-tip').css({left:x, top:y})
			})
		}	
}