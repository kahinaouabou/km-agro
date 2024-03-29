
@if(!empty($receipts))
<div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary" style=" width: calc( 100% - 1em ); display: table;
    width: 100%;
    table-layout: fixed;">
                    <tr>
                      <th>
                        {{ __('  ')}}
                      </th>
                    <th>  
                        {{ __('Reference')}}
                    </th>
                    <th>
                        {{__('Date')}} 
                    </th>
                    
                    <th>
                        {{__('Amount')}} 
                    </th>
                    <th>
                        {{__('Amount remaining')}} 
                    </th>
               </tr>
                </thead>
                  <tbody style =" display: block;
    height: 180px;
    overflow: auto;">
                  @foreach($receipts as $receipt)
                    <tr id="row-{{$receipt->id}} " style ="display: table;
    width: 100%;
    table-layout: fixed;">
                        <td>
                          <input id="check-{{$receipt->id}}" type="checkbox" class='id' 
                                 value={{(int)$receipt->id}}>
                      </td>
                        
                        <td>
                        {{ $receipt->reference }}
                        </td>
                        <td>
                        {{ $receipt->payment_date }}

                        </td>
                        <td>
                        {{ number_format($receipt->amount, 2, ',', ' ') }}

                        </td>
                        <td>
                        {{ number_format($receipt->rest, 2, ',', ' ') }}
                            
                              {!! Form::number('rest', $receipt->rest, [
                              'class' => 'form-control',
                              'step' => '0.01',
                              'id' =>'input-rest-'.$receipt->id,
                              'hidden' => true,
                              ]) !!}
                            
                        </td>
                      
                      </tr>
					          @endforeach
					      </tbody>
                </table>
              </div>

 @else 
 <p>{{__('There is no payments not associate')}}</p>
 @endif