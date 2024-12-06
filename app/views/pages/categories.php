<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 d-flex justify-content-between">
                <h1 class="col-2">Categories</h1>
                <div class="col-10">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row mb-3">
                <div class="col-2">
                    <a href="<?= \app\core\Router::url('categories/create') ?>" class="btn btn-primary">Add category</a>
                </div>
            </div>
            <div class="row">
                <?php foreach ($categories as $category): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="col-12 p-0">
                            <div class="small-box bg-primary">
                                <div class="inner p-3">
                                    <h3><?= htmlspecialchars($category['title']); ?></h3>
                                    <p><?= htmlspecialchars($category['description']); ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-list"></i>
                                </div>
                                <div class="small-box-footer p-2 d-flex justify-content-center">
                                    <a href="#" class="text-white">See topics <i class="fas fa-arrow-circle-right ml-2"></i></a>
                                    <?php if ($category['user_id'] === $user['id']): ?>
                                        <a href="<?= app\core\Router::url('categories/edit/' . $category['id']) ?>" class="text-white ml-3">Edit <i class="fas fa-pencil ml-2"></i></a>
                                        <a href="<?= app\core\Router::url('categories/delete/' . $category['id']) ?>" class="text-white ml-3">Delete <i class="fas fa-trash ml-2"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($category['id'] % 2 === 0): ?>
            </div>
            <div class="row">
            <?php endif; ?>
        <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
