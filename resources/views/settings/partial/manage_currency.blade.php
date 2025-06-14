@php
  $currencies = getAllCurrencies();
  $default_currency = $data['default_currency'];
  $currency_position = $data['currency_position'];
  $thousands_separator = $data['thousands_separator'];
  $decimal_separator = $data['decimal_separator'];
  $decimal_position = $data['decimal_position'];
@endphp
<div class="card card-outline">
            <div class="card-header">
              <h3 class="card-title">{{translate('Manage Currencies')}}</h3>
            </div>
            <div class="card-body p-0">
            <form class="form-horizontal" id="manage_currency_form" action="{{route('manage.currency')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="defaultCurrency" class="col-sm-3 col-form-label">{{translate('Default Currency')}}</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="defaultCurrency" name="default_currency">
                        @foreach ($currencies as $currency)
                            <option value="{{$currency->id}}" {{$currency->id == $default_currency ? 'selected' : ''}}>{{$currency->currency_name}} ({{$currency->currency_code}}) ({{$currency->currency_symbol}})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="currencyPosition" class="col-sm-3 col-form-label">{{translate('Currency Position')}}</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="currencyPosition" name="currency_position">
                            <option value="left" {{$currency_position == 'left' ? 'selected' : ''}}>{{translate('Left')}}</option>
                            <option value="right" {{$currency_position == 'right' ? 'selected' : ''}}>{{translate('Right')}}</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="thousandsSeparator" class="col-sm-3 col-form-label">{{translate('Thousands Separator')}}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="thousandsSeparator" value="{{ $thousands_separator ??',' }}" name="thousands_separator">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="decimalSeparator" class="col-sm-3 col-form-label">{{translate('Decimal Separator')}}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="decimalSeparator" name="decimal_separator" value="{{ $decimal_separator ??'.' }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="decimalPosition" class="col-sm-3 col-form-label">{{translate('Decimal Position')}}</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="decimalPosition" name="decimal_position" value="{{ $decimal_position ??2 }}">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn bg-pink float-right">{{translate('Update')}}</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
          </div>
