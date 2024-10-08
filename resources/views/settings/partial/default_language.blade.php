@php
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
@endphp
<div class="card card-outline">
            <div class="card-header">
              <h3 class="card-title">{{translate('Default Language')}}</h3>
            </div>
            <div class="card-body p-0">
            <form class="form-horizontal" id="manage_language_form" action="{{route('set.default.language')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="defaultLanguage" class="col-sm-3 col-form-label">{{translate('Default Language')}}</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="defaultLanguage" name="default_lang">
                        @foreach ($languages as $language)
                            <option value="{{$language->id}}" {{$language->id == $default_lang ? 'selected' : ''}}>{{$language->name}}</option>
                        @endforeach
                      </select>
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