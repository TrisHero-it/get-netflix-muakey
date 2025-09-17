<div class="mt-5" style="overflow-x: auto; margin: 0 15px">
    <div class="d-flex justify-content-between">
        <h3>
            Danh sách tài khoản
        </h3>
        <div class="d-flex" justify-content-between>
            <a href="?act=list" class="btn btn-secondary">Trang chủ</a>
            <form method="get" style="margin-right: 32px;" id="formSearch">
                <input type="hidden" name="act" value="list">
                <input type="text" class="form-control" style="margin-right: 8px; height: 29px;" placeholder="Email, 2fa, link" value="<?php if (isset($_GET['search'])) {
                                                                                                                                            echo '' . $_GET['search'] . '';
                                                                                                                                        } ?>" name="search">
            </form>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Thay thế tài khoản
            </button>

            <a href="?act=categories" class="btn btn-success">Danh sách danh mục</a>
            <a href="?act=add" class="btn btn-primary">Thêm tài khoản</a>
            <a href="?act=add-category" class="btn btn-warning">Thêm danh mục</a>
            <a data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn btn-secondary text-light">Xuất file</a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thay thế tài khoản</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="?act=replace" method="post">
                            <input type="text" name="old_email" class="form-control mt-2" placeholder="Email cũ" style="width: 438px;">
                            <input type="text" name="new_email" class="form-control mt-2" placeholder="Email mới" style="width: 438px;">
                            <input type="text" name="new_password" class="form-control mt-2" placeholder="Mật khẩu mới" style="width: 438px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary mt-2">Thay thế</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?act=export" method="post">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Vui lòng điền lô hàng</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="number" name="shipments" class="form-control" placeholder="Nhập lô hàng" style="width: 438px;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Xuất file</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">Lô hàng</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Token_2fa</th>
                <th scope="col">Link</th>
                <th scope="col">Thể loại</th>
                <th scope="col">User</th>
                <th scope="col">Mã pin</th>
                <th scope="col">Thời gian</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($accounts as $account) {
                $AccountModel = new Account();
                $account2 = $AccountModel->getLastestAccountReplaceByAccountId($account['id']);
            ?>
                <tr>
                    <td><?php echo $account['shipments'] ?></td>
                    <?php if ($account2 != null) { ?>
                        <td><?php echo $account['email'] . "<br><span style='color: green'>" . $account2['email'] . "</span>" ?></td>
                    <?php } else { ?>
                        <td><?php echo $account['email'] ?></td>
                    <?php } ?>
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
                    <td><?php echo $account['user'] ?></td>
                    <td><?php echo $account['pin_code'] ?? 'Không có' ?></td>
                    <td><?php echo $account['created_at'] ?></td>
                    <td>
                        <a href="?act=show&id=<?php echo $account['id'] ?>" class="btn btn-info">Show</a>
                        <a href="?act=edit&id=<?php echo $account['id'] ?>" class="btn btn-warning">Edit</a>
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')" href="?act=delete&id=<?php echo $account['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    if (!isset($_GET['search'])) {


    ?>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($currentPage > 3) {
                ?> <li class="page-item"><a class="page-link" href="?act=list&page=1">1</a></li>

                <?php
                    echo '<li class="page-item"><a class="page-link" href=""> . . .</a></li>';
                } ?>
                <?php
                for ($i = max(1, $currentPage - $range); $i <= min($totalAccounts['total'] - 1, $currentPage + $range); $i++) {
                    if ($i == $currentPage) {
                        echo '<li class="page-item active"><a class="page-link" href="?act=list&page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?act=list&page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                ?>
                <?php
                if ($currentPage + $range < $totalAccounts['total'] - 1) {
                    echo '<li class="page-item"><a class="page-link" href=""> . . .</a></li>';
                }

                // Hiện trang cuối (nếu không trùng)
                if ($currentPage != $totalAccounts['total']) {
                    echo '<li class="page-item"><a class="page-link" href="?act=list&page=' . $totalAccounts['total'] . '">' . $totalAccounts['total'] . '</a></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link active" href="?act=list&page=' . $totalAccounts['total'] . '">' . $totalAccounts['total'] . '</a></li>';
                }
                ?>
            </ul>
        </nav>

    <?php
    }
    ?>

</div>