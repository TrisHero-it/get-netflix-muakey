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
            position: relative;
        }

        .copy-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            position: relative;
        }

        .copy-icon::before,
        .copy-icon::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 14px;
            border: 1px solid #333;
            background: white;
            border-radius: 2px;
        }

        .copy-icon::before {
            top: 0;
            left: 0;
            z-index: 2;
        }

        .copy-icon::after {
            top: 2px;
            left: 2px;
            z-index: 1;
            background: #f0f0f0;
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
    <h1>Thông tin tài khoản</h1>
    <div class="code hidden" style="position: relative; cursor: pointer;">
        <div class="timer recovery_email" title="Email khôi phục" style="width: 105px;">Hồ sơ</div>
        <input class="copy-value" style="cursor: pointer;" id="user" placeholder="" value="<?php echo $account['user'] ?>" readonly>
    </div>
    <?php if ($account['pin_code'] != null) { ?>
        <div class="code" style="position: relative; cursor: pointer;" onclick="copyToClipboard('code', this)">
            <div class="timer" title="Mã 2FA" style="width: 105px;">Mã Pin</div>
            <input class="copy-value" style="cursor: pointer;" id="code" placeholder="" value="<?php echo $account['pin_code'] ?>" readonly>
            <span class="copy-icon" style="position: absolute; right: 20px; top: 16px; width: 10px; height: 10px;"></span>
        </div>
    <?php } ?>
    <div class="code hidden" style="position: relative; cursor: pointer;" onclick="copyToClipboard('emailInput', this)">
        <div class="timer email" title="Email" style="width: 105px;">Email</div>
        <input class="copy-value" style="cursor: pointer;" id="emailInput" placeholder="" value="<?php echo $account['email'] ?>" readonly>
        <span class="copy-icon" style="position: absolute; right: 20px; top: 16px; width: 10px; height: 10px;"></span>
    </div>
    <div class="code hidden" style="position: relative; cursor: pointer;" onclick="copyToClipboard('passInput', this)">
        <div class="timer pass" title="Pass" style="width: 105px;">Pass</div>
        <input class="copy-value" style="cursor: pointer;" id="passInput" placeholder="" value="<?php echo $account['password'] ?>" readonly>
        <span class="copy-icon" style="position: absolute; right: 20px; top: 16px; width: 10px; height: 10px;"></span>
    </div>
    <div class="code hidden" style="position: relative; cursor: pointer;">
        <div class="timer pass" title="Loại tài khoản" style="width: 105px;">Loại</div>
        <input class="copy-value" style="cursor: pointer;" id="category_name" placeholder="" value="<?php echo $account['name'] ?>" readonly>
    </div>
    <?php
    if ($account['code_2fa'] != null) {
    ?> <div class="" style="color:rgb(45, 185, 78);" title="Mã 2FA">Mã Authenticator / Mã 1 lần</div>

        <div class="code" style="position: relative; cursor: pointer; height: 50px;" onclick="copyToClipboard('code2fa', this)">
            <input class="text-red copy-value" style="cursor: pointer;" id="code2fa" placeholder="" value="<?php echo $_GET['otp'] ?>" readonly>
            <span class="copy-icon" style="position: absolute; right: 20px; top: 15px; width: 10px; height: 10px;"></span>
        </div>
    <?php } ?>

    </div>
    <script>
        function showNotification(message, type = 'success') {
            console.log('showNotification called:', message, type); // Debug log

            // Tạo container nếu chưa có
            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                container.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                `;
                document.body.appendChild(container);
            }

            // Tạo toast element
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.style.cssText = `
                min-width: 250px;
                margin-bottom: 10px;
                padding: 15px 20px;
                border-radius: 4px;
                color: white;
                font-family: 'Arial', sans-serif;
                display: flex;
                align-items: center;
                justify-content: space-between;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                opacity: 1;
                transform: translateX(0);
                transition: all 0.3s ease-out;
            `;

            // Áp dụng màu sắc theo type
            if (type === 'success') {
                toast.style.backgroundColor = '#d4edda';
                toast.style.color = '#155724';
                toast.style.border = '1px solid #c3e6cb';
            } else if (type === 'error') {
                toast.style.backgroundColor = '#f8d7da';
                toast.style.color = '#721c24';
                toast.style.border = '1px solid #f5c6cb';
            }

            // Tạo nội dung toast
            const messageDiv = document.createElement('div');
            messageDiv.className = 'toast-message';
            messageDiv.textContent = message;
            messageDiv.style.marginRight = '10px';
            messageDiv.style.flex = '1';

            const closeBtn = document.createElement('button');
            closeBtn.className = 'toast-close';
            closeBtn.innerHTML = '&times;';
            closeBtn.style.cssText = `
                background: none;
                border: none;
                color: inherit;
                font-size: 18px;
                cursor: pointer;
                opacity: 0.8;
                padding: 0;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            `;
            closeBtn.onclick = () => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            };

            toast.appendChild(messageDiv);
            toast.appendChild(closeBtn);
            container.appendChild(toast);

            // Animation slide in
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            }, 10);

            // Tự động xóa sau 4 giây
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.remove();
                        }
                    }, 300);
                }
            }, 4000);
        }

        function copyToClipboard(id, btn) {
            const text = document.getElementById(id).value;

            // Kiểm tra Clipboard API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    if (window.innerWidth <= 768) {
                        alert("Đã copy: " + text);
                    } else {
                        showNotification(`Đã copy ${text} vào clipboard!`, 'success');
                    }
                }).catch(err => {
                    console.error("Lỗi sao chép:", err);
                    showNotification("Không thể sao chép.", 'error');
                });
            } else {
                // Fallback cho trình duyệt cũ
                const temp = document.createElement("textarea");
                temp.value = text;
                document.body.appendChild(temp);
                temp.select();
                document.execCommand("copy");
                document.body.removeChild(temp);
                if (window.innerWidth <= 600) {
                    alert("Đã copy: " + text);
                } else {
                    showNotification(`Đã copy ${text} vào clipboard!`, 'success');
                }
            }
        }
    </script>
</body>

</html>