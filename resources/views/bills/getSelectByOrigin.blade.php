@switch($origin)
@case('internal')
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Parcels') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                   
                    {!! Form::select('parcel_id', $parcels,null,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select parcel') ,
      
                        ]) !!}
                    </div>
                  </div>
                </div>
@break
@case('external')
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Suppliers') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                   
                    {!! Form::select('third_party_id', $thirdParties,null,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select supplier') ,
                        'id'=>'input-third-party',
                        'onchange' => 'getParcelsByThirdPartyId(this.value)'
                        ]) !!}
                    </div>
                  </div>
                </div>
                <div id="div-parcel">
                </div>

@break
@default
@endswitch

