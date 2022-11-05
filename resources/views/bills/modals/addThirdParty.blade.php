<div class="modal" id="addThirdParty">
  <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                @if($isSupplier==1)  { 
                <h4 class="modal-title">{{__("Add supplier")}}</h4>
                @else 
                <h4 class="modal-title">{{__("Add customer")}}</h4>
                @endif
                <button type="button" class="close quick-close" data-dismiss="modal">
                <span>&times;</span>
                </button>            
            </div>
            <form id="add-third-party-form"   autocomplete="off" class="form-horizontal">
           
                <div class="modal-body">
                   
                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" 
                            id="input-name" type="text" placeholder="{{ __('Name') }}"  
                            //onfocusout="checkIfNameThirdPartyExist()" 
                            aria-required="true"/>
                            @if ($errors->has('name'))
                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                            @endif
                            </div>
                        </div>
                        <p id='p-msg'></p>
                    </div>
                 
                    {!! Form::number('is_supplier', $isSupplier, [
                                  'hidden' => true,
                                  'id'=>'input-is-supplier'
                                  ]) !!}
            
                </div>
                <div class="modal-footer">
                    <button type="button" id="add-third-party-button" class="btn btn-primary">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </form>
        </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
  
  jQuery(document).on('click', '.quick-close', function() {
        $('#addThirdParty').removeClass('show'); 
        $('#addThirdParty').css("display","none");
        $('#input-name').removeAttr('required');
  });
  $("#input-name").focusout(function(e) {
    checkIfNameThirdPartyExist();
  })

});
function checkIfNameThirdPartyExist(){
    let name = $('#input-name').val();
    console.log(name);
    $.ajax({
  url : "{{ route('thirdParties.searchName') }}",
  type: 'get',
  headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
  data :{
      name:name,
  },
  success:function(response){
        console.log(response.thirdParty.length);
        if((response.thirdParty.length!==0)){
         $('#input-name').val('');
         $('#p-msg').html("<?php echo __('Name already exist, change it.')?>")
        }else {
          $('#p-msg').html("")
        }

      },
      error: function(error) {
        console.log(error);
      }
});
    
}
</script> 