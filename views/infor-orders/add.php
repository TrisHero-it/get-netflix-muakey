<head>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script> -->
</head>

<div class="container mt-5">
    <h3>
        Thêm thông tin đơn hàng
    </h3>
    <form action="?act=store-infor-orders" method="post" enctype="multipart/form-data">
        <div class="form-group  mt-3">
            <label for="email">Thông tin</label>
            <textarea name="infor-order" id="editor"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
    </form>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>