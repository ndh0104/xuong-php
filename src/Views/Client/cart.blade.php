@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('content')
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        @if (!empty($_SESSION['cart']) || !empty($_SESSION['cart-' . $_SESSION['user']['id']]))
        <div class="row">
            <table class="col-md-8">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá tiền</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                    $cart = $_SESSION['cart'] ?? $_SESSION['cart-' . $_SESSION['user']['id']];
                    @endphp
                    @foreach ($cart as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <img src="{{ asset($item['img_thumbnail']) }}" width="100px" alt="">
                        </td>
                        <td>
                            @php
                            $url = url('cart/quantityDec') . '?productID=' . $item['id'];

                            if (isset($_SESSION['cart-' . $_SESSION['user']['id']])) {
                            $url .= '&cartID=' . $_SESSION['cart_id'];
                            }
                            @endphp
                            <a class="btn btn-danger" href="{{ $url }}">Giảm</a>

                            {{ $item['quantity'] }}

                            @php
                            $url = url('cart/quantityInc') . '?productID=' . $item['id'];

                            if (isset($_SESSION['cart-' . $_SESSION['user']['id']])) {
                            $url .= '&cartID=' . $_SESSION['cart_id'];
                            }
                            @endphp
                            <a class="btn btn-primary" href="{{ $url }}">Tăng</a>
                        </td>
                        <td>
                            {{ $item['price_sale'] ?: $item['price_regular'] }}
                        </td>
                        <td>
                            {{ $item['quantity'] * ($item['price_sale'] ?: $item['price_regular']) }}
                        </td>
                        <td>
                            @php
                            $url = url('cart/remove') . '?productID=' . $item['id'];

                            if (isset($_SESSION['cart-' . $_SESSION['user']['id']])) {
                            $url .= '&cartID=' . $_SESSION['cart_id'];
                            }
                            @endphp
                            <a onclick="return confirm('Có chắn không?')" href="{{ $url }}">Xóa</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="col-md-4">
                <!-- Billing Details -->
                <div class="billing-details">
                    <form action="{{ url('order/checkout') }}" method="POST">
                        <div class="section-title">
                            <h3 class="title">Thông tin người nhận</h3>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" value="{{ $_SESSION['user']['name'] ?? null }}" name="user_name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input class="input" type="email" value="{{ $_SESSION['user']['email'] ?? null }}" placeholder="Enter email" name="user_email">
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" value="{{ $_SESSION['user']['phone'] ?? null }}" placeholder="Enter phone" name="user_phone">
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" value="{{ $_SESSION['user']['address'] ?? null }}" placeholder="Enter address" name="user_address">
                        </div>
                        <button type="submit" class="primary-btn order-submit">Đặt hàng</button>
                    </form>
                </div>
            </div>
        </div>


        @endif
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
@endsection