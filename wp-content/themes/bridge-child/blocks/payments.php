<?php 
global $current_user; 
get_currentuserinfo();

restrict_access('administrator,franchise');

// Mozda staviti da kada je admin, da izbaci meta query ?
$args = array(
  'post_type'   => 'payments',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
);
if(is_role('franchise')) {
  $args['meta_query']  = array(
    array( 'key'=>'franchise_id','value'=> get_current_user_id() )
  );
}
$payments = get_posts($args);

?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Payments</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','payments-edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New payments Entry</button>
            </div>
        </div>
    </div>

    <!-- PRODUCT INFORMATION -->
    <div class="layout">
        <div class="container clearfix">
            <div class="col-1 break-big">
                <!-- TABLE (LIST OF USERS) -->
                <table class="table js-responsive-table" id="datatable-editable">
                  <thead>
                    <tr>
                      <th><span>Ime</span></th>
                      <th><span>Doktor</span></th>
                      <th><span>Bolnica</span></th>
                      <th><span>Ulica</span></th>
                      <th><span>Grad</span></th>
                      <th><span>Telefon</span></th>
                      <th><span>Email</span></th>
                      <th><span>Akcije</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach($payments as $payment){
                        // $bolnica_users = get_bolnica_users($payment->ID);
                    ?>
                    <tr class="gradeA">
                      <td style="white-space:nowrap"><a class="am2-ajax-modal"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','payments-edit') .'&id='.$payment->ID; ?>"><?php echo $payment->post_title; ?></a></td>
                      <td><?php $user_info = get_userdata($payment->doktor); echo $user_info->first_name.' '.$user_info->last_name; ?></td>
                      <td><?php echo get_the_title($payment->bolnica); ?></td>
                      <td><?php echo $payment->address; ?></td>
                      <td><?php echo $payment->city; ?></td>
                      <td><?php echo $payment->phone; ?></td>
                      <td><?php
                          $email = trim($payment->contact_email);
                          if( empty($email) ){
                            echo '';//'-'
                          }else{
                            echo '<a target="_blank" href="mailto:'.$email.'">'.$email.'</a>';
                          }
                      ?></td>

                      <td>
                        <a class="am2-ajax-modal btn btn--primary is-smaller"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','payments-edit') .'&id='.$payment->ID; ?>"><i class="fa fa-pencil"></i></a>
                        <?php if( is_role('administrator') ){ ?>
                          <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                          data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                          data-object="payment" data-id="<?php echo $payment->ID; ?>"><i class="fa fa-trash-o"></i></a>
                        <?php }; ?>
                    </tr>
                    <?php }; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
        
<script type="text/javascript">

set_title('Payments');

/*
  

  var datatableInit = function() {
    
    // Setup - add a text input to each footer cell
    $('#datatable-editable thead th').each( function(){
        var title = $('#datatable-editable thead th').eq( $(this).index() ).text();
        if( title!=='Actions' ){
          $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" data-index="'+$(this).index()+'" />' );
        }
    });

    var $table = $('#datatable-editable');

    // format function for row details
    var fnFormatDetails = function( datatable, tr ) {
      var data = datatable.fnGetData( tr );

      return [
        '<div class="col-12">',
          '<table id="table-details" class="table mb-none remove-empty-rows">',
            '<tr>',
              '<td><label class="mb-none">Contacts:</label></td>',
              '<td>' + data[8]+ '</td>',
            '</tr>',
            '<tr>',
              '<td><label class="mb-none">Contact email:</label></td>',
              '<td>' + data[6]+ '</td>',
            '</tr>',
            '<tr>',
              '<td><label class="mb-none">Website:</label></td>',
              '<td>' + data[7]+ '</td>',
            '</tr>',
          '</table>',
        '</div>',
        '<div class="col-12">',
          '<table id="table-details" class="table mb-none remove-empty-rows">',
            '<tr class="b-top-none">',
              '<td class="col-14"><label class="mb-none">Bolnica:</label></td>',
              '<td>' + data[1]+ '</td>',
            '</tr>',
            '<tr>',
              '<td><label class="mb-none">Address:</label></td>',
              '<td>' + data[3]+ '</td>',
            '</tr>',
            '<tr>',
              '<td><label class="mb-none">City:</label></td>',
              '<td>' + data[4]+ '</td>',
            '</tr>',
            '<tr>',
              '<td><label class="mb-none">Phone:</label></td>',
              '<td>' + data[5]+ '</td>',
            '</tr>',
          '</table>',
        '</div>',
        '<div class="col-1">',
          '<label class="mb-none">Notes:</label>',
          '<div class="notes">'+data[9]+'</div>',
        '</div>'
      ].join('');
    };

    // insert the expand/collapse column
    var th = document.createElement( 'th' );
    var td = document.createElement( 'td' );
    td.innerHTML = '<i data-toggle class="fa fa-plus-square-o text-primary h5 m-none" style="cursor: pointer;"></i>';
    td.className = "text-center";

    $table
      .find( 'thead tr' ).each(function() {
        this.insertBefore( th, this.childNodes[0] );
      });

    $table
      .find( 'tbody tr' ).each(function() {
        this.insertBefore(  td.cloneNode( true ), this.childNodes[0] );
      });

    // initialize
    var datatable = $table.dataTable({
      "iDisplayLength": 100,
      aoColumnDefs: [{
        bSortable: false,
        aTargets: [ 0 ]
      }],
      aaSorting: [
        [1, 'asc']
      ]
    });

    $('#datatable-editable input').on( 'click', function(event){
        event.preventDefault();
        event.stopPropagation();
    });
    
    // add a listener
    $table.on('click', 'i[data-toggle]', function(event) {
      var $this = $(this),
      tr = $(this).closest( 'tr' ).get(0);
      if ( datatable.fnIsOpen(tr) ) {
        $this.removeClass( 'fa-minus-square-o' ).addClass( 'fa-plus-square-o' );
        datatable.fnClose( tr );
      } else {
        $this.removeClass( 'fa-plus-square-o' ).addClass( 'fa-minus-square-o' );
        datatable.fnOpen( tr, fnFormatDetails( datatable, tr), 'details' );
        // Table details cleanup, hide empty values
        $('.remove-empty-rows tr td').each(function(index, el) {
            if( $(el).html()=='' || $(el).html()==undefined ){
                $(el).parent().remove();
            }
        });
      }
    });


    <?php
    // ******************************************************************
    $page = str_replace('.php','',basename(__FILE__));
    ?>
    var typingTimer;
    // add column search listener
    $table.on('keyup change', 'input', function(){
        var index = $(this).data('index');
        $table.DataTable().column( index+1 ).search( this.value ).draw();
        // save datatable filters
        var columns = [];
        $('#datatable-editable thead th').each( function(){
          var value = $(this).find('input').val();
          var index = $(this).find('input').data('index');
          if( value!==undefined && value!=="undefined" && value!=='' ){
            columns[index] = value;
          }
        });

        // save 
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function(){
            $.post('<?php echo site_url();?>/wp-admin/admin-ajax.php', {action:'save_datatable_filters',page:'<?php echo $page;?>',columns:columns}, function(data, textStatus, xhr) {
              // success
            });
        }, 250);

    });

    // load and save column search fields
    <?php
    if( is_array($_SESSION['dtf-'.$page]) ){
      $savedColumns = $_SESSION['dtf-'.$page];
    }else{
      $savedColumns = array();
    }
    ?>
    savedColumns = <?php echo json_encode($savedColumns);?>;
    $('#datatable-editable thead th').each( function(){
        // test
        //$(this).find('input').val('bla');
        //
        var index = $(this).find('input').data('index');
        var value = $(this).find('input').val();
        var old = savedColumns[index];
        if( old!==undefined && old!=="undefined" && old!=='' ){
            $(this).find('input').val(old);
            var value = old;
        }
        //console.log(index+':'+old+':'+value);
        if( value!==undefined && value!=="undefined" && value!=='' ){
          //console.log(index+':'+value);
          $table.DataTable().column( index+1 ).search( value ).draw();
        }
    });

    <?php
    // ******************************************************************
    ?>


  };

$(function() {
  datatableInit();
});

*/

</script>

<?php get_template_part('blocks/modal-template'); ?>