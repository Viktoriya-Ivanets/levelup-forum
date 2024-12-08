<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 d-flex justify-content-between">
                <div class="col-2">
                    <h1>Edit topic</h1>
                </div>
                <div class="col-10">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= \app\core\Router::url('categories') ?>">Categories</a></li>
                        <li class="breadcrumb-item"><a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics') ?>">Topics</a></li>
                        <li class="breadcrumb-item active">Edit topic</li>
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
                            <h3 class="card-title">Edit topic</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= \app\core\Router::url('categories/' . $categoryId . '/topics/update') ?>" method="post">
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $old['id'] ?>">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" value="<?= htmlspecialchars($old['title']) ?>" placeholder="Enter title of topic">
                                    <?php if (!empty($errors)): ?>
                                        <div class="text-danger mt-2"><?= htmlspecialchars($errors['title']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Enter short description..."><?= htmlspecialchars($old['description']) ?></textarea>
                                    <?php if (!empty($errors)): ?>
                                        <div class="text-danger mt-2"><?= htmlspecialchars($errors['description']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                                <a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics') ?>" class="btn btn-danger w-100 mt-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
