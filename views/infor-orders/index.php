<div class="mt-5" style="overflow-x: auto; margin: 0 15px">
    <div class="d-flex justify-content-between">
        <h3>
            Danh sách thông tin đơn hàng
        </h3>

    </div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">Thông tin</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inforOrders as $inforOrder) : ?>
                <tr>
                    <td>
                        <a id="infor-order-<?php echo $inforOrder['id']; ?>" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $inforOrder['id']; ?>">Xem</a>
                    </td>
                    <td>
                        <a href="?act=edit-infor-order&id=<?php echo $inforOrder['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thông tin đơn hàng này không?')" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal<?php echo $inforOrder['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thông tin đơn hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php $order = json_decode($inforOrder['json'], true);
                                $keys = array_keys($order);
                                ?>
                                <?php foreach ($keys as $key) : ?>
                                    <div class="d-flex"> <span>
                                            <?php echo $key; ?></span>&nbsp;: &nbsp;<span><?php echo $order[$key]; ?>
                                            &nbsp;
                                            <span class="badge bg-secondary" style="cursor: pointer;" onclick="copyToClipboard('<?php echo $order[$key]; ?>')">copy</span></span> </div>
                                <?php endforeach; ?>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-danger">Xoá</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        function copyToClipboard(text) {
            const textarea = document.createElement("textarea");
            textarea.value = text;
            textarea.style.position = "fixed";
            textarea.style.opacity = 0;
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();

            try {
                const success = document.execCommand('copy');
                alert(success ? 'Đã copy!' : 'Không thể copy');
            } catch (err) {
                alert('Lỗi copy: ' + err);
            }

            document.body.removeChild(textarea);
        }
    </script>

</div>