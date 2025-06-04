<?php

use OTPHP\TOTP;
?>

<div class="main-content">
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Tài khoản của bạn</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mật khẩu</th>
                                    <th scope="col">Mã 2fa</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Loại tài khoản</th>
                                </tr>
                            </thead>
                            <?php
                            if (isset($account) && $account != null) { ?>

                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-dot mr-4" style="color: black">
                                                    <?php echo $account['email'] ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-dot mr-4" style="color: black">
                                                    <?php echo $account['password'] ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-dot mr-4" style="color: black">
                                                    <?php
                                                    $raw = $account['code_2fa'];
                                                    $secret = strtoupper(str_replace(' ', '', $raw)); // "4NDNVBKT5HABZV3ITTEYAV7OHRH5MSK6"
                                                    $totp = TOTP::create($secret);
                                                    $otp = $totp->now();
                                                    echo "<span id='otp' style='color: green;'>" . $otp . "</span>";
                                                    ?>
                                                </span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-dot mr-4" id="countdown" style="color: black">
                                                    <?php
                                                    $period = 30; // mặc định là 30 giây
                                                    $currentTime = time();
                                                    $secondsRemaining = $period - ($currentTime % $period);
                                                    echo "Còn " . $secondsRemaining . " giây";
                                                    ?>
                                                </span>
                                            </div>

                                            <script>
                                                let seconds = <?= $secondsRemaining ?>;
                                                const countdownEl = document.getElementById("countdown");
                                                const otpEl = document.getElementById("otp");

                                                const interval = setInterval(() => {
                                                    seconds--;

                                                    if (seconds <= 0) {
                                                        countdownEl.innerHTML = "<span style='color: red;'>Load lại trang để lấy code mới</span>";
                                                        window.location.href = window.location.href;
                                                        clearInterval(interval);
                                                        return;
                                                    }

                                                    countdownEl.innerText = "Còn " + seconds + " giây";
                                                }, 1000);
                                            </script>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-dot mr-4" style="color: black">
                                                    <?php echo $account['user'] + 1 ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-dot mr-4" style="color: black">
                                                    <?php echo $account['name'] ?>
                                                </span>
                                    </tr>
                                </tbody>
                            <?php
                            } else { ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">Không tìm thấy tài khoản</td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>