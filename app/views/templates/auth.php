<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum Auth</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= ADMIN_LTE_PLUGINS_CSS . 'icheck-bootstrap.min.css' ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= ADMIN_LTE_DIST_CSS . 'adminlte.min.css' ?>">
</head>

<body class="hold-transition login-page">

    <?php include_once(VIEWS . 'auth/login.php') ?>

    <!-- jQuery -->
    <script src="<?= ADMIN_LTE_PLUGINS_JS . 'jquery.min.js' ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= ADMIN_LTE_PLUGINS_JS . 'bootstrap.bundle.min.js' ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= ADMIN_LTE_DIST_JS . 'adminlte.min.js' ?>"></script>
</body>

</html>
