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
        </div>
    </div>