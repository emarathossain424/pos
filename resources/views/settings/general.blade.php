@php
    $settings = request()->query('settings', 'manage_currency');
@endphp
@extends('layouts.master')
@section('title') {{translate('General Settings')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">{{translate('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{translate('General Settings')}}</li>
</ol>
@endsection
@section('content')
    <section class="content">
      <div class="row p-2">
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{translate('General Settings')}}</h3>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="?settings=manage_currency" class="nav-link @if($settings == 'manage_currency') active @endif">
                    <i class="fas fa-dollar-sign"></i> {{translate('Manage Currencies')}}
                  </a>
                </li>
                <li class="nav-item active">
                  <a href="?settings=default_language" class="nav-link @if($settings == 'default_language') active @endif">
                    <i class="fas fa-language"></i> {{translate('Default Language')}}
                  </a>
                </li>
                <li class="nav-item active">
                  <a href="?settings=placeholder" class="nav-link @if($settings == 'placeholder') active @endif">
                    <i class="fas fa-image"></i> {{translate('Placeholder Image')}}
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          @if($settings == 'manage_currency')
           @include('settings.partial.manage_currency')
          @endif
          @if($settings == 'default_language')
           @include('settings.partial.default_language')
          @endif
          @if($settings == 'placeholder')
           @include('settings.partial.placeholder')
          @endif
        </div>
      </div>
    </section>
@endsection

@push('script')
<script src="{{asset('pos/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function() {
        'use strict'

        $('#defaultLanguage').select2({
            theme: 'bootstrap4'
        })

        $('#defaultCurrency').select2({
            theme: 'bootstrap4'
        })

        $('#currencyPosition').select2({
            theme: 'bootstrap4'
        })
    });
</script>
@endpush