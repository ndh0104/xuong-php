@extends('layouts.master')

@section('title')
Thêm mới sản phẩm
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h3 class="m-0">Thêm mới sản phẩm</h3>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                @if (!empty($_SESSION['errors']))
                <div class="alert alert-warning">
                    <ul>
                        @foreach ($_SESSION['errors'] as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    @php
                    unset($_SESSION['errors']);
                    @endphp
                </div>
                @endif
                <form action="{{ url('admin/products/store') }}" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="inputMuc" class="form-label col-sm-4 col-form-label">Mục</label>
                        <div class="col-sm-8">
                            <select name="category_id" class="form-select mb-3" fdprocessedid="m0ti7f">
                                @foreach ($categoryPluck as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputTensp3" class="form-label col-sm-4 col-form-label">Tên sản phẩm</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputTensp3" placeholder="Tên sản phẩm" name="name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputGiagoc" class="form-label col-sm-4 col-form-label">Giá gốc</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputGiagoc" placeholder="Giá gốc" name="price_regular">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputGiasale" class="form-label col-sm-4 col-form-label">Giá Sale</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputGiasale" placeholder="Có thể bỏ trống" name="price_sale">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputFile3" class="form-label col-sm-4 col-form-label">Ảnh sản phẩm</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="inputFile3" placeholder="Email" name="img_thumbnail">
                            <!-- <img src="{{ asset($user['avatar']) }}" alt="" width="100px"> -->

                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputContent" class="form-label col-sm-4 col-form-label">Content</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="inputContent" placeholder="Content" name="content"></textarea>
                        </div>
                    </div>
                    <div class=" row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection