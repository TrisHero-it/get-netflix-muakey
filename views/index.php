<?php

use OTPHP\TOTP;

if ($account['code_2fa'] != null) {
    $period = 30; // mặc định là 30 giây
    $currentTime = time();
    $secondsRemaining = $period - ($currentTime % $period);
    $raw = $account['code_2fa'];
    $secret = strtoupper(str_replace(' ', '', $raw)); // "4NDNVBKT5HABZV3ITTEYAV7OHRH5MSK6"
    $totp = TOTP::create($secret);
    $otp = $totp->now();
} else {
    $otp = "Không có mã 2FA";
    $secondsRemaining = 9999999;
}
?>

<iframe allow="clipboard-write" src="?act=index2&account=<?php echo urlencode(json_encode($account)) ?>&otp=<?php echo $otp ?>" frameborder="0" width="100%" height="700"></iframe>

<?php if ($account['code_2fa'] != null) { ?>
    <div class="text-center" style="margin-top: -25px; margin-bottom: 10px;">Mã 2FA sẽ được cập nhật sau <span id="timer"><?php echo $secondsRemaining ?></span> giây</div>
<?php } ?>
<script>
    let seconds = <?php echo $secondsRemaining ?>;
    const countdownEl = document.getElementById("timer");

    const interval = setInterval(() => {
        seconds--;

        if (seconds <= 0) {
            // countdownEl.innerHTML = "<span style='color: red;'>Load lại trang để lấy code mới</span>";
            window.location.reload();
            clearInterval(interval);
            return;
        }

        countdownEl.innerText = seconds;
    }, 1000);
</script>
<?php if (isset($guideTopics) && $guideTopics != null) { ?>
    <div class="main-content">
        <div class="container" style="padding-bottom: 100px;">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <h3 class="mb-0">Hướng dẫn sử dụng</h3>
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
<?php
}


?>