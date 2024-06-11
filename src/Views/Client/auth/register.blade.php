@extends('layouts.master')

@section('title')
Đăng kí
@endsection

@section('content')
<!-- SECTION -->
<div class="section">
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- Order Details -->
            <div class="col-md-5 order-details">
                <div class="section-title text-center">
                    <h3 class="title">Đăng kí</h3>
                </div>
                <div class="order-summary">
                    @if (isset($_SESSION['errors']) && $_SESSION['errors'])
                    <div class="alert alert-danger">{{ $_SESSION['errors'] }}</div>
                    @php
                    unset($_SESSION['errors']);
                    @endphp
                    @endif
                    <form action="{{ url('handle-register') }}" method="POST">
                        <div class="form-group">
                            <input class="input" type="name" name="name" placeholder="Họ tên">
                        </div>
                        <div class="form-group">
                            <input class="input" type="email" name="email" placeholder="Nhập mail">
                        </div>
                        <div class="form-group">
                            <input class="input" type="password" name="password" placeholder="Mật khẩu">
                        </div>
                        <button type="submit" class="primary-btn order-submit">Đăng Kí</button>
                    </form>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
</div>
<!-- /SECTION -->
@endsection