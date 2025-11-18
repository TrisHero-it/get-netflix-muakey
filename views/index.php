<?php

use OTPHP\TOTP;

// Kiểm tra tài khoản đã hết hạn chưa
$isExpired = false;
if (!empty($account['expired_at'])) {
    try {
        $today = new DateTime('today');
        $expiredDate = new DateTime($account['expired_at']);
        if ($expiredDate < $today) {
            $isExpired = true;
        }
    } catch (\Exception $e) {
        // Nếu lỗi định dạng ngày thì bỏ qua kiểm tra hết hạn
        $isExpired = false;
    }
}

if (!$isExpired) {
    if ($account['code_2fa'] != null) {
        $period = 30; // mặc định là 30 giây
        $currentTime = time();
        $secondsRemaining = $period - ($currentTime % $period);
        $raw = $account['code_2fa'];
        $secret = strtoupper(str_replace(' ', '', $raw));
        $totp = TOTP::create($secret);
        $otp = $totp->now();
    } else {
        $otp = "Không có mã 2FA";
        $secondsRemaining = 9999999;
    }
}
?>

<?php if ($isExpired): ?>
    <div style="margin-top: 50px; text-align:center; ">
        Hết hạn
        <span style="color:red; font-weight:bold;">
            <?php if (!empty($account['expired_at'])): ?>
                <?php echo htmlspecialchars($account['expired_at']); ?>
            <?php endif; ?>
        </span>
        <br>
        Gia hạn hoặc mua tài khoản mới tại
        <a href="https://muakey.com/products/tai-khoan-netflix-premium" target="_blank" style="color:blue; font-weight:bold;">Muakey.com</a>
    </div>
    <img style="height: 400px;" src="background-image:
           url('css/images/capnhaphogiadinh.jpg')" alt="">

<?php else: ?>
    <?php if ($account['code_2fa'] == null) { ?>
        <div style="margin-top: 50px;">
        <?php } ?>
        <iframe id="iframe2fa" allow="clipboard-write" src="?act=index2&account=<?php echo urlencode(json_encode($account)) ?>" frameborder="0" width="100%" <?php if ($account['code_2fa'] != null) { ?> height="700" <?php } else { ?> height="600" <?php } ?>></iframe>

        <?php if ($account['code_2fa'] != null) { ?>
            <div class="text-center" style="margin-top: -15px; margin-bottom: 20px;">Mã 2FA sẽ được cập nhật sau <span id="timer" style="color: red;"><?php echo $secondsRemaining ?></span> giây</div>
        <?php } ?>

        <script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/buffer.js"></script>
        <script src="https://unpkg.com/@otplib/preset-browser@^12.0.0/index.js"></script>

        <script>
            let seconds = <?php echo $secondsRemaining ?>;
            const countdownEl = document.getElementById("timer");
            const secret = "<?php echo $secret ?>";

            const interval = setInterval(() => {
                seconds--;

                if (seconds == 0) {
                    const code2fa = window.otplib.authenticator.generate(secret);
                    document.getElementById("iframe2fa").contentWindow.document.getElementById("code2fa").value = code2fa;
                    seconds = 30;
                }

                countdownEl.innerHTML = `<span style='color: red;'>${seconds}</span>`;
            }, 1000);
        </script>
    <?php endif; ?>
    <!-- //code o day  -->
    <?php if (isset($guideTopics) && $guideTopics != null) { ?>
        <div class="main-content" <?php if ($account['category_id'] == 1) { ?> style="margin-top: 40px;" <?php } elseif ($account['code_2fa'] == null) {
                                                                                                            # code...
                                                                                                        } { ?> style="margin-top: -93px;" <?php } ?>>
            <div class="container" style="padding-bottom: 100px;">
                <div class="row">
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header border-0">
                                <h3 style="color: red;" class="mb-0">Các lỗi thường gặp !!</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Vấn đề</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($guideTopics as $guideTopic) { ?>
                                            <tr>
                                                <td><a href="<?php echo $guideTopic['link'] ?>"> <?php echo $guideTopic['title'] ?></a>
                                                </td>
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

        <!-- Modal -->
        <div class="modal fade" style="--bs-modal-width: unset;" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cách đăng nhập netflix bằng mật khẩu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img style="width: 100%;" src="css/images/hdnetflix.jpg" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            if (window.innerWidth > 768) {
                document.getElementById('modal-content').style.width = '80%';
                document.getElementById('modal-content').style.margin = '0 auto';
            }
            $(document).ready(function() {
                $('#exampleModal').modal('show');
            });
        </script>
    <?php
    }

    ?>