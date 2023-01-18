<div class="panel-group">
            <div class="panel panel-default">
            
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#search"><i class="material-icons">search</i>{{ __('Search') }}</a>
                </h4>
              </div>
              <div class="collapse " id="search">
                <form action="{{ route('payments.index') }}" method="GET" style="margin-top: 20px;">
                
                <div class="card ">
                  
                    <div class="card-body ">
                      
                        <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Customers') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="third_party_id" id="input-third-party" class="third-party-select2 form-control">
                                  <option value="0">{{ __('Select third') }}</option>
                                  @foreach (\App\Models\ThirdParty::select('id','name')->get() as $thirdParty)
                                    <option value="{{ $thirdParty->id }}" {{ $thirdParty->id == $selected_id['third_party_id'] ? 'selected' : '' }}>
                                    {{ $thirdParty['name'] }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Categorie') }}</label>
                      
                          <div class="col-sm-3" style="display: inline-block;">
                            <div class="form-group">
                              <select name="payment_category_id" id="input-payment-category" class="third-party-select2 form-control">
                                <option value="0">{{ __('Select category') }}</option>
                                @foreach (\App\Models\PaymentCategory::select('id','name')->get() as $paymentCategory)
                                  <option value="{{ $paymentCategory->id }}" {{ $paymentCategory->id == $selected_id['payment_category_id'] ? 'selected' : '' }}>
                                  {{ $paymentCategory['name'] }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                          </div>		
                            
                          
                        </div>	
                        <div class="col-sm-12">
                          
                          <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Type') }}</label>
                      
                          <div class="col-sm-3" style="display: inline-block;">
                            <div class="form-group">
                              <?php
                              $types = [
                                ''=> 'Select type',
                                'Receipt' => 'Receipt',
                                'Disbursement' => 'Disbursement'
                              ]
                              ?>
                              <select name="payment_type" id="input-payment-type" class="third-party-select2 form-control">
                                
                                @foreach ($types  as $key => $value)
                                  <option value="{{ $key }}" {{ $key == $selected_id['payment_type'] ? 'selected' : '' }}>
                                  {{ __($value) }}
                                </option>
                                @endforeach
                              </select>
                            </div>
                          </div>		
                          
                        
                      </div>  
                          <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Date from') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                              {!! Form::input('date','date_from', $selected_id['date_from']  ,
                                ['class' => 'form-control','id'=>'input-date-from']) !!}
                              </div>
                            </div>	
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Date to') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                              {!! Form::input('date','date_to',$selected_id['date_to'],
                                ['class' => 'form-control','id'=>'input-date-to']) !!}
                              </div>
                            </div>
                          </div>			   
                          
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                            <input type="submit" id="btn-search" class="btn btn-danger btn-sm" value="{{ __('Filter') }}"> 
                    </div>
                    
                  
                </div>
                </form>
              </div>
            </div>
          </div>