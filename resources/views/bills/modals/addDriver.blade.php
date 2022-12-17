<div class="modal" id="addDriver">
  <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title">{{__("Add driver")}}</h4>
                <button type="button" class="close quick-close" data-dismiss="modal">
                <span>&times;</span>
                </button>            
            </div>
            <form id="add-truck-form"   autocomplete="off" class="form-horizontal">
          
                <div class="modal-body">
                <div class="row">
                  <label class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name-driver" type="text" placeholder="{{ __('Name') }}"  aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name-driver">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">{{ __('Phone') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="name" id="input-phone-driver" type="text" placeholder="{{ __('Phone') }}"  aria-required="true"/>
                      @if ($errors->has('phone'))
                        <span id="phone-error" class="error text-danger" for="input-phone-driver">{{ $errors->first('phone') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
             
                {!! Form::number('third_party_id', null, [
                                  'hidden' => true,
                                  'id'=>'input-subcontractor'
                                  ]) !!}
            
                
            
                </div>
                <div class="modal-footer">
                    <button type="button" id="add-driver-button" class="btn btn-primary">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </form>
        </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
  
  jQuery(document).on('click', '.quick-close', function() {
        $('#addTruck').removeClass('show'); 
        $('#addTruck').css("display","none");
        $('#input-registration').removeAttr('required');
  });
 

});
</script> 