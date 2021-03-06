<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Turun Tangan Malang</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>plugins/iCheck/square/blue.css">

</head>
<!-- <body class="hold-transition login-page" style="background: #d73925"> -->
<body style="background: #d73925; height: auto;">
<div class="login-box">
  <div class="login-logo">
    <!-- <a href="#"><b>Turun Tangan</b> Malang</a> -->
    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url()."uploads/ttm_white.png"; ?>" width="300px"></a>
  </div>
  <div class="login-box-body">
    <!-- <p class="login-box-msg">Sign in to start your session</p> -->
    <?php if (isset($pesan)): ?>
      <p class="login-box-msg"><?php echo $pesan; ?></p>
    <?php endif ?>

    <form action="<?php echo base_url()."Auth/login"; ?>" method="POST">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>

  </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url() . "assets/"; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
