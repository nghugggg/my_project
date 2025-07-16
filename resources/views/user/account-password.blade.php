@extends('user.layout')
@section('noidung')
<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#accountSubmenu" role="button" aria-expanded="false" aria-controls="accountSubmenu">
                        <span>Tài khoản</span>
                        <!-- <i class="fa-solid fa-chevron-down small"></i> -->
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

            <!-- Content -->
            <div class="col-md-9">
                    <div class="card shadow-sm p-4">
                            <h3 class="mb-3">Thay Đổi Mật Khẩu</h3>
                            <p>Thay đổi mật khẩu thường xuyên để tăng độ bảo mật cho tài khoản của bạn</p><hr>
                        <form action="{{ route('account.change_password') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-danger w-100">Cập nhật mật khẩu</button>
                        </form>
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