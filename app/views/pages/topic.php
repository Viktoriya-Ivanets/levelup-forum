<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <?= $topic['title'] ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= \app\core\Router::url('categories') ?>">Categories</a></li>
                        <li class="breadcrumb-item">
                            <a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics') ?>">Topics</a>
                        </li>
                        <li class="breadcrumb-item active"><?= $topic['title'] ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-blue"><?= $topic['date'] ?></span>
                        </div>
                        <div>
                            <i class="fas fa-user bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> <?= $topic['time'] ?></span>
                                <h3 class="timeline-header text-primary"><b><?= $topic['user_login'] ?></b> created this topic</h3>

                                <div class="timeline-body">
                                    <?= $topic['description'] ?>
                                </div>
                                <div class="timeline-footer">
                                    <div class="col-2">
                                        <a href="<?= \app\core\Router::url('categories/' . $categoryId . '/topics/' . $topic['id'] . '/messages/create') ?>" class="btn btn-primary">Add message</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($groupedMessages as $date => $messages): ?>
                            <div class="time-label">
                                <span class="bg-blue"><?= $date ?></span>
                            </div>
                            <?php foreach ($messages as $message): ?>
                                <div>
                                    <i class="fa fa-user bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> <?= $message['time'] ?></span>
                                        <h3 class="timeline-header"><b><?= $message['user_login'] ?></b> added new message</h3>
                                        <div class="timeline-body">
                                            <?= $message['text'] ?>
                                        </div>
                                        <?php if ($message['is_author']): ?>
                                            <div class="timeline-footer d-flex justify-content-start">
                                                <a href="<?= app\core\Router::url('categories/' . $categoryId . '/topics/' . $topic['id'] . '/messages/edit/' . $message['id']) ?>" class="btn btn-primary mr-1">
                                                    Edit <i class="fas fa-pencil ml-2"></i>
                                                </a>
                                                <a href="<?= app\core\Router::url('categories/' . $categoryId . '/topics/' . $topic['id'] . '/messages/delete/' . $message['id']) ?>" class="btn btn-danger">
                                                    Delete <i class="fas fa-trash ml-2"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <!-- timeline end -->
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                        <!-- Пагінація -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $pages; $i++): ?>
                                    <?php if ($i === 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?= app\core\Router::url('categories/' . $categoryId . '/topics/' . $topic['id'] . '/messages') ?>">1</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?= app\core\Router::url('categories/' . $categoryId . '/topics/' . $topic['id'] . '/messages/page/' . $i) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
