<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="<?= PUBLIC_IMAGES . 'ForumLogo.png' ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Forum</span>
        </a>
        <div class="collapse navbar-collapse order-3 d-flex justify-content-end" id="navbarCollapse">
            <a href="<?= \app\core\Router::url('logout') ?>" class="btn btn-secondary d-flex align-items-center ms-auto"> <?= \app\core\Session::get('user') ?>
                <i class="fa-solid fa-right-from-bracket ml-2"></i>
            </a>
        </div>
    </div>
</nav>
