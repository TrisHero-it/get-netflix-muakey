    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h3>
                Danh sách tài khoản
            </h3>
            <div class="d-flex" justify-content-between>
                <a href="?act=add" class="btn btn-primary">Thêm tài khoản</a>
                <a href="?act=add-category" class="btn btn-warning">Thêm danh mục</a>
                <a href="?act=export" class="btn btn-secondary text-light">Xuất file</a>
            </div>
        </div>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên danh mục</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categories as $category) {
                ?>
                    <tr>
                        <td><?php echo $category['id'] ?></td>
                        <td><?php echo $category['name'] ?></td>
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')" href="?act=delete&id=<?php echo $account['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>