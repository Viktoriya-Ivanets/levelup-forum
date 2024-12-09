<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 d-flex justify-content-between">
                <h1 class="col-2">Topics</h1>
                <div class="col-10">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= \app\core\Router::url('categories') ?>">Categories</a></li>
                        <li class="breadcrumb-item active">Topics</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row mb-3">
                <div class="col-2">
                    <a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics/create') ?>" class="btn btn-primary">Add topic</a>
                </div>
            </div>
            <div class="row">
                <?php if (!empty($topics)): ?>
                    <?php foreach ($topics as $topic): ?>
                        <div class="col-lg-6 col-md-6">
                            <div class="col-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h4 class="m-0"><?= htmlspecialchars($topic['title']); ?></h4>
                                    </div>
                                    <div class="card-body">
                                        <p><?= htmlspecialchars($topic['description']); ?></p>
                                        <hr class="w-100">
                                        <div class="d-flex justify-content-between text-primary w-100">
                                            <div class="w-50"><?= htmlspecialchars($topic['user_login']); ?></div>
                                            <div class="w-50 text-right"><?= htmlspecialchars($topic['created_at']); ?></div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-primary p-2 d-flex justify-content-center">
                                        <a href="<?= app\core\Router::url('categories/' . $categoryId . '/topics/' . $topic['id'] . '/messages') ?>" class="text-white">See full conversation <i class="fas fa-arrow-circle-right ml-2"></i></a>
                                        <?php if ($topic['is_author']): ?>
                                            <a href="<?= app\core\Router::url('categories/' . $categoryId . '/topics/edit/' . $topic['id']) ?>" class="text-white ml-3">Edit <i class="fas fa-pencil ml-2"></i></a>
                                            <a href="<?= app\core\Router::url('categories/' . $categoryId . '/topics/delete/' . $topic['id']) ?>" class="text-white ml-3">Delete <i class="fas fa-trash ml-2"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($topic['id'] % 2 === 0): ?>
            </div>
            <div class="row">
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center w-100 mt-5">
            <h2>No topics yet</h2>
        </div>
    <?php endif; ?>
            </div>
        </div>
    </div>
</div>
