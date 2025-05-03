<div class="modal-body">
    <div class="row p-3">
        @if($order_index==-1)
        <input type="hidden" name="food_item_id" id="food_item_id" value="{{ $food_item_id }}">
        <input type="hidden" name="food_item_name" id="food_item_name" value="{{ $food_item_name }}">
        <input type="hidden" name="food_item_quantity" id="food_item_quantity" value="{{ $food_item_quantity }}">
        @else
        <input type="hidden" name="order_index" id="order_index" value="{{ $order_index }}">
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{ translate('Select') }}</th>
                    @foreach($variants[0]['combo'] as $item)
                    <th>{{ $item['variant']['name'] }}</th>
                    @endforeach
                    <th>{{translate('Price')}} ({{getCurrencySymbol(getGeneralSettingsValue( 'default_currency' ))}})</th>
                </tr>
            </thead>
            <tbody>
                @php
                $key = 0;
                @endphp
                @foreach($variants as $item)
                @if(!empty($item['availability']))
                @php
                $current_variant = $item;
                $checked = '';
                if($order_index == -1){
                $checked = $key==0?'checked':'';
                }
                else{
                $checked = $current_variant==$food_item_variant?'checked':'';
                }
                @endphp
                <tr>
                    <td>
                        <input type="radio" name="variant" value="{{ json_encode($item) }}" {{ $checked }} />
                    </td>
                    @foreach($item['combo'] as $combo)
                    <td>{{ $combo['options']['name'] }}</td>
                    @endforeach
                    <td>{{setPriceFormat($item['special_price'])}}</td>
                </tr>
                @php
                $key++;
                @endphp
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{translate('Close')}}</button>
    @if($order_index==-1)
    <button type="button" class="btn btn-primary use-variant" data-dismiss="modal">{{translate('Select')}}</button>
    @else
    <button type="button" class="btn btn-primary update-variant" data-dismiss="modal">{{translate('Update')}}</button>
    @endif
</div>