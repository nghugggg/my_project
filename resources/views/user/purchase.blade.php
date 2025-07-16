@extends('user.layout')
@section('noidung')
<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center "
                        data-bs-toggle="collapse" href="#accountSubmenu" role="button" aria-expanded="false" aria-controls="accountSubmenu">
                        <span>Tài khoản</span>
                    </a>
                    <div class="collapse" id="accountSubmenu">
                        <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action ps-5">
                            Hồ sơ
                        </a>
                        <a href="{{ route('account.password_page') }}" class="list-group-item list-group-item-action ps-5">
                            Đổi mật khẩu
                        </a>
                    </div>

                    <a href="{{ route('user.purchase') }}" class="list-group-item list-group-item-action">
                        <i class="fa-solid fa-box me-2"></i> Đơn mua
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4">Đơn hàng của bạn</h4>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4" id="orderTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                                type="button" role="tab">Chờ xác nhận</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                                type="button" role="tab">Vận chuyển</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="delivering-tab" data-bs-toggle="tab" data-bs-target="#delivering"
                                type="button" role="tab">Chờ giao hàng</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
                                type="button" role="tab">Hoàn thành</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled"
                                type="button" role="tab">Đã hủy</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="orderTabContent">
                        <div class="tab-pane fade show active" id="pending" role="tabpanel">
                            <!-- <p>Đơn hàng đang chờ xác nhận.</p> -->
                            {{-- @foreach ($orders as $order)
                            @if($order->trang_thai == 0)
                                Hiển thị đơn hàng ở đây
                            @endif
                        @endforeach --}}
                            @foreach($pending_order as $order)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                    <div>
                                        <strong>Đơn hàng #{{ $order->id }}</strong> -
                                        <span class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <span class="badge bg-{{$order->trang_thai}}">
                                        {{$order->trang_thai}}
                                    </span>
                                </div>

                                <div class="card-body">
                                    {{-- Danh sách sản phẩm --}}
                                    @foreach($order->ChiTietDonHangs as $item)
                                    <div class="d-flex border-bottom pb-3 mb-3">
                                        <img src="{{ asset('/uploads/product/' . $item->sanPham->hinh) }}" alt="" width="80" class="me-3 rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item->sanPham->ten_sp }}</h6>
                                            <small>Size: {{ $item->size->size_product }}</small><br>
                                            <small>Số lượng: {{ $item->so_luong }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-danger fw-bold">
                                                {{ number_format($item->gia * $item->so_luong, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach

                                    {{-- Thông tin đơn hàng --}}
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> {{ $order->pttt }}</p>
                                            <!-- @if ($order->uu_dai)
                                            <p class="mb-1"><strong>Ưu đãi:</strong> {{ number_format($order->uu_dai, 0, ',', '.') }} VNĐ</p>
                                            @endif -->
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-1 fw-bold">Tổng tiền: {{ number_format($order->tong_dh, 0, ',', '.') }} VNĐ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                            <!-- <p>Đơn hàng đang được vận chuyển.</p> -->
                             @foreach($shipping_order as $order)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                    <div>
                                        <strong>Đơn hàng #{{ $order->id }}</strong> -
                                        <span class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <span class="badge bg-{{$order->trang_thai}}">
                                        {{$order->trang_thai}}
                                    </span>
                                </div>

                                <div class="card-body">
                                    {{-- Danh sách sản phẩm --}}
                                    @foreach($order->ChiTietDonHangs as $item)
                                    <div class="d-flex border-bottom pb-3 mb-3">
                                        <img src="{{ asset('/uploads/product/' . $item->sanPham->hinh) }}" alt="" width="80" class="me-3 rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item->sanPham->ten_sp }}</h6>
                                            <small>Size: {{ $item->size->size_product }}</small><br>
                                            <small>Số lượng: {{ $item->so_luong }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-danger fw-bold">
                                                {{ number_format($item->gia * $item->so_luong, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach

                                    {{-- Thông tin đơn hàng --}}
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> {{ $order->pttt }}</p>
                                            <!-- @if ($order->uu_dai)
                                            <p class="mb-1"><strong>Ưu đãi:</strong> {{ number_format($order->uu_dai, 0, ',', '.') }} VNĐ</p>
                                            @endif -->
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-1 fw-bold">Tổng tiền: {{ number_format($order->tong_dh, 0, ',', '.') }} VNĐ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="delivering" role="tabpanel">
                            <!-- <p>Đơn hàng đã đến nơi, đang chờ giao.</p> -->
                             @foreach($delivering_order as $order)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                    <div>
                                        <strong>Đơn hàng #{{ $order->id }}</strong> -
                                        <span class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <span class="badge bg-{{$order->trang_thai}}">
                                        {{$order->trang_thai}}
                                    </span>
                                </div>

                                <div class="card-body">
                                    {{-- Danh sách sản phẩm --}}
                                    @foreach($order->ChiTietDonHangs as $item)
                                    <div class="d-flex border-bottom pb-3 mb-3">
                                        <img src="{{ asset('/uploads/product/' . $item->sanPham->hinh) }}" alt="" width="80" class="me-3 rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item->sanPham->ten_sp }}</h6>
                                            <small>Size: {{ $item->size->size_product }}</small><br>
                                            <small>Số lượng: {{ $item->so_luong }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-danger fw-bold">
                                                {{ number_format($item->gia * $item->so_luong, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach

                                    {{-- Thông tin đơn hàng --}}
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> {{ $order->pttt }}</p>
                                            <!-- @if ($order->uu_dai)
                                            <p class="mb-1"><strong>Ưu đãi:</strong> {{ number_format($order->uu_dai, 0, ',', '.') }} VNĐ</p>
                                            @endif -->
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-1 fw-bold">Tổng tiền: {{ number_format($order->tong_dh, 0, ',', '.') }} VNĐ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="completed" role="tabpanel">
                            <!-- <p>Đơn hàng đã hoàn thành.</p> -->
                             @foreach($completed_order as $order)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                    <div>
                                        <strong>Đơn hàng #{{ $order->id }}</strong> -
                                        <span class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <span class="badge bg-{{$order->trang_thai}}">
                                        {{$order->trang_thai}}
                                    </span>
                                </div>

                                <div class="card-body">
                                    {{-- Danh sách sản phẩm --}}
                                    @foreach($order->ChiTietDonHangs as $item)
                                    <div class="d-flex border-bottom pb-3 mb-3">
                                        <img src="{{ asset('/uploads/product/' . $item->sanPham->hinh) }}" alt="" width="80" class="me-3 rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item->sanPham->ten_sp }}</h6>
                                            <small>Size: {{ $item->size->size_product }}</small><br>
                                            <small>Số lượng: {{ $item->so_luong }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-danger fw-bold">
                                                {{ number_format($item->gia * $item->so_luong, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach

                                    {{-- Thông tin đơn hàng --}}
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> {{ $order->pttt }}</p>
                                            <!-- @if ($order->uu_dai)
                                            <p class="mb-1"><strong>Ưu đãi:</strong> {{ number_format($order->uu_dai, 0, ',', '.') }} VNĐ</p>
                                            @endif -->
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-1 fw-bold">Tổng tiền: {{ number_format($order->tong_dh, 0, ',', '.') }} VNĐ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="cancelled" role="tabpanel">
                            <!-- <p>Đơn hàng đã bị hủy.</p> -->
                             @foreach($canceled_order as $order)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                    <div>
                                        <strong>Đơn hàng #{{ $order->id }}</strong> -
                                        <span class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <span class="badge bg-{{$order->trang_thai}}">
                                        {{$order->trang_thai}}
                                    </span>
                                </div>

                                <div class="card-body">
                                    {{-- Danh sách sản phẩm --}}
                                    @foreach($order->ChiTietDonHangs as $item)
                                    <div class="d-flex border-bottom pb-3 mb-3">
                                        <img src="{{ asset('/uploads/product/' . $item->sanPham->hinh) }}" alt="" width="80" class="me-3 rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item->sanPham->ten_sp }}</h6>
                                            <small>Size: {{ $item->size->size_product }}</small><br>
                                            <small>Số lượng: {{ $item->so_luong }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-danger fw-bold">
                                                {{ number_format($item->gia * $item->so_luong, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach

                                    {{-- Thông tin đơn hàng --}}
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> {{ $order->pttt }}</p>
                                            <!-- @if ($order->uu_dai)
                                            <p class="mb-1"><strong>Ưu đãi:</strong> {{ number_format($order->uu_dai, 0, ',', '.') }} VNĐ</p>
                                            @endif -->
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-1 fw-bold">Tổng tiền: {{ number_format($order->tong_dh, 0, ',', '.') }} VNĐ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Cart Section End -->
<script>
    function toggleSubmenu(el) {
        let submenu = el.querySelector('.submenu');
        let isVisible = submenu.style.display === 'block';

        // Ẩn tất cả các submenu khác
        document.querySelectorAll('.submenu').forEach(s => s.style.display = 'none');

        // Hiển thị submenu nếu chưa mở
        submenu.style.display = isVisible ? 'none' : 'block';
    }
</script>
@endsection