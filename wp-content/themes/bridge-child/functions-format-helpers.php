<?php


function formatWOStatus($order){
  global $wo_status_options;
  global $wo_status_paid_options;
  global $wo_status_paid_short_options;

  $status_paid = '';
  $link = get_ajax_url('modal','work-order-status') .'&order_id='.$order->ID;
  if( empty($order->status) ){
      $text = $wo_status_options[0];
      $color_class = 'wo-status-0';
  }else{
      $text =$wo_status_options[$order->status];
      $color_class = 'wo-status-'.(string)$order->status;
      if( $order->status==30){
          if( !empty($order->status_paid) ){
              $status_paid = $order->status_paid;
          }
      }
  };
  $status = '<span class="label '.$color_class.'"><a class="'.$color_class.' am2-ajax-modal modal-with-move-anim" 
                data-original-title="'.$text.' &raquo; Change status" data-placement="top" data-toggle="tooltip"
                data-modal="'.$link.'" ><b style="white-space: nowrap;">'.$text.'</b></a></span>';

  if( !empty($status_paid) ){
      $status.='<span class="label" style="color:#000;font-size:10px;font-weight:normal;">'.$wo_status_paid_short_options[$status_paid].'</span>';
  }

  return $status;
}


function formatWOInvoice($order){

  $invoice = '';
  $link = get_ajax_url('modal','work-order-invoice') .'&order_id='.$order->ID;
  if( empty($order->invoice) ){
      $text = '<i class="fa fa-pencil"></i> None';
  }else{
      $text = $order->invoice;
  };
  
  $status = '<span class="label '.$color_class.'"><a class="'.$color_class.' am2-ajax-modal modal-with-move-anim" 
                data-original-title="Change invoice number" data-placement="top" data-toggle="tooltip"
                data-modal="'.$link.'" ><b style="white-space: nowrap;">'.$text.'</b></a></span>';
  
  return $status;
}


/**
 FORMATING HELPERS
 */
function formatBolnicaUser($user){
  if( !is_object($user) ){
    $user = get_user_by( 'id', $user );
  }
  
  $datamodal = site_url().'/wp-admin/admin-ajax.php?action=get_modal_page&amp;target_page=user_edit&amp;id='.$user->ID;
  //$datamodal = site_url().'/ajax-endpoint.php?action=get_modal_page&amp;target_page=user_edit&amp;id='.$user->ID;
  
  $out ='<span class="am2-user">';
  //is_role('administrator,staff');
  $out.='<a class="am2-ajax-modal modal-with-move-anim" data-modal="'.$datamodal.'">'.$user->first_name.' '.$user->last_name.'</a>';
  if( !empty($user->bolnica_role) ){
    $out.=', '.$user->bolnica_role;
  }
  $out.='</span>';

  $phone = $user->phone;
  if( !empty($phone) ){
    $out.='&nbsp;<span class="am2-phone">('.$phone.')</span> ';
  }

  $email = trim($user->user_email);
  if( !empty($email) ){
    $out.='&nbsp;<span class="am2-email">(<a target="_blank" href="mailto:'.$email.'">'.$email.'</a>)</span> ';
  }

  return $out;
}

function formatBolnicaTitle($bolnica,$page='bolnica'){
  if( !is_object($bolnica) ){
    $bolnica = get_post( $bolnica );
  }
  $datamodal = site_url().'/wp-admin/admin-ajax.php?action=get_modal_page&amp;target_page='.$page.'&amp;id='.$bolnica->ID;
  //$datamodal = site_url().'/ajax-endpoint.php?action=get_modal_page&amp;target_page='.$page.'&amp;id='.$bolnica->ID;
  return '<a class="am2-ajax-modal modal-with-move-anim" data-modal="'.$datamodal.'">'.$bolnica->post_title.'</a>';
}


/**
 TABLE FORMATING HELPERS, Data, Yes, No, Link, None
 */
function formatYesNo($data){
  if( !empty($data) ){
    return '<span class="text-success">Yes</span>';
  }
  return '<span class="text-danger">No</span>';
}
function formatDataNo($data){
  if( !empty($data) ){
    return $data;
  }
  return '<span class="text-danger">No</span>';
}
function formatDataNone($data){
  if( !empty($data) ){
    return $data;
  }
  return '-';
}
function formatLinkNone($data){
  if( !empty($data) ){
    return '<a href="'.$data.'" target="_blank">'.$data.'</a>';
  }
  return '-';
}
function formatLongLinkNone($data){
  if( !empty($data) ){
    return '<a href="'.$data.'" target="_blank">LINK</a>';
  }
  return '-';
}
function formatEmail($email){
  if( !empty($email) ){
    return '<a href="mailto:'.$email.'" target="_blank">'.$email.'</a>';
  }
  return '-';
}
function formatDateTime($datetime){
  $ts = strtotime($datetime);
  return date('m/d/Y h:i A',$ts);
}



/**
 FORM CONTROLS
 */
function controlIgnore($post,$meta_key){

    $ignore_key = $meta_key.'_ignored';
    $ignored = $post->$ignore_key;

    if( !empty($ignored) ){
        $chk_ok='';
        $active_ok='';
        $chk_ignored=' checked';
        $active_ignored=' active';
    }else{
        $chk_ok=' checked';
        $active_ok=' active';
        $chk_ignored='';
        $active_ignored='';
    }

    return '
<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary-switch '.$active_ok.'">
    <input type="radio" name="'.$ignore_key.'" autocomplete="off" value="" '.$chk_ok.'> Count
  </label>
  <label class="btn btn-primary-switch '.$active_ignored.'">
    <input type="radio" name="'.$ignore_key.'" autocomplete="off" value="ignored" '.$chk_ignored.'> Ignore
  </label>
</div>
';

}


/**
 
 */
function countMissingBolnicaData($bolnica){

    $count = 0;

    $meta_fields = array(
        'logo',
        'tile',
        'header',
        'background',
        'about',
        'facebook',
        'youtube',
        'twitter',
        'special_events',
        'weekly_events',
        'upcoming_events',
        'past_events',
        'galleries'
    );

    foreach($meta_fields as $field){

        $ignore_key = $field.'_ignored';

        if( empty($bolnica->$field) and empty($bolnica->$ignore_key) ){
            $count++;
        }
    }

    return $count;
}


function findClientNoteID($bolnica,$timestamp){
    if( !is_object($bolnica) ){
        $bolnica = get_post($bolnica);
    }
    global $wpdb;
    $meta_id = $wpdb->get_var("
            SELECT meta_id
            FROM am_postmeta
            WHERE 
              post_id = '{$bolnica->ID}' AND
              meta_key='client_notes' AND
              meta_value LIKE '%\"timestamp\";i:{$timestamp};%'
            LIMIT 1
        ");
    return $meta_id;
}


function deleteClientNote($meta_id){
    global $wpdb;
    if( $meta_id>0 ){
        $wpdb->get_results("DELETE FROM am_postmeta WHERE meta_id='$meta_id' LIMIT 1");
        return true;
    }else{
        return false;
    }
}


function listClientNotes($bolnica,$show_more=false,$show_add=false){

  $client_notes   = get_post_meta( $bolnica->ID, 'client_notes', false );
  $client_notes = array_reverse($client_notes);


  $show_max = 3;

  $total = count($client_notes);

  $number_more = $total - $show_max;

  $out = '';
  if( $show_more==false ){
      $out.= '<div class="client-notes-'.$bolnica->ID.'">';
  }

  if( is_array($client_notes) ){
      
      if( $total>$show_max and $show_more==false ){
          $out.='<div class="col-md-6">
                    <a class="btn btn-secondary" onclick="show_more_client_notes(this);" data-bolnica-id="'.$bolnica->ID.'""><i class="fa fa-arrow-up"></i> SHOW '.$number_more.' MORE </a>
                </div>';
      }

      $i=0;
      $out.='<ul class="list-unstyled col-md-12">';

      $notes_to_display = array();
      foreach($client_notes as $note){
          $i++;
          $notes_to_display[] = $note;

          if( $i>=$show_max and $show_more==false ){
              break;
          }
      }

      $notes_to_display = array_reverse($notes_to_display);

      foreach ($notes_to_display as $note) {
          $writer = get_user_by('id',$note['user_id']);
          $out.='<li style="padding-bottom:5px;"><div class="result-data">';
          $out.='<span class="notes-info">';
          $out.='On <span class="notes-date">'.date('M dS, Y.',$note['timestamp']).'</span> at <span class="notes-date">'.date('h:i A',$note['timestamp']).'</span>, <span class="notes-person">'.$writer->first_name.' '.$writer->last_name.'</span> wrote:';
          $out.='</span>';
          $out.='<a class="btn btn-danger btn-xs am2-ajax-modal-delete modal-with-move-anim" 
                  data-original-title="Delete note" data-placement="top" data-toggle="tooltip"
                  data-object="client_note" data-id="'.findClientNoteID($bolnica->ID,$note['timestamp']).'">
                    <i class="fa fa-trash-o"></i>
                  </a>';
          $out.='<p class="description">'.esc_html( $note['body'] ).'</p>';
          $out.='</div></li>';
      }

      $out.='</ul>';
  }

  if( $show_more==false ){
      $out.= '</div>';
  }


  if( $show_add!==false ){
      $link = get_ajax_url('modal','bolnica') .'&id='.$bolnica->ID.'&open_tab=tab-notes';
      $out.= '<div class="col-md-6">
                <a class="btn btn-primary am2-ajax-modal modal-with-move-anim" 
                data-original-title="Add a note" data-placement="top" data-toggle="tooltip"
                data-modal="'.$link.'"><i class="fa fa-pencil"></i> ADD A NOTE</a>
              </div>';
  }
  

  return $out;
}

/*

function listClientNotes($bolnica){

  $client_notes   = get_post_meta( $bolnica->ID, 'client_notes', false );

  $out = '';
  if( is_array($client_notes) ){
      $out.='<table class="table table-bordered table-striped table-hover">';
      foreach($client_notes as $note){
          $writer = get_user_by('id',$note['user_id']);
          $out.='<tr>';
          $out.='<td class="col-md-4">'.$writer->first_name.' '.$writer->last_name;
          $out.='<br> on '.date('Y-m-d H:i',$note['timestamp']);
          $out.='</td>';
          $out.='<td class="col-md-8">'.esc_html( $note['body'] ).'</td>';
          $out.='</tr>';
      }
      $out.='</table>';
      $out.='<br>';
  }

  return $out;
}
 */