                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                       {{ __('Reference')}}
                    </th>
                    <th>
                    {{__('Date')}} 
                    </th>
                    <th>
                    {{__('Product')}} 
                    </th>
                    <th>
                    {{__('Truck')}} 
                    </th>
                    <th>
                    {{__('Origin')}} 
                    </th>
                    <th>
                    {{__('Parcel')}} 
                    </th>
                    <th>
                    {{__('Third party')}} 
                    </th>
                    <th>
                    {{__('Block')}} 
                    </th>
                    <th>
                    {{__('Room')}} 
                    </th>
                    <th>
                    {{__('Number boxes')}} 
                    </th>
                    <th>
                    {{__('Raw')}} 
                    </th>
                    <th>
                    {{__('Tare')}} 
                    </th>
                    <th>
                    {{__('Net')}} 
                    </th>
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                  <tbody>
                  @foreach($bills as $bill)
                    <tr>
                        <td>
                        {{ $bill->reference }}
                        </td>
                        <td>
                        {{ $bill->bill_date->format('d/m/Y') }}
                        </td>
                        <td>
                        @if(!empty($bill->product->name))
                        {{ $bill->product->name }}
                        @endif
                        </td>
                        <td>
                        @if(!empty($bill->truck->model))
                        {{ $bill->truck->model }}
                        @endif
                        </td>
                        <td>
                        {{ $bill->origin }}

                        </td>
                        <td>
                        @if(!empty($bill->parcel->name))
                        {{ $bill->parcel->name }}
                        @endif
                        </td>
                        <td>
                        @if(!empty($bill->thirdParty->name)) 
                        {{ $bill->thirdParty->name }}
                        @endif
                        </td>
                        <td>
                        @if(!empty($bill->block->name)) 

                        {{ $bill->block->name }}
                        @endif
                        </td>
                        <td>
                        @if(!empty($bill->room->name)) 
                        {{ $bill->room->name }}
                        @endif
                        </td>
                        <td>
                        {{ $bill->number_boxes }}

                        </td>
                        <td>
                        {{ $bill->raw }}

                        </td>
                        <td>
                        {{ $bill->tare }}

                        </td>
                        <td>
                        {{ $bill->net }}

                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('bills.edit', [$bill->id,$type]) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-warning btn-link" href="{{ route('bills.printBill', [$bill->id,$type]) }}" data-original-title="" title="" target="_blank">
                              <i class="material-icons">print</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $bill->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>
                            <form id="destroy{{ $bill->id }}" action="{{ route('bills.destroy', $bill->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            </td>
                      </tr>
					   @endforeach
					</tbody>
                </table>