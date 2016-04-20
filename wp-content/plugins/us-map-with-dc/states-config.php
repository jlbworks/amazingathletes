﻿<?php 
$wp_map = $this->options; ?>
var states_config = {
	'default':{
		'bordercolor':'<?php echo $wp_map['border_color']; ?>',
		'lakescolor':'<?php echo $wp_map['lake_color']; ?>',
		'shadowcolor':'<?php echo $wp_map['shadow_color']; ?>',
		'shadowOpacity':'<?php echo $wp_map['shadow_opacity']; ?>',
		'namescolor':'<?php echo $wp_map['short_names']; ?>',
		'namesShadowColor':'<?php echo $wp_map['hover_shadow']; ?>',
	},
	'state_1':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_1']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_1']) : stripslashes($wp_map['hover_content_1'])); ?>',
		'url':'<?php echo $wp_map['url_1']; ?>',
		'target':'<?php echo $wp_map['open_url_1']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_1']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_1']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_1']; ?>',
		'enable':<?php echo $wp_map['enable_region_1']=='1'?'true':'false'; ?>,
	},
	'state_2':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_2']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_2']) : stripslashes($wp_map['hover_content_2'])); ?>',
		'url':'<?php echo $wp_map['url_2']; ?>',
		'target':'<?php echo $wp_map['open_url_2']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_2']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_2']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_2']; ?>',
		'enable':<?php echo $wp_map['enable_region_2']=='1'?'true':'false'; ?>,
	},
	'state_3':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_3']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_3']) : stripslashes($wp_map['hover_content_3'])); ?>',
		'url':'<?php echo $wp_map['url_3']; ?>',
		'target':'<?php echo $wp_map['open_url_3']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_3']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_3']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_3']; ?>',
		'enable':<?php echo $wp_map['enable_region_3']=='1'?'true':'false'; ?>,
	},
	'state_4':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_4']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_4']) : stripslashes($wp_map['hover_content_4'])); ?>',
		'url':'<?php echo $wp_map['url_4']; ?>',
		'target':'<?php echo $wp_map['open_url_4']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_4']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_4']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_4']; ?>',
		'enable':<?php echo $wp_map['enable_region_4']=='1'?'true':'false'; ?>,
	},
	'state_5':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_5']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_5']) : stripslashes($wp_map['hover_content_5'])); ?>',
		'url':'<?php echo $wp_map['url_5']; ?>',
		'target':'<?php echo $wp_map['open_url_5']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_5']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_5']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_5']; ?>',
		'enable':<?php echo $wp_map['enable_region_5']=='1'?'true':'false'; ?>,
	},
	'state_6':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_6']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_6']) : stripslashes($wp_map['hover_content_6'])); ?>',
		'url':'<?php echo $wp_map['url_6']; ?>',
		'target':'<?php echo $wp_map['open_url_6']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_6']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_6']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_6']; ?>',
		'enable':<?php echo $wp_map['enable_region_6']=='1'?'true':'false'; ?>,
	},
	'state_7':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_7']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_7']) : stripslashes($wp_map['hover_content_7'])); ?>',
		'url':'<?php echo $wp_map['url_7']; ?>',
		'target':'<?php echo $wp_map['open_url_7']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_7']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_7']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_7']; ?>',
		'enable':<?php echo $wp_map['enable_region_7']=='1'?'true':'false'; ?>,
	},
	'state_8':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_8']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_8']) : stripslashes($wp_map['hover_content_8'])); ?>',
		'url':'<?php echo $wp_map['url_8']; ?>',
		'target':'<?php echo $wp_map['open_url_8']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_8']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_8']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_8']; ?>',
		'enable':<?php echo $wp_map['enable_region_8']=='1'?'true':'false'; ?>,
	},
	'state_9':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_9']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_9']) : stripslashes($wp_map['hover_content_9'])); ?>',
		'url':'<?php echo $wp_map['url_9']; ?>',
		'target':'<?php echo $wp_map['open_url_9']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_9']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_9']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_9']; ?>',
		'enable':<?php echo $wp_map['enable_region_9']=='1'?'true':'false'; ?>,
	},
	'state_10':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_10']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_10']) : stripslashes($wp_map['hover_content_10'])); ?>',
		'url':'<?php echo $wp_map['url_10']; ?>',
		'target':'<?php echo $wp_map['open_url_10']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_10']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_10']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_10']; ?>',
		'enable':<?php echo $wp_map['enable_region_10']=='1'?'true':'false'; ?>,
	},
	'state_11':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_11']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_11']) : stripslashes($wp_map['hover_content_11'])); ?>',
		'url':'<?php echo $wp_map['url_11']; ?>',
		'target':'<?php echo $wp_map['open_url_11']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_11']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_11']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_11']; ?>',
		'enable':<?php echo $wp_map['enable_region_11']=='1'?'true':'false'; ?>,
	},
	'state_12':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_12']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_12']) : stripslashes($wp_map['hover_content_12'])); ?>',
		'url':'<?php echo $wp_map['url_12']; ?>',
		'target':'<?php echo $wp_map['open_url_12']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_12']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_12']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_12']; ?>',
		'enable':<?php echo $wp_map['enable_region_12']=='1'?'true':'false'; ?>,
	},
	'state_13':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_13']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_13']) : stripslashes($wp_map['hover_content_13'])); ?>',
		'url':'<?php echo $wp_map['url_13']; ?>',
		'target':'<?php echo $wp_map['open_url_13']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_13']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_13']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_13']; ?>',
		'enable':<?php echo $wp_map['enable_region_13']=='1'?'true':'false'; ?>,
	},
	'state_14':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_14']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_14']) : stripslashes($wp_map['hover_content_14'])); ?>',
		'url':'<?php echo $wp_map['url_14']; ?>',
		'target':'<?php echo $wp_map['open_url_14']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_14']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_14']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_14']; ?>',
		'enable':<?php echo $wp_map['enable_region_14']=='1'?'true':'false'; ?>,
	},
	'state_15':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_15']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_15']) : stripslashes($wp_map['hover_content_15'])); ?>',
		'url':'<?php echo $wp_map['url_15']; ?>',
		'target':'<?php echo $wp_map['open_url_15']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_15']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_15']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_15']; ?>',
		'enable':<?php echo $wp_map['enable_region_15']=='1'?'true':'false'; ?>,
	},
	'state_16':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_16']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_16']) : stripslashes($wp_map['hover_content_16'])); ?>',
		'url':'<?php echo $wp_map['url_16']; ?>',
		'target':'<?php echo $wp_map['open_url_16']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_16']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_16']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_16']; ?>',
		'enable':<?php echo $wp_map['enable_region_16']=='1'?'true':'false'; ?>,
	},
	'state_17':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_17']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_17']) : stripslashes($wp_map['hover_content_17'])); ?>',
		'url':'<?php echo $wp_map['url_17']; ?>',
		'target':'<?php echo $wp_map['open_url_17']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_17']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_17']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_17']; ?>',
		'enable':<?php echo $wp_map['enable_region_17']=='1'?'true':'false'; ?>,
	},
	'state_18':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_18']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_18']) : stripslashes($wp_map['hover_content_18'])); ?>',
		'url':'<?php echo $wp_map['url_18']; ?>',
		'target':'<?php echo $wp_map['open_url_18']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_18']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_18']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_18']; ?>',
		'enable':<?php echo $wp_map['enable_region_18']=='1'?'true':'false'; ?>,
	},
	'state_19':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_19']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_19']) : stripslashes($wp_map['hover_content_19'])); ?>',
		'url':'<?php echo $wp_map['url_19']; ?>',
		'target':'<?php echo $wp_map['open_url_19']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_19']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_19']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_19']; ?>',
		'enable':<?php echo $wp_map['enable_region_19']=='1'?'true':'false'; ?>,
	},
	'state_20':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_20']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_20']) : stripslashes($wp_map['hover_content_20'])); ?>',
		'url':'<?php echo $wp_map['url_20']; ?>',
		'target':'<?php echo $wp_map['open_url_20']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_20']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_20']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_20']; ?>',
		'enable':<?php echo $wp_map['enable_region_20']=='1'?'true':'false'; ?>,
	},
	'state_21':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_21']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_21']) : stripslashes($wp_map['hover_content_21'])); ?>',
		'url':'<?php echo $wp_map['url_21']; ?>',
		'target':'<?php echo $wp_map['open_url_21']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_21']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_21']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_21']; ?>',
		'enable':<?php echo $wp_map['enable_region_21']=='1'?'true':'false'; ?>,
	},
	'state_22':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_22']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_22']) : stripslashes($wp_map['hover_content_22'])); ?>',
		'url':'<?php echo $wp_map['url_22']; ?>',
		'target':'<?php echo $wp_map['open_url_22']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_22']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_22']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_22']; ?>',
		'enable':<?php echo $wp_map['enable_region_22']=='1'?'true':'false'; ?>,
	},
	'state_23':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_23']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_23']) : stripslashes($wp_map['hover_content_23'])); ?>',
		'url':'<?php echo $wp_map['url_23']; ?>',
		'target':'<?php echo $wp_map['open_url_23']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_23']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_23']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_23']; ?>',
		'enable':<?php echo $wp_map['enable_region_23']=='1'?'true':'false'; ?>,
	},
	'state_24':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_24']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_24']) : stripslashes($wp_map['hover_content_24'])); ?>',
		'url':'<?php echo $wp_map['url_24']; ?>',
		'target':'<?php echo $wp_map['open_url_24']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_24']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_24']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_24']; ?>',
		'enable':<?php echo $wp_map['enable_region_24']=='1'?'true':'false'; ?>,
	},
	'state_25':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_25']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_25']) : stripslashes($wp_map['hover_content_25'])); ?>',
		'url':'<?php echo $wp_map['url_25']; ?>',
		'target':'<?php echo $wp_map['open_url_25']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_25']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_25']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_25']; ?>',
		'enable':<?php echo $wp_map['enable_region_25']=='1'?'true':'false'; ?>,
	},
	'state_26':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_26']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_26']) : stripslashes($wp_map['hover_content_26'])); ?>',
		'url':'<?php echo $wp_map['url_26']; ?>',
		'target':'<?php echo $wp_map['open_url_26']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_26']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_26']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_26']; ?>',
		'enable':<?php echo $wp_map['enable_region_26']=='1'?'true':'false'; ?>,
	},
	'state_27':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_27']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_27']) : stripslashes($wp_map['hover_content_27'])); ?>',
		'url':'<?php echo $wp_map['url_27']; ?>',
		'target':'<?php echo $wp_map['open_url_27']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_27']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_27']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_27']; ?>',
		'enable':<?php echo $wp_map['enable_region_27']=='1'?'true':'false'; ?>,
	},
	'state_28':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_28']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_28']) : stripslashes($wp_map['hover_content_28'])); ?>',
		'url':'<?php echo $wp_map['url_28']; ?>',
		'target':'<?php echo $wp_map['open_url_28']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_28']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_28']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_28']; ?>',
		'enable':<?php echo $wp_map['enable_region_28']=='1'?'true':'false'; ?>,
	},
	'state_29':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_29']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_29']) : stripslashes($wp_map['hover_content_29'])); ?>',
		'url':'<?php echo $wp_map['url_29']; ?>',
		'target':'<?php echo $wp_map['open_url_29']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_29']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_29']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_29']; ?>',
		'enable':<?php echo $wp_map['enable_region_29']=='1'?'true':'false'; ?>,
	},
	'state_30':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_30']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_30']) : stripslashes($wp_map['hover_content_30'])); ?>',
		'url':'<?php echo $wp_map['url_30']; ?>',
		'target':'<?php echo $wp_map['open_url_30']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_30']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_30']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_30']; ?>',
		'enable':<?php echo $wp_map['enable_region_30']=='1'?'true':'false'; ?>,
	},
	'state_31':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_31']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_31']) : stripslashes($wp_map['hover_content_31'])); ?>',
		'url':'<?php echo $wp_map['url_31']; ?>',
		'target':'<?php echo $wp_map['open_url_31']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_31']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_31']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_31']; ?>',
		'enable':<?php echo $wp_map['enable_region_31']=='1'?'true':'false'; ?>,
	},
	'state_32':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_32']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_32']) : stripslashes($wp_map['hover_content_32'])); ?>',
		'url':'<?php echo $wp_map['url_32']; ?>',
		'target':'<?php echo $wp_map['open_url_32']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_32']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_32']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_32']; ?>',
		'enable':<?php echo $wp_map['enable_region_32']=='1'?'true':'false'; ?>,
	},
	'state_33':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_33']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_33']) : stripslashes($wp_map['hover_content_33'])); ?>',
		'url':'<?php echo $wp_map['url_33']; ?>',
		'target':'<?php echo $wp_map['open_url_33']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_33']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_33']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_33']; ?>',
		'enable':<?php echo $wp_map['enable_region_33']=='1'?'true':'false'; ?>,
	},
	'state_34':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_34']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_34']) : stripslashes($wp_map['hover_content_34'])); ?>',
		'url':'<?php echo $wp_map['url_34']; ?>',
		'target':'<?php echo $wp_map['open_url_34']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_34']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_34']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_34']; ?>',
		'enable':<?php echo $wp_map['enable_region_34']=='1'?'true':'false'; ?>,
	},
	'state_35':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_35']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_35']) : stripslashes($wp_map['hover_content_35'])); ?>',
		'url':'<?php echo $wp_map['url_35']; ?>',
		'target':'<?php echo $wp_map['open_url_35']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_35']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_35']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_35']; ?>',
		'enable':<?php echo $wp_map['enable_region_35']=='1'?'true':'false'; ?>,
	},
	'state_36':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_36']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_36']) : stripslashes($wp_map['hover_content_36'])); ?>',
		'url':'<?php echo $wp_map['url_36']; ?>',
		'target':'<?php echo $wp_map['open_url_36']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_36']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_36']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_36']; ?>',
		'enable':<?php echo $wp_map['enable_region_36']=='1'?'true':'false'; ?>,
	},
	'state_37':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_37']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_37']) : stripslashes($wp_map['hover_content_37'])); ?>',
		'url':'<?php echo $wp_map['url_37']; ?>',
		'target':'<?php echo $wp_map['open_url_37']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_37']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_37']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_37']; ?>',
		'enable':<?php echo $wp_map['enable_region_37']=='1'?'true':'false'; ?>,
	},
	'state_38':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_38']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_38']) : stripslashes($wp_map['hover_content_38'])); ?>',
		'url':'<?php echo $wp_map['url_38']; ?>',
		'target':'<?php echo $wp_map['open_url_38']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_38']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_38']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_38']; ?>',
		'enable':<?php echo $wp_map['enable_region_38']=='1'?'true':'false'; ?>,
	},
	'state_39':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_39']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_39']) : stripslashes($wp_map['hover_content_39'])); ?>',
		'url':'<?php echo $wp_map['url_39']; ?>',
		'target':'<?php echo $wp_map['open_url_39']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_39']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_39']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_39']; ?>',
		'enable':<?php echo $wp_map['enable_region_39']=='1'?'true':'false'; ?>,
	},
	'state_40':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_40']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_40']) : stripslashes($wp_map['hover_content_40'])); ?>',
		'url':'<?php echo $wp_map['url_40']; ?>',
		'target':'<?php echo $wp_map['open_url_40']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_40']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_40']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_40']; ?>',
		'enable':<?php echo $wp_map['enable_region_40']=='1'?'true':'false'; ?>,
	},
	'state_41':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_41']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_41']) : stripslashes($wp_map['hover_content_41'])); ?>',
		'url':'<?php echo $wp_map['url_41']; ?>',
		'target':'<?php echo $wp_map['open_url_41']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_41']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_41']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_41']; ?>',
		'enable':<?php echo $wp_map['enable_region_41']=='1'?'true':'false'; ?>,
	},
	'state_42':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_42']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_42']) : stripslashes($wp_map['hover_content_42'])); ?>',
		'url':'<?php echo $wp_map['url_42']; ?>',
		'target':'<?php echo $wp_map['open_url_42']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_42']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_42']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_42']; ?>',
		'enable':<?php echo $wp_map['enable_region_42']=='1'?'true':'false'; ?>,
	},
	'state_43':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_43']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_43']) : stripslashes($wp_map['hover_content_43'])); ?>',
		'url':'<?php echo $wp_map['url_43']; ?>',
		'target':'<?php echo $wp_map['open_url_43']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_43']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_43']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_43']; ?>',
		'enable':<?php echo $wp_map['enable_region_43']=='1'?'true':'false'; ?>,
	},
	'state_44':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_44']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_44']) : stripslashes($wp_map['hover_content_44'])); ?>',
		'url':'<?php echo $wp_map['url_44']; ?>',
		'target':'<?php echo $wp_map['open_url_44']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_44']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_44']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_44']; ?>',
		'enable':<?php echo $wp_map['enable_region_44']=='1'?'true':'false'; ?>,
	},
	'state_45':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_45']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_45']) : stripslashes($wp_map['hover_content_45'])); ?>',
		'url':'<?php echo $wp_map['url_45']; ?>',
		'target':'<?php echo $wp_map['open_url_45']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_45']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_45']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_45']; ?>',
		'enable':<?php echo $wp_map['enable_region_45']=='1'?'true':'false'; ?>,
	},
	'state_46':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_46']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_46']) : stripslashes($wp_map['hover_content_46'])); ?>',
		'url':'<?php echo $wp_map['url_46']; ?>',
		'target':'<?php echo $wp_map['open_url_46']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_46']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_46']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_46']; ?>',
		'enable':<?php echo $wp_map['enable_region_46']=='1'?'true':'false'; ?>,
	},
	'state_47':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_47']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_47']) : stripslashes($wp_map['hover_content_47'])); ?>',
		'url':'<?php echo $wp_map['url_47']; ?>',
		'target':'<?php echo $wp_map['open_url_47']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_47']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_47']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_47']; ?>',
		'enable':<?php echo $wp_map['enable_region_47']=='1'?'true':'false'; ?>,
	},
	'state_48':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_48']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_48']) : stripslashes($wp_map['hover_content_48'])); ?>',
		'url':'<?php echo $wp_map['url_48']; ?>',
		'target':'<?php echo $wp_map['open_url_48']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_48']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_48']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_48']; ?>',
		'enable':<?php echo $wp_map['enable_region_48']=='1'?'true':'false'; ?>,
	},
	'state_49':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_49']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_49']) : stripslashes($wp_map['hover_content_49'])); ?>',
		'url':'<?php echo $wp_map['url_49']; ?>',
		'target':'<?php echo $wp_map['open_url_49']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_49']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_49']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_49']; ?>',
		'enable':<?php echo $wp_map['enable_region_49']=='1'?'true':'false'; ?>,
	},
	'state_50':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_50']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_50']) : stripslashes($wp_map['hover_content_50'])); ?>',
		'url':'<?php echo $wp_map['url_50']; ?>',
		'target':'<?php echo $wp_map['open_url_50']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_50']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_50']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_50']; ?>',
		'enable':<?php echo $wp_map['enable_region_50']=='1'?'true':'false'; ?>,
	},
	'state_51':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_map['hover_content_51']) ?
				array_map('stripslashes_deep', $wp_map['hover_content_51']) : stripslashes($wp_map['hover_content_51'])); ?>',
		'url':'<?php echo $wp_map['url_51']; ?>',
		'target':'<?php echo $wp_map['open_url_51']; ?>',
		'upcolor':'<?php echo $wp_map['up_color_51']; ?>',
		'overcolor':'<?php echo $wp_map['over_color_51']; ?>',
		'downcolor':'<?php echo $wp_map['down_color_51']; ?>',
		'enable':<?php echo $wp_map['enable_region_51']=='1'?'true':'false'; ?>,
	},
}
