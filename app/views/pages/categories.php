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
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="small-box bg-primary">
                                <div class="inner p-3">
                                    <h3><?= htmlspecialchars($category['title']); ?></h3>
                                    <p><?= htmlspecialchars($category['description']); ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-list"></i>
                                </div>
                                <div class="small-box-footer p-2 d-flex justify-content-center">
                                    <a href="<?= app\core\Router::url('categories/' . $category['id'] . '/topics') ?>" class="text-white">See topics <i class="fas fa-arrow-circle-right ml-2"></i></a>
                                    <?php if ($category['is_author']): ?>
                                        <a href="<?= app\core\Router::url('categories/edit/' . $category['id']) ?>" class="text-white ml-3">Edit <i class="fas fa-pencil ml-2"></i></a>
                                        <a href="<?= app\core\Router::url('categories/delete/' . $category['id']) ?>" class="text-white ml-3">Delete <i class="fas fa-trash ml-2"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="row w-100 d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $pages; $i++): ?>
                                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= app\core\Router::url('categories/page/' . $i) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                <?php else: ?>
                    <div class="text-center w-100 mt-5">
                        <h2>No categories yet</h2>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
