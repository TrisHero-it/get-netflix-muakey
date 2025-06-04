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
        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
    </form>
</div>