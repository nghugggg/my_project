@extends('user.layout')
@section('noidung')
<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <form action="{{ route('checkout.checkout_page') }}" method="POST" id="checkout-form">
        @csrf
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Số tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cart = session('cart', []);
                            @endphp
                            @foreach($cart as $item)
                            <tr>
                                <td class="cart_check">
                                    <!-- lưu dữ liệu giá và số lượng vào data-attribute -->
                                    @if ($item->status === 0)
                                    <input type="checkbox" name="selected_products[]"
                                        class="form-check-input product-checkbox" value="{{ $item->id }}"
                                        data-price="{{ $item->sanpham->gia_km > 0 ? $item->sanpham->gia_km : $item->sanpham->gia }}"
                                        data-quantity="{{ $item->so_luong }}"
                                        onclick="calculateTotal()">
                                    @endif
                                </td>
                                <td class="cart__product__item">
                                    <img src="{{asset('/uploads/product/'.$item->sanpham->hinh)}}" alt="" style="height: 100px">
                                    <div class="cart__product__item__title">
                                        <h6>{{ $item ->sanpham-> ten_sp }}</h6>
                                        <span>Size: {{ $item ->size -> size_product }}</span>
                                    </div>
                                </td>
                                <td class="cart__price">{{number_format($item->sanpham->gia_km , 0, ',' , '.' )}} VNĐ</td>
                                <td class="cart__quantity">
                                    <div class="pro-qty">
                                        <!-- Nút tăng -->
                                        <span class="dec qtybtn" onclick="updateQuantity({{ $item->id }}, -1)">-</span>
                                        <!-- Input số lượng -->
                                        <input readonly name="quantity" id="quantity-{{ $item -> id }}" type="text" value="{{$item->so_luong}}">
                                        <!-- Nút giảm -->
                                        <span class="inc qtybtn" onclick="updateQuantity({{ $item->id }}, 1)">+</span>
                                    </div>
                                </td>
                                <td class="cart__total">{{number_format($item->so_luong * $item->sanpham->gia_km , 0, ',' , '.' )}} VNĐ</td>
                                <td class="cart__close"><a href="{{ route('cart.remove', $item->id) }}" class="icon_close fs-3" style="color: black; text-decoration: none;"></a></td>
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
                    <a href="/">Tiếp tục mua sắm</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn update__btn">
                    <a href="{{ route('cart.remove_all') }}"><span class="icon_loading"></span> Xóa hết </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="discount__content">
                    <h6>Mã giảm giá</h6>
                    <form action="#">
                        <input type="text" placeholder="Nhập mã của bạn">
                        <button type="submit" class="site-btn">Áp dụng</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="cart__total__procced">
                    <h6>Tổng giỏ hàng</h6>
                    <ul>
                        <li id="cart-summary-line">
                            Tổng cộng (0 sản phẩm): <span id="total-amount">0 VNĐ</span>
                        </li>
                    </ul>
                    <button type="submit" class="primary-btn w-100">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</section>
<!-- Shop Cart Section End -->
@endsection
<script>
    // Hàm tính tổng tiền từ các sản phẩm đã chọn
    function calculateTotal() {
        let totalAmount = 0;
        let totalQuantity = 0;

        const productCheckboxes = document.querySelectorAll('.product-checkbox');

        productCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                totalAmount += price * quantity;
                totalQuantity += 1; //mỗi dòng checkbox thì tính là 1 sản phẩm
            }
        });

        const formattedTotalAmount = new Intl.NumberFormat('vi-VN', {
            style: 'decimal'
        }).format(totalAmount);

        // Cập nhật lại dòng tổng cộng của giỏ hàng
        const summaryLine = document.getElementById('cart-summary-line');
        summaryLine.innerHTML = `Tổng cộng (${totalQuantity} sản phẩm): <span id="total-amount">${formattedTotalAmount} VNĐ</span>`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();

        // Khi checkbox thay đổi cũng cập nhật lại tổng tiền
        document.querySelectorAll('.product-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                calculateTotal();
            });
        });
    });

    // Hàm cập nhật số lượng sản phẩm và tổng tiền
    function updateQuantity(itemId, change) {
        const qtyInput = document.getElementById(`quantity-${itemId}`);
        let currentQty = parseInt(qtyInput.value);
        let newQty = currentQty + change;

        if (newQty < 1) {
            newQty = 1;
        }
        qtyInput.value = newQty;

        const checkbox = document.querySelector(`.product-checkbox[value="${itemId}"]`);
        if (checkbox) {
            const unitPrice = parseFloat(checkbox.dataset.price);
            const newSubtotal = unitPrice * newQty;

            // Cập nhật số tiền của dòng sản phẩm
            const cartRow = qtyInput.closest('tr');
            if (cartRow) {
                const totalCell = cartRow.querySelector('.cart__total');
                if (totalCell) {
                    totalCell.textContent = newSubtotal.toLocaleString('vi-VN') + ' VNĐ';
                }
            }
            // Cập nhật lại data-quantity của checkbox
            checkbox.dataset.quantity = newQty;
        }

        // Gửi ajax cập nhật
        fetch(`/update-quantity/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                quantity: newQty
            })
        })
            .then(response => {
                if (!response.ok) {
                    qtyInput.value = currentQty;
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Có lỗi xảy ra khi cập nhật số lượng.');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Gọi lại calculateTotal sau khi cập nhật thành công
                calculateTotal();
            })
            .catch(error => {
                alert(error.message);
            });
    }
</script> 