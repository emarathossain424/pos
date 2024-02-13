@extends('layouts.master')
@section('title') Plugins @endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="m-0">{{ translate('Plugins') }}</h5>
                        <div class="ml-auto">
                            <button class="btn btn-primary">Create</button>
                            <button class="btn btn-primary">Install</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($plugins as $plugin)
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header text-center bg-gradient-pink">
                                        <h3>{{$plugin->name}}</h3>
                                        <span class="badge badge-light">{{translate('Free')}}</span>
                                    </div>
                                    <div class="card-body">
                                        <span class="text-gray">{{$plugin->details}}</span>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <span class="text-gray"><strong>By :</strong> {{$plugin->owner}}</span>
                                        <span class="text-gray"><strong>Version :</strong> {{$plugin->version}}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection