<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 d-flex justify-content-between">
                <div class="col-3">
                    <h1>Edit message</h1>
                </div>
                <div class="col-9">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= \app\core\Router::url('categories') ?>">Categories</a></li>
                        <li class="breadcrumb-item">
                            <a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics') ?>">Topics</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics/' . $topicId . '/messages') ?>">Messages</a>
                        </li>
                        <li class="breadcrumb-item active">Edit message</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit message</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= \app\core\Router::url('categories/' . $categoryId . '/topics/' . $topicId . '/messages/update') ?>" method="post">
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $old['id'] ?>">
                                <div class="form-group">
                                    <label>Text</label>
                                    <textarea class="form-control" name="text" rows="3" placeholder="Enter text of message here..."><?= htmlspecialchars($old['text']) ?></textarea>
                                    <?php if (!empty($errors)): ?>
                                        <div class="text-danger mt-2"><?= htmlspecialchars($errors['text']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                                <a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics/' . $topicId . '/messages') ?>" class="btn btn-danger w-100 mt-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
