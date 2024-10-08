@php
$default_lang = getGeneralSettingsValue('default_lang');
$placeholder = getPlaceholderImagePath();
@endphp
<div class="card card-outline">
            <div class="card-header">
              <h3 class="card-title">{{translate('Placeholder Image')}}</h3>
            </div>
            <div class="card-body p-0">
            <form class="form-horizontal" id="manage_placeholder_form" action="{{route('set.placeholder.image')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-9">
                    <input type="hidden" name="placeholder_image" id="placeholder-image-input">
                                <div class="row" id="placeholder-image-view">
                                    <div class="form-image-container col-2 m-2">
                                        <div class="image-wrapper">
                                            <img src="{{asset($placeholder)}}" class="img-fluid" alt="black sample">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn text-blue browse-file" data-toggle="modal" data-target="#media-library" data-inputid="placeholder-image-input" data-imagecontainerid="placeholder-image-view" data-isformultiselect='0'>{{translate('Browse File')}}</button>
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
          @includeIf('media.include.media_modal')