@foreach($properties as $property)
<div class="form-group">
    <label for="property_items">{{translate('Select available') . ' ' . $property->name . ' ' . translate('for this food')}}</label>
    <select class="form-control select2 w-100 property_items" name="property_items" multiple>
        <option value="">{{translate('Select Properties')}}</option>
        @foreach($property->items as $item)
            <option value="{{$item->id}}">{{$item->item_name}}</option>
        @endforeach
    </select>
</div>
@endforeach