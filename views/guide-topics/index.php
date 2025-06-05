<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <h3>
            Danh sách hướng dẫn
        </h3>
        <div class="d-flex" justify-content-between>
            <a href="?act=add-guide-topic" class="btn btn-primary">Thêm hướng dẫn</a>
        </div>
    </div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Đường dẫn</th>
                <th scope="col">Danh mục</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($guideTopics as $guideTopic) {
            ?>
                <tr>
                    <td><?php echo $guideTopic['id'] ?></td>
                    <td><?php echo $guideTopic['title'] ?></td>
                    <td><?php echo $guideTopic['link'] ?></td>
                    <td><?php echo $guideTopic['name'] ?></td>
                    <td>
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa hướng dẫn này không?')" href="?act=delete-guide-topic&id=<?php echo $guideTopic['id'] ?>&category_id=<?php echo $guideTopic['category_id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>