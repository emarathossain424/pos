@php
$languages = getAllLanguages();
$default_lang = getGeneralSettingsValue('default_lang');
$translatedLang = isset(request()->lang)?request()->lang:$default_lang;

$all_branches = getBranches();
@endphp
@extends('layouts.master')
@section('title') {{translate('Halls')}} @endsection
@push('css')
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('pos/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

<style>
    .fixed-image {
        height: 150px; /* Set the fixed height */
        background-color: #f5f5f5; /* Optional background color */
    }

    .fixed-image img {
        object-fit: cover; /* Ensure the image covers the container */
        width: 100%; /* Fill the container width */
        height: 100%; /* Fill the container height */
    }


</style>

@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <x-alert column="col-md-12" alert_type="alert-warning" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('pos')}}" method="get">
                            <div class="row d-flex">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control select2 w-100" name="branch" id="branchSelect">
                                            <option value="">{{translate('All Branches')}}</option>
                                            @foreach($all_branches as $branch)
                                            <option value="{{$branch->id}}" {{ request()->get('branch') == $branch->id ? 'selected' : '' }}>{{$branch->branch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="category" id="categorySelect">
                                            <option value="">{{translate('All Categories')}}</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{ request()->get('category') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="search" placeholder="{{translate('Search')}}" value="{{ request()->get('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary sm">{{translate('Filter')}}</button>
                                    <a class="btn btn-danger sm" href="{{route('pos')}}">{{translate('Clear')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Food Items Section -->
                        <div class="row">
                            @foreach($food_items as $item)
                            <div class="col-md-6 col-lg-4 col-xl-4 mb-4">
                                <div class="card single-food-item h-100 shadow-sm border-0 rounded-lg p-3">
                                    <!-- Food Image with fixed size -->
                                    <div class="food-img-container fixed-image rounded-lg overflow-hidden mb-3">
                                        <img src="/{{ getFilePath($item->image) }}" class="food-img-top img-fluid w-100 h-100 object-cover" alt="{{ $item->name }}">
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-0 d-flex flex-column">
                                        <!-- Food Title and Description -->
                                        <h5 class="food-title mb-2 font-weight-bold">{{ $item->name }}</h5>

                                        <!-- Price and Sold Info -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <strong class="text-primary">${{ number_format($item->price, 2) }}</strong>
                                                @if($item->offer_price)
                                                <small class="text-danger d-block"><strike>${{ number_format($item->offer_price, 2) }}</strike></small>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $item->sold ?? 0 }} Sold</small>
                                        </div>

                                        <!-- Quantity Selector & Add to Cart Button -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if($item->food_type == 'variant')
                                                <button type="button" class="btn btn-sm btn-outline-primary">{{translate('Select Variant')}}</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-primary">{{translate('Place Order')}}</button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-outline-primary">{{translate('Add Property')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{ $food_items->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="place-order-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{translate('Add Properties')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="row">
                    <div class="col-md-3">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item active">
                                <button class="btn btn-outline-pink w-100">
                                    <i class="fas fa-dollar-sign"></i> {{translate('Manage Currencies')}}
                                </button>
                            </li>
                            <li class="nav-item active mt-1">
                                <button class="btn btn-outline-pink w-100">
                                    <i class="fas fa-language"></i> {{translate('Default Language')}}
                                </button>
                            </li>
                            <li class="nav-item active mt-1">
                                <button class="btn btn-outline-pink w-100">
                                    <i class="fas fa-image"></i> {{translate('Placeholder Image')}}
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

</div>
@endsection

@push('script')
<script>
    $(function() {
        'use strict'
        $('body').addClass('sidebar-collapse');
    });
</script>
@endpush