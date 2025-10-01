<div class="mt-5" style="overflow-x: auto; margin: 0 15px">
    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo $_SESSION['success_message'];
            unset($_SESSION['success_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo $_SESSION['error_message'];
            unset($_SESSION['error_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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
    <!-- Bulk Actions -->
    <div class="mb-3">
        <button type="button" class="btn btn-danger" id="deleteSelectedBtn" disabled>
            <i class="fas fa-trash me-1"></i>Xóa đã chọn
        </button>
        <button type="button" class="btn btn-info" id="copySelectedBtn" disabled>
            <i class="fas fa-copy me-1"></i>Copy đã chọn
        </button>
        <button type="button" class="btn btn-outline-secondary" id="deselectAllBtn">
            <i class="fas fa-square me-1"></i>Bỏ chọn tất cả
        </button>
        <span class="text-muted ms-3" id="selectedCount">0 tài khoản đã chọn</span>
    </div>

    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col" class="text-center" style="width: 50px;">
                    <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                </th>
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
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input account-checkbox" value="<?php echo $account['id'] ?>">
                    </td>
                    <td><?php echo $account['shipments'] ?></td>
                    <?php if ($account2 != null) { ?>
                        <td><?php echo $account['email'] . "<br><span style='color: green'>" . $account2['email'] . "</span>" ?></td>
                    <?php } else { ?>
                        <td><?php echo $account['email'] ?></td>
                    <?php } ?>
                    <td><?php echo $account['password'] ?></td>
                    <td><?php echo $account['code_2fa'] ?></td>
                    <td>
                        <a href="<?php echo base_url . "/?id=" . $account['code'] ?>"
                            target="_blank"
                            class="account-link"
                            data-link="<?php echo base_url . "/?id=" . $account['code'] ?>">
                            <?php echo base_url . "/?id=" . $account['code'] ?>
                        </a>
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

<!-- JavaScript for bulk actions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const accountCheckboxes = document.querySelectorAll('.account-checkbox');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const copySelectedBtn = document.getElementById('copySelectedBtn');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const deselectAllBtn = document.getElementById('deselectAllBtn');
        const selectedCount = document.getElementById('selectedCount');

        // Function to update selected count
        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.account-checkbox:checked');
            const count = checkedBoxes.length;
            selectedCount.textContent = count + ' tài khoản đã chọn';
            deleteSelectedBtn.disabled = count === 0;
            copySelectedBtn.disabled = count === 0;
        }

        // Select all checkbox functionality
        selectAllCheckbox.addEventListener('change', function() {
            accountCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });

        // Individual checkbox functionality
        accountCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();

                // Update select all checkbox state
                const checkedBoxes = document.querySelectorAll('.account-checkbox:checked');
                if (checkedBoxes.length === 0) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = false;
                } else if (checkedBoxes.length === accountCheckboxes.length) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.indeterminate = true;
                }
            });
        });


        // Deselect all button
        deselectAllBtn.addEventListener('click', function() {
            accountCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
            updateSelectedCount();
        });

        // Copy selected button
        copySelectedBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.account-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Vui lòng chọn ít nhất một tài khoản để copy!');
                return;
            }

            // Collect selected account IDs
            const selectedIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);
            console.log('Selected IDs:', selectedIds);

            // Get all account links
            const allAccountLinks = document.querySelectorAll('.account-link');
            const selectedLinks = [];

            allAccountLinks.forEach(link => {
                const row = link.closest('tr');
                const checkbox = row.querySelector('.account-checkbox');
                if (checkbox && selectedIds.includes(checkbox.value)) {
                    const linkUrl = link.getAttribute('data-link') || link.href;
                    selectedLinks.push(linkUrl);
                    console.log('Found link:', linkUrl);
                }
            });

            console.log('Selected links:', selectedLinks);

            if (selectedLinks.length === 0) {
                alert('Không tìm thấy link nào để copy!');
                return;
            }

            // Join links with newlines
            const linksText = selectedLinks.join('\n');
            console.log('Text to copy:', linksText);

            // Try modern clipboard API first
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(linksText).then(function() {
                    // Success
                    const originalText = copySelectedBtn.innerHTML;
                    copySelectedBtn.innerHTML = '<i class="fas fa-check me-1"></i>Đã copy!';
                    copySelectedBtn.classList.remove('btn-info');
                    copySelectedBtn.classList.add('btn-success');

                    setTimeout(() => {
                        copySelectedBtn.innerHTML = originalText;
                        copySelectedBtn.classList.remove('btn-success');
                        copySelectedBtn.classList.add('btn-info');
                    }, 2000);

                    showNotification(`Đã copy ${selectedLinks.length} link vào clipboard!`, 'success');
                }).catch(function(err) {
                    console.error('Clipboard API failed:', err);
                    fallbackCopy(linksText, selectedLinks.length);
                });
            } else {
                // Fallback for older browsers or non-secure contexts
                fallbackCopy(linksText, selectedLinks.length);
            }
        });

        // Fallback copy function
        function fallbackCopy(text, count) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    const originalText = copySelectedBtn.innerHTML;
                    copySelectedBtn.innerHTML = '<i class="fas fa-check me-1"></i>Đã copy!';
                    copySelectedBtn.classList.remove('btn-info');
                    copySelectedBtn.classList.add('btn-success');

                    setTimeout(() => {
                        copySelectedBtn.innerHTML = originalText;
                        copySelectedBtn.classList.remove('btn-success');
                        copySelectedBtn.classList.add('btn-info');
                    }, 2000);

                    showNotification(`Đã copy ${count} link vào clipboard!`, 'success');
                } else {
                    throw new Error('execCommand failed');
                }
            } catch (err) {
                console.error('Fallback copy failed:', err);
                showNotification('Không thể copy vào clipboard. Vui lòng thử lại!', 'error');

                // Show text in a modal as last resort
                showTextModal(text, count);
            }

            document.body.removeChild(textArea);
        }

        // Show text in modal as last resort
        function showTextModal(text, count) {
            const modal = document.createElement('div');
            modal.className = 'modal fade show';
            modal.style.display = 'block';
            modal.innerHTML = `
                 <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title">Copy ${count} link (${count} links)</h5>
                             <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                         </div>
                         <div class="modal-body">
                             <p>Không thể copy tự động. Vui lòng chọn và copy text bên dưới:</p>
                             <textarea class="form-control" rows="10" readonly>${text}</textarea>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-primary" onclick="this.closest('.modal').querySelector('textarea').select(); document.execCommand('copy'); showNotification('Đã copy!', 'success');">Copy</button>
                             <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').remove()">Đóng</button>
                         </div>
                     </div>
                 </div>
             `;
            document.body.appendChild(modal);
        }

        // Delete selected button
        deleteSelectedBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.account-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Vui lòng chọn ít nhất một tài khoản để xóa!');
                return;
            }

            const confirmMessage = `Bạn có chắc chắn muốn xóa ${checkedBoxes.length} tài khoản đã chọn không?\n\nHành động này không thể hoàn tác!`;

            if (confirm(confirmMessage)) {
                // Collect selected IDs
                const selectedIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);

                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '?act=bulk-delete';

                // Add CSRF token if needed
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = 'csrf_token';
                csrfInput.value = '<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>';
                form.appendChild(csrfInput);

                // Add selected IDs
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }
        });

        // Initialize count
        updateSelectedCount();
    });

    // Notification function
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => notification.remove());

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `custom-notification alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        notification.style.cssText = `
             position: fixed;
             top: 20px;
             right: 20px;
             z-index: 9999;
             min-width: 300px;
             box-shadow: 0 4px 12px rgba(0,0,0,0.15);
         `;

        notification.innerHTML = `
             <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
             ${message}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }
</script>