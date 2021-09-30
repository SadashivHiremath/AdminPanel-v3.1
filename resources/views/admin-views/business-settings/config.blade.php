@extends('layouts.admin.app')

@section('title', trans('messages.third_party_apis'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{__('messages.third_party_apis')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
        @php($map_api_key=\App\Models\BusinessSetting::where(['key'=>'map_api_key'])->first())
        @php($map_api_key=$map_api_key?$map_api_key->value:null)
        
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.config-update'):'javascript:'}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label class="input-label" style="padding-left: 10px">{{__('messages.map_api_key')}}</label>
                                <input type="text" placeholder="Map api key" class="form-control" name="map_api_key"
                                    value="{{env('APP_MODE')!='demo'?$map_api_key??'':''}}" required>
                            </div>
                        </div>
                    </div>

                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{__('messages.save')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush
