@if(!empty($properties->toArray()))
<input type="hidden" name="order_index" id="order_index" value="{{ $order_index }}">
@foreach($properties as $property)
<h5>{{translate('Select')}} {{ $property->name }}</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">{{translate('Select')}}</th>
                <th scope="col">{{translate('Title')}}</th>
                <th scope="col">{{translate('Quantity')}}</th>
                <th scope="col">{{translate('Price')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($property->items as $item)
            @php
            $checked = '';
            $quantity = 1;
            foreach($selected_properties as $property){
            if($property['id'] == $item->id && $property['price'] == $item->price){
            $checked = 'checked';
            $quantity = $property['quantity'];
            }
            }
            @endphp
            <tr class="single-food-property">
                <td>
                    <input type="checkbox" name="food_property_items[]" value="{{ json_encode($item) }}" class="food-property-items" {{ $checked }} />
                </td>

                <!-- Property Title -->
                <td>{{ $item->item_name }}</td>

                <!-- Quantity Selector -->
                <td>
                    <div class="d-flex justify-content-center quantity-selector">
                        <button class="btn btn-sm btn-outline-pink btn-decrement" type="button"> - </button>
                        <input type="number" class="form-control quantity-input food-property-quantity mx-2" value="{{ $quantity }}" min="1" value="1" style="width: 100px; text-align: center; height: 31px;" aria-label="Quantity" name="food_property_quantity[]">
                        <button class="btn btn-sm btn-outline-pink btn-increment" type="button">+</button>
                    </div>
                </td>

                <!-- Price -->
                <td>
                    <strong>${{ number_format($item->price, 2) }}</strong>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endforeach
@else
<p class="text-center my-5">{{ translate('No property found') }}</p>
@endif

<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{translate('Close')}}</button>
    <button type="button" class="btn btn-primary update-property" data-dismiss="modal">{{translate('Select')}}</button>
</div>