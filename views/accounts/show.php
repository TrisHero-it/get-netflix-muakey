<div class="main-content">
    <div class="container mt-5">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Tài khoản gốc</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Code 2FA</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Thể loại</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Mã pin</th>
                                    <th scope="col">Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $account['email'] ?></td>
                                    <td><?php echo $account['password'] ?></td>
                                    <td><span style="color: green"> <?php echo $account['code_2fa'] ?? 'Không có mã 2FA' ?></span></td>
                                    <td><?php echo $account['code'] ?></td>
                                    <td><?php echo $account['category_id'] ?></td>
                                    <td><?php echo $account['user'] ?></td>
                                    <td><?php echo $account['pin_code'] ?></td>
                                    <td><?php echo $account['created_at'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="container mt-5">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Tài khoản thay thế</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Code 2FA</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Thể loại</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Mã pin</th>
                                    <th scope="col">Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($account2 as $item) { ?>
                                    <tr>
                                        <td><?php echo $item['email'] ?></td>
                                        <td><?php echo $item['password'] ?></td>
                                        <td><span style="color: green"><?php echo $item['code_2fa'] == '' ? 'Không có mã 2FA' : $item['code_2fa'] ?></span></td>
                                        <td><?php echo $item['code'] ?></td>
                                        <td><?php echo $item['category_id'] ?></td>
                                        <td><?php echo $item['user'] ?></td>
                                        <td><?php echo $item['pin_code'] ?></td>
                                        <td><?php echo $item['created_at'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>