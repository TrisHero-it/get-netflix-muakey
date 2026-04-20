<div class="container mt-5">
    <h3>
        Thêm tài khoản
    </h3>
    <form action="?act=store" method="post" enctype="multipart/form-data">
        <div class="form-group  mt-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
        </div>
        <div class="form-group  mt-3">
            <label for="password">Password</label>
            <input type="text" class="form-control" id="password" name="password" placeholder="Nhập password">
        </div>
        <div class="form-group  mt-3">
            <label for="code_2fa">Code 2FA</label>
            <input type="text" class="form-control" id="code_2fa" name="code_2fa" placeholder="Nhập code 2FA">
        </div>
        <div class="form-group  mt-3">
            <label for="user">Thứ tự user</label>
            <input type="text" class="form-control" id="user" name="user" placeholder="Nhập số lượng user" value="1">
        </div>
        <div class="form-group  mt-3">
            <label for="pin">Mã pin hồ sơ</label>
            <input type="number" min="0" class="form-control" id="pin" name="pin" placeholder="Nhập mã PIN">
        </div>

        <div class="form-group mt-3">
            <label for="expired_at_days">Hết hạn sau (ngày)</label>
            <input type="number" min="0" class="form-control" id="expired_at_days" name="expired_at_days" value="30"
                placeholder="Nhập số ngày, ví dụ 30 sẽ cộng thêm 30 ngày">
            <input type="hidden" id="expired_at" name="expired_at">
        </div>

        <div class="form-group  mt-3">
            <label for="category_id">Thể loại</label>
            <select class="form-control" id="category_id" name="category_id">
                <?php
                foreach ($categories as $category) {
                ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="excel_file">File Excel</label>
            <input class="form-control" type="file" name="excel_file" accept=".xlsx, .xls">
        </div>

        <a href="?act=exportFormAddAccount" class="btn btn-primary mt-3">Lấy form excel</a>

        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
    </form>
</div>

<script>
    // Tính expired_at dựa trên số ngày nhập
    (function() {
        const daysInput = document.getElementById('expired_at_days');
        const expiredInput = document.getElementById('expired_at');
        const categorySelect = document.getElementById('category_id');

        function updateExpiredAt() {
            const categoryId = parseInt(categorySelect.value || '0', 10);
            if (categoryId !== 1) {
                expiredInput.value = '';
                return;
            }

            const days = parseInt(daysInput.value || '0', 10);
            const now = new Date();
            now.setDate(now.getDate() + (isNaN(days) ? 0 : days));
            const yyyy = now.getFullYear();
            const mm = String(now.getMonth() + 1).padStart(2, '0');
            const dd = String(now.getDate()).padStart(2, '0');
            expiredInput.value = `${yyyy}-${mm}-${dd}`;
        }

        // Khởi tạo khi load
        updateExpiredAt();

        // Cập nhật khi người dùng đổi số ngày
        daysInput.addEventListener('input', updateExpiredAt);
        categorySelect.addEventListener('change', updateExpiredAt);
    })();
</script>
