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
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Token_2fa</th>
                <th scope="col">Link</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($accounts as $account) {
            ?>
                <tr>
                    <td><?php echo $account['email'] ?></td>
                    <td><?php echo $account['password'] ?></td>
                    <td><?php echo $account['code_2fa'] ?></td>
                    <td>
                        <a href="<?php echo base_url . "/?id=" . $account['code'] ?>" target="_blank"><?php echo base_url . "/?id=" . $account['code'] ?></a>
                    </td>
                    <?php
                    foreach ($categories as $category) {
                        if ($category['id'] == $account['category_id']) {
                            echo "<td>" . $category['name'] . "</td>";
                        }
                    }
                    ?> 
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