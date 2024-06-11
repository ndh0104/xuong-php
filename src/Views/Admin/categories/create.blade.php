@extends('layouts.master')

@section('title')
Thêm mới danh mục
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h3 class="m-0">Thêm mới danh mục</h3>
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
                <form action="{{ url('admin/categories/store') }}" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="inputHoten3" class="form-label col-sm-4 col-form-label">Tên danh mục</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputHoten3" placeholder="Name" name="name">
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