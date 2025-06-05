<!DOCTYPE html>
<html>
<!-- Mirrored from divineshop.vn/2fa?id=g1udavmb5uc by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Jun 2025 02:51:52 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lấy Mã 2FA</title>
    <style>
        html,
        * {
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 768px;
            height: 100vh;
            margin: auto;
            padding: 1em;
            text-align: center;
            gap: 1em;
        }

        .code {
            display: flex;
            max-width: 550px;
            width: 100%;
            border: 2px solid lightgray;
            border-radius: 0.25em;
            font-size: large;
        }

        .copy {
            min-width: 103px;
        }

        .code> :first-child {
            border-top-left-radius: 0.15em;
            border-bottom-left-radius: 0.15em;
        }

        .code> :last-child {
            border-top-right-radius: 0.15em;
            border-bottom-right-radius: 0.15em;
        }

        input,
        button,
        .timer {
            font-size: inherit;
            border: 0;
            border-radius: 0;
            padding: 0.75em;
            text-align: center;
        }

        .timer {
            max-width: 9em;
            width: 100%;
            background-color: #f7f7f7;
        }

        #timer {
            pointer-events: none;
            user-select: none;
        }

        .text-left {
            text-align: left;
        }

        .text-red {
            color: red;
        }

        input {
            font-size: medium;
            min-width: 5em;
            width: 100%;
            font-weight: bold;
            padding: 0 0.75em;
            z-index: 1;
        }

        button {
            flex-shrink: 0;
            cursor: pointer;
        }

        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            min-width: 250px;
            margin-bottom: 10px;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            animation: slide-in 0.3s ease-out forwards, fade-out 0.5s ease-out 3s forwards;
            opacity: 0;
            transform: translateX(100%);
        }

        .toast-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            border-radius: .25rem;
        }

        .toast-error {
            color: #721c24;
            background-color: #f8d7da;
            border-radius: .25rem;
            border-color: #f5c6cb;
        }

        .toast-message {
            margin-right: 5px;
        }

        .toast-close {
            background: none;
            border: none;
            color: #1b1e21;
            font-size: 16px;
            cursor: pointer;
            opacity: 0.8;
        }

        .toast-close:hover {
            opacity: 1;
        }

        @keyframes slide-in {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fade-out {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <?php
    $accountJson = $_GET['account'] ?? '';
    $account = json_decode($accountJson, true);
    ?>
    <img style="border-radius: 100px;" src="../css/logo/muakey.png" width="100">
    <h1>Lấy Mã 2FA</h1>
    <div class="code hidden">
        <div class="timer recovery_email" title="Email khôi phục">Hồ sơ</div>
        <input class="copy-value" id="user" placeholder="" value="<?php echo $account['user'] ?>" readonly>
        <button class="copy" type="button" onclick="copyToClipboard('user', this)">Sao chép</button>
    </div>
    <?php if ($account['pin_code'] != null) { ?>
        <div class="code">
            <div class="timer" title="Mã 2FA">Mã Pin</div>
            <input class="copy-value" id="code" placeholder="" value="<?php echo $account['pin_code'] ?>" readonly>
            <button class="copy" type="button" onclick="copyToClipboard('code', this)">Sao chép</button>
        </div>
    <?php } ?>
    <div class="code hidden">
        <div class="timer email" title="Email">Email</div>
        <input class="copy-value" id="emailInput" placeholder="" value="<?php echo $account['email'] ?>" readonly>
        <button class="copy" type="button" onclick="copyToClipboard('emailInput', this)">Sao chép</button>
    </div>
    <div class="code hidden">
        <div class="timer pass" title="Pass">Pass</div>
        <input class="copy-value" id="passInput" placeholder="" value="<?php echo $account['password'] ?>" readonly>
        <button class="copy" type="button" onclick="copyToClipboard('passInput', this)">Sao chép</button>
    </div>
    <div class="code hidden">
        <div class="timer pass" title="Loại tài khoản">Loại tài khoản</div>
        <input class="copy-value" id="category_name" placeholder="" value="<?php echo $account['name'] ?>" readonly>
        <button class="copy" type="button" onclick="copyToClipboard('category_name', this)">Sao chép</button>
    </div>
    <?php
    if ($account['code_2fa'] != null) {
    ?>
        <div class="code">
            <div class="timer" title="Mã 2FA">Mã 2FA</div>
            <input class="text-red copy-value" id="code2fa" placeholder="" value="<?php echo $_GET['otp'] ?>" readonly>
            <button class="copy" type="button" onclick="copyToClipboard('code2fa', this)">Sao chép</button>
        </div>
    <?php } ?>

    </div>
    <script>
        function copyToClipboard(id, btn) {
            const text = document.getElementById(id).value;

            // Kiểm tra Clipboard API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    btn.innerHTML = "✓";
                    setTimeout(() => {
                        btn.innerHTML = "Sao chép";
                    }, 3000);
                }).catch(err => {
                    console.error("Lỗi sao chép:", err);
                    alert("Không thể sao chép.");
                });
            } else {
                // Fallback cho trình duyệt cũ
                const temp = document.createElement("textarea");
                temp.value = text;
                document.body.appendChild(temp);
                temp.select();
                document.execCommand("copy");
                document.body.removeChild(temp);
                btn.innerHTML = "✓";
                setTimeout(() => {
                    btn.innerHTML = "Sao chép";
                }, 3000);
            }
        }
    </script>
</body>

</html>