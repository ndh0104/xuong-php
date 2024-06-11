@extends('layouts.master')

@section('title')
Cập nhật người dùng {{ $user['name'] }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h3 class="m-0">Cập nhật người dùng: {{ $user['name'] }}</h3>
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
                @if (isset($_SESSION['status']) && $_SESSION['status'])
                <div class="alert alert-success">{{ $_SESSION['msg'] }}</div>

                @php
                unset($_SESSION['status']);
                unset($_SESSION['msg']);
                @endphp
                @endif
                <form action="{{ url("admin/users/{$user['id']}/update") }}" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="inputHoten3" class="form-label col-sm-4 col-form-label">Họ tên</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputHoten3" placeholder="Name" value="{{$user['name']}}" name="name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputFile3" class="form-label col-sm-4 col-form-label">Avatar</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="inputFile3" placeholder="Email" name="avatar">
                            <img src="{{ asset($user['avatar']) }}" alt="" width="100px">

                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputEmail3" class="form-label col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email" value="{{$user['email']}}" name="email">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword3" class="form-label col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputEmail3" class="form-label col-sm-4 col-form-label">Quyền</label>
                        <div class="col-sm-8">
                            <select name="type" class="form-select mb-3" fdprocessedid="m0ti7f">
                                <option value="">--- Choose type ---</option>
                                <option {{ $user['type'] == $_ENV['TYPE_MEMBER'] ? 'selected' : '' }} value="{{ $_ENV['TYPE_MEMBER'] }}">Member</option>
                                <option {{ $user['type'] == $_ENV['TYPE_ADMIN'] ? 'selected' : '' }} value="{{ $_ENV['TYPE_ADMIN'] }}">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputEmail3" class="form-label col-sm-4 col-form-label">Trạng thái</label>
                        <div class="col-sm-8">
                            <select name="is_active" class="form-select mb-3" fdprocessedid="m0ti7f">
                                <option value="">--- Choose is_active ---</option>
                                <option {{ !$user['is_active'] ? 'selected' : '' }} value="0">
                                    Không kích hoạt</option>
                                <option {{ $user['is_active'] ? 'selected' : '' }} value="1">Kích
                                    hoạt
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class=" row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection