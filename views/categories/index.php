    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h3>
                Danh sách tài khoản
            </h3>
            <div class="d-flex" justify-content-between>
                <a href="?act=list" class="btn btn-success">Danh sách tài khoản</a>
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
                    <th scope="col">Hướng dẫn</th>
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
                        <td><a href="?act=guide-topics&id=<?php echo $category['id'] ?>">Xem danh sách</a></td>
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" href="#" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>