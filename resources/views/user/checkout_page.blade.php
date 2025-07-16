@extends('user.layout')
@section('noidung')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i>Trang chủ</a>
                    <span>Thanh toán</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <!-- Modal chọn địa chỉ -->
    <div class="modal fade" id="changeAddressModal" tabindex="-1" aria-labelledby="changeAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form class="modal-content" id="addressSelectForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeAddressModalLabel">Chọn địa chỉ nhận hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach($addressUser as $info)
                    <div class="form-check border rounded p-3 mb-2">
                        <input class="form-check-input" type="radio" name="selectedAddress" id="address-{{ $info->id }}" value="{{ $info->id }}"
                            {{ ($defaultAddress && $defaultAddress->id == $info->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="address-{{ $info->id }}">
                            <strong>{{ $info->ho_ten }}</strong><br>
                            {{ $info->phone }}<br>
                            {{ $info->dc_chi_tiet }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="confirm-address">Xác nhận</button>
                </div>
            </form>
            <script>
                //Xác nhận chọn địa chỉ
                $('#confirm-address').on('click', function(e) {
                    e.preventDefault();

                    const form = $('#addressSelectForm');
                    const formData = form.serialize();

                    $.ajax({
                        url: "{{ route('checkout.change_address') }}",
                        method: "POST",
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                //Reload lại trang hoặc chuyển về trang thanh toán
                                window.location.href = "{{ route('checkout.checkout_page') }}";
                            }
                        },
                        error: function(xhr) {
                            alert("Xảy ra lỗi khi cập nhật địa chỉ");
                            console.error(xhr.responseText);
                        }
                    });
                });
            </script>
        </div>
    </div>
    <!-- Modal thêm địa chỉ -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('add_address') }}" class="modal-content" id="addressForm" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Nhập họ tên">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input name="phone_number" type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea name="detail_address" class="form-control" id="address" rows="3" placeholder="Nhập địa chỉ chi tiết"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save-address">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </form>
            <script>
                //Tránh bị double click submit
                const form = document.getElementById('addressForm');
                const button = document.getElementById('save-address');

                form.addEventListener('submit', function () {
                    button.disabled = true;
                    button.innerText = "Đang lưu...";
                });
            </script>
            <!-- Kiểm tra nếu chưa có addressUser thì hiện modal add địa chỉ -->
            @if($addressUser->isEmpty())
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var addModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
                        addModal.show();
                    });
                </script>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Địa chỉ nhận hàng</h5>
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                + Thêm địa chỉ
            </button>
        </div>
        <!-- Thông tin địa chỉ -->
        <div class="d-flex justify-content-between align-items-start border p-3 rounded bg-light mb-5">
            @if($defaultAddress)
            <div id="selected-address">
                <p class="mb-1"><strong>{{ $defaultAddress->ho_ten }} {{ $defaultAddress->phone }}</strong></p>
                <p class="mb-0">{{ $defaultAddress->dc_chi_tiet }}</p>
                <!-- <input type="hidden" name="selected-address-id" id="selected-address-id" value="{{ $defaultAddress->id }}"> -->
            </div>
            <div>
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#changeAddressModal">
                    Thay đổi
                </button>
            </div>
            @endif
        </div>
        <!-- Form đặt hàng -->
        <form action="{{ route('order.order') }}" class="checkout__form" method="post">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="address_id" id="address_id" value="{{ $defaultAddress ? $defaultAddress->id : '' }}">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <div class="shop__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                @foreach($cart as $item)
                                <tbody>
                                    <tr>
                                        <td class="cart__product__item">
                                            <input type="hidden" name="selected-products[]" id="selected-product" value="{{ $item->id }}">
                                            <img src="{{asset('/uploads/product/'.$item->sanpham->hinh)}}" alt="" style="height: 100px">
                                            <div class="cart__product__item__title">
                                                <h6>{{ $item->sanpham->ten_sp }}</h6>
                                                <span>Size: {{ $item->size->size_product }}</span>
                                            </div>
                                        </td>
                                        <td class="cart__price">{{number_format($item->sanpham->gia_km > 0 ? $item->sanpham->gia_km : $item->sanpham->gia , 0, ',' , '.' )}} VNĐ</td>
                                        <td class="cart__quantity">
                                            <div class="pro-qty">
                                                <input readonly name="quantity" id="quantity-{{ $item->id }}" type="text" value="{{ $item->so_luong }}">
                                            </div>
                                        </td>
                                        <td class="cart__total">{{number_format($item->so_luong * $item->sanpham->gia_km , 0, ',' , '.' )}} VNĐ</td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card p-4 shadow-sm mb-5">
                        <h5 class="mb-3 fw-bold">Phương thức thanh toán</h5>
                        <div class="payment-methods">
                            <label class="me-3" for="COD">
                                <input name="payment-opt" value="COD" type="radio" id="COD">
                                Thanh toán khi nhận hàng
                            </label>
                            <label for="VNPAY">
                                <input name="payment-opt" value="VNPAY" type="radio" id="VNPAY">
                                Thanh toán VNPAY
                            </label>
                            <input type="hidden" name="payment-method" id="payment-method">
                        </div>
                    </div>
                </div>
                <script>
                    //Hàm chọn phương thức thanh toán
                    document.querySelectorAll('input[name="payment-opt"]').forEach(function (radio) {
                        radio.addEventListener('change', function () {
                            // Gán giá trị phương thức thanh toán vào input hidden
                            document.getElementById('payment-method').value = this.value;
                        });
                    });
                </script>
                <div class="col-lg-12">
                    <div class="card p-4 shadow-sm">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tổng tiền hàng</span>
                                <strong>{{ number_format($totalAmount , 0, ',' , '.') }} VNĐ</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Phí vận chuyển</span>
                                <strong>0 VNĐ</strong>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold">Tổng thanh toán</h5>
                            <h5 class="text-danger fw-bold">{{ number_format($totalAmount , 0, ',' , '.') }}VNĐ</h5>
                            <input name="total-payment" id="total-payment" type="hidden" value="{{$totalAmount}}">
                        </div>

                        <button type="submit" class="btn btn-danger w-100">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Checkout Section End -->
@include('/partials/add-address-modal')
@endsection
<!-- @push('scripts')
    <script src="{{ asset('js/xuly_diachi.js') }}"></script>
@endpush -->
