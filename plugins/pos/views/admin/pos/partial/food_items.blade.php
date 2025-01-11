                        <!-- Food Items Section -->
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">{{translate('Price')}} ({{getCurrencySymbol(getGeneralSettingsValue( 'default_currency' ))}})</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($food_items as $item)
                                        <tr class="single-food-item">
                                            <!-- Food Image -->
                                            <td class="text-center">
                                                <img src="/{{ getFilePath($item->image) }}" alt="item-image" class="img-fluid" style="max-width: 50px; max-height: 50px;">
                                            </td>

                                            <!-- Food Title -->
                                            <td>{{ $item->name }}</td>

                                            <!-- Price -->
                                            <td>
                                                <strong>{{setPriceFormat($item->price)}}</strong>
                                            </td>

                                            <!-- Quantity Selector -->
                                            <td>
                                                <div class="d-flex justify-content-center quantity-selector">
                                                    <button class="btn btn-sm btn-outline-pink btn-decrement" type="button"> - </button>
                                                    <input type="number" class="form-control quantity-input mx-2" min="1" value="1" style="width: 100px; text-align: center; height: 31px;" aria-label="Quantity">
                                                    <button class="btn btn-sm btn-outline-pink btn-increment" type="button">+</button>
                                                </div>
                                            </td>

                                            <!-- Action Button -->
                                            <td>
                                                @if($item->food_type == 'variant')
                                                <button type="button" class="btn btn-outline-pink btn-sm show-variant rounded-pill px-3" data-id="{{$item->id}}" data-name="{{$item->name}}" data-toggle="modal" data-target="#item-variant">{{ translate('Select Variant') }}</button>
                                                @else
                                                <button type="button" class="btn btn-outline-pink btn-sm add-to-cart rounded-pill px-3" data-id="{{$item->id}}" data-name="{{$item->name}}" data-price="{{$item->price}}">{{ translate('Place Order') }}</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>