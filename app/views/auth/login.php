<div class="login-box">
    <div class="card card-outline card-primary">
        <h1 class="card-header text-center"><b>Forum</b></h1>
        <div class="card-body">
            <p class="login-box-msg">Login to start your session</p>
            <form action="<?= \app\core\Router::url('login') ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="login" class="form-control" placeholder="Login">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <a href="<?= \app\core\Router::url('register') ?>">
                            <div class="btn btn-primary w-100 mt-2">Register</div>
                        </a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
