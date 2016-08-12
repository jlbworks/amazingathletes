<!-- modal template, generic -->
<div id="am2_modal_template" data-remodal-id="modal">
  <div class="nest"></div>
</div>

<!-- modal template, delete, confirm, cancel ? -->
<div id="am2_modal_delete" data-remodal-id="delete">
    <section class="panel">
      <div class="panel-body text-center">
        <div class="modal-wrapper">
          <div class="modal-icon center">
            <i class="fa fa-times-circle"></i>
          </div>
          <div class="modal-text">
            <h4>Are you sure?</h4>
            <p>Are you sure that you want to delete this?</p>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12">
            <button data-remodal-action="confirm" class="btn btn--primary remodal-confirm" data-object="" data-id="">Confirm</button>
            <button data-remodal-action="cancel" class="btn btn--primary remodal-cancel">Cancel</button>
          </div>
        </div>
      </footer>
    </section>
  </div>
</div>

<script>
$(document).on('click', '.am2-ajax-modal', function(event) {

  var which_modal = $(this).data('modal');
  
  $.get(which_modal, function(html) {
      $('.nest').html(html);
  });
  
  $('[data-remodal-id=modal]').remodal({
    hashTracking: false, 
    closeOnOutsideClick: true
  }).open();

});

// Brisanje podataka JS dio
function izbrisi(which_object,which_id){
    $.ajax({
      url: '<?php echo get_ajax_url('delete_object',''); ?>&object='+which_object+'&id='+which_id,
      method: 'POST',
      dataType: 'json',
      success: function(json){
          $('#datatable-editable tr [data-id="'+which_id+'"]').parent().parent().remove();
      } 
    });
}

$(document).on('click', '.am2-ajax-modal-delete', function (event) {

  event.preventDefault();
  var which_object = $(this).data('object');
  var which_id = $(this).data('id');

  swal({   
    title: "Are you sure?",
    text: "You cannot undo this action!",
    type: "warning",   
    showCancelButton: true,
    cancelButtonText: "Cancel",
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Yes, delete!",
    closeOnConfirm: false 
  }, 
    function(){
      izbrisi(which_object,which_id)
      swal("Deleted!", "Deleted successfully.", "success");
  });

});

</script>