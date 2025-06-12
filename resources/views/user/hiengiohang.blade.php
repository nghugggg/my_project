@extends('user.layout')



@section('noidung')
        <!-- Shop Cart Section Begin -->
        <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cart = session('cart', []);
                                @endphp
                                @foreach($cart as $index => $item)
                                    <tr>
                                        <td class="cart__product__item">
                                            <img src="{{asset('/uploads/product/'.$item->sanpham->hinh)}}" alt="" style="height: 100px">
                                            <div class="cart__product__item__title">
                                                <h6>{{ $item -> ten_sp }}</h6>
                                            </div>
                                        </td>
                                        <td class="cart__price">{{number_format($item->sanpham->gia_km , 0, ',' , '.' )}} VNĐ</td>
                                        <td class="cart__quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="{{$item->so_luong}}">
                                            </div>
                                        </td>
                                        <td class="cart__total">{{number_format($item->so_luong * $item->sanpham->gia_km , 0, ',' , '.' )}} VNĐ</td>
                                        <td class="cart__close"><a href="" class="icon_close fs-3" style="color: black; text-decoration: none;"></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="#">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="xoatatca"><span class="icon_loading"></span> Xóa hết </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">Apply</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span>0</span></li>
                            <li>Total <span>0</span></li>
                        </ul>
                        <a href="#" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->
@endsection