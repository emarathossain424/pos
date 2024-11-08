@if(empty($property_item_ids))
    @foreach($properties as $property)
    <div class="form-group">
        <label for="property_items">{{translate('Select available') . ' ' . $property->name . ' ' . translate('for this food')}}</label>
        <select class="form-control select2 w-100 property_items" name="property_items_{{$property->id}}[]" multiple>
            <option value="">{{translate('Select Properties')}}</option>
            @foreach($property->items as $item)
                <option value="{{$item->id}}" selected>{{$item->item_name}}</option>
            @endforeach
        </select>
    </div>
    @endforeach
@else
    @foreach($properties as $property)
    <div class="form-group">
        <label for="property_items">{{translate('Select available') . ' ' . $property->name . ' ' . translate('for this food')}}</label>
        <select class="form-control select2 w-100 property_items" name="property_items_{{$property->id}}[]" multiple>
            <option value="">{{translate('Select Properties')}}</option>
            @foreach($property->items as $item)
                <option value="{{$item->id}}" {{in_array($item->id,$property_item_ids)?'selected':''}}>{{$item->item_name}}</option>
            @endforeach
        </select>
    </div>
    @endforeach
@endif