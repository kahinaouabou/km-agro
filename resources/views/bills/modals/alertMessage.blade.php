<div class="modal" id="alertMessage">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{__("Alert")}}</h4>
        <button type="button" class="close quick-close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">



      </div>
      <div class="modal-footer" id='modal-footer'>
        <button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  jQuery(document).on('click', '.quick-close', function() {
    $('#alertMessage').removeClass('show');
    $('#alertMessage').css("display", "none");
  });

  jQuery(document).on('click', '#accept-button', function() {
    let href = $('#input-href').val();
    console.log(href);
    window.location.href = href;
  })
</script>