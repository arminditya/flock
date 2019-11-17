<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Form Pendaftaran Local Guide</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">

<div class="container col-md-8">

  <div class="login-logo">
    <a href="<?php echo $this->config->base_url();?>"><b>Form Pendaftaran Local Guide</a>
  </div>
  <!-- /.login-logo -->
  
  <div class="box-body">
    <p  class="text-red" <?php echo validation_errors();?>> </p>
      <div class="row">
        <!-- /.col -->

        <!-- <div class="col-xs-6    ">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Kirim Password</button>
        </div> -->

        <div class="container col-md-8">
          <div class="box" >

            <div class="box-header">
            </div>

            <div class="box-body"  style="overflow-x:auto;">
              <form id="insertuser" name="insertuser" method="post" action="<?php echo base_url().'index.php/verifyLogin/createUser' ?>">
                <table id="tblJenisForm" class="table table-bordered" role="grid">

                <tr>
                  <td width="20%">Username</td>
                  <td width="80%"><input type="text" name="username" class="form-control" placeholder="Username"/></td>
                </tr>

                <tr>
                  <td width="20%">Nama</td>
                  <td width="80%"><input type="text" name="nama" class="form-control" placeholder="Nama"/></td>
                </tr>

                <tr>
                  <td width="20%">Jenis Kelamin</td>
                  <td width="80%">
                  <select class="form-control" name="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                              <option value="P">Perempuan</option>
                              <option value="L">Laki Laki</option>
                            </select>
                  </td>
                </tr>

                <tr>
                  <td width="20%">No. HP</td>
                  <td width="80%"><input type="tel" name="no_hp" class="form-control" placeholder="No. Handphone"/></td>
                </tr>

                <tr>
                  <td width="20%">Email</td>
                  <td width="80%"><input type="email" name="email" class="form-control" placeholder="Email"/></td>
                </tr>

                <tr>
                  <td width="20%">Tgl Lahir</td>
                  <td width="80%">
                      <select class="numb" name="d_lahir">
                                    <?php
                                      for($i = 1; $i < 32; $i++){
                                        //$selected = date('d');
                                        $selected = ($i == date('d')) ? 'selected' : '';
                                        echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
                                      }
                                    ?>
                                  </select>
                                  <select class="numb" name="m_lahir">
                                    <?php
                                      for($i = 1; $i < 13; $i++){
                                        $selected = ($i == date('m')) ? 'selected' : '';
                                        echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
                                      }
                                    ?>
                                  </select>
                                  <select class="tahun" name="y_lahir">
                                            <?php
                                      // for($i = date('Y')-70; $i <= date('Y'); $i++)
                                      for($i = date('Y'); $i >= date('Y')-70; $i--)
                                      {
                                        $selected = ($i == date('Y')) ? 'selected' : '';
                                        echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
                                      }
                                    ?>
                                  </select>
                  </td>
                </tr>

                <tr>
                  <td width="20%">Tipe Pengguna</td>
                  <td width="80%">
                  <select class="form-control" name="role">
                            <option value="">Pilih Tipe Pengguna</option>
                              <option value="3">Traveller</option>
                              <option value="2">Local Guide</option>
                            </select>
                  </td>
                </tr>

                <tr>
                  <td width="20%">Password</td>
                  <td width="80%"><input type="password" name="password" class="form-control" placeholder="Password"/></td>
                </tr>

                <tr>
                  <td width="20%">Re-password</td>
                  <td width="80%"><input type="password" name="repassword" class="form-control" placeholder="Ulangi Password"/></td>
                </tr>
               

                </table>

                <!-- begin - div Button -->
                <div id='divButton' name='divButton'>
                  <table id="table-button" class="table" role="">
                    <tr>
                      <td></td>
                      <td></td>
                      <td>
                        <button id="btnsubmit" type="submit" class="btn btn-primary" style="float: right;">DAFTAR</button>
                      </td>
                    </tr>
                  </table>
                  </div>
                  <!-- end - div Button -->

              </form>

            </div>

          </div>
        </div>

        <!-- /.col -->
      </div>
  </div>
  <!-- /.login-box-body -->
</div>

<!-- jQuery 3 -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
