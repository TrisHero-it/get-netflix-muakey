<div class="container mt-5">
    <h3>
        Thêm hướng dẫn
    </h3>
    <form action="?act=store-category" method="post" enctype="multipart/form-data">
        <div class="form-group  mt-3">
            <label for="title">Tiêu đề</label>
            <input type="name" class="form-control" id="title" name="title" placeholder="Nhập title">
        </div>
        <div class="form-group  mt-3">
            <label for="content">Nội dung</label>
            <input type="name" class="form-control" id="content" name="content" placeholder="Nhập content">
        </div>
        <div class="form-group  mt-3">
            <label for="category_id">Danh mục</label>
            <select class="form-control" id="category_id" name="category_id">
                <?php
                foreach ($categories as $category) {
                ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
    </form>
</div>