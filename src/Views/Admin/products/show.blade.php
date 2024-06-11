@extends('layouts.master')

@section('title')
Chi tiết người dùng: {{ $product['name'] }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h1 class="m-0">Chi tiết người dùng: {{ $product['name'] }}</h1>
                    </div>
                </div>
            </div>
            <div class="white_card_body">

                <a class="btn btn-primary" href="{{ url('admin/products') }}">Trở về</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Trường</th>
                                <th>Giá trị</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($product as $field => $value)
                            <tr>
                                <td>{{ $field }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection