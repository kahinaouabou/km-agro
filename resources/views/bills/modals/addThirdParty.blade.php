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
                    <label class="col-sm-2 col-form-label">{{ __('Code') }}</label>
                    <div class="col-sm-7">
                        <div class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" id="input-code" type="text" placeholder="{{ __('Code') }}" aria-required="true"/>
                        @if ($errors->has('code'))
                            <span id="code-error" class="error text-danger" for="input-code">{{ $errors->first('code') }}</span>
                        @endif
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                    <div class="col-sm-7">
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}"  required="true" aria-required="true"/>
                        @if ($errors->has('name'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                        @endif
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                    <div class="col-sm-7">
                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input-address" type="text" placeholder="{{ __('Address') }}" aria-required="true"/>
                        @if ($errors->has('address'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('address') }}</span>
                        @endif
                        </div>
                    </div>
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
  });
 

});
</script> 