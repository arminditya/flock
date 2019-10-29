<!DOCTYPE html>
<html>
<head>
  <style>
    iframe {
      border:0;
    }
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title  ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  
  <!-- Untuk menaruh favicon disini -->
  <link rel="icon" href="<?=base_url()?>/favicon.ico" type="image/ico">
  <!-- End of Favicon -->

  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <!-- <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>plugins/select2/select2.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>dist/css/dpadigicustom.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $this->config->base_url()."assets/" ;?>dist/css/skins/_all-skins.min.css">
  <!-- <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>dist/css/skins/skin-blue.min.css"> -->
  <!-- Pace style -->
  <!-- <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>plugins/pace/pace.min.css"> -->
  <!-- jQuery 3 -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/jquery/dist/jquery.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $this->config->base_url(); ?>index.php/home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>PD</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIPADOK</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Control Sidebar Toggle Button -->
          <li>
            <!-- <a href="<?php echo $this->config->base_url();?>index.php/home/logout"> Sign out  -->
            <!-- <a href="https://www.dapenastra.com/dpadigi/index.php/Home/logout"> Sign out -->
            <a href="<?php echo $this->config->base_url();?>index.php/Home/logout"> Sign out
            <i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $this->config->base_url()."assets/" ;?>dist/img/man_318-143196.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php 
          $username = $this->session->userdata['logged_in']['namauser'];
          echo $username; 
          ?></p>
          <!-- Begin - Ini untuk nama mitra -->

          <!-- End - Ini untuk nama mitra -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">

      <li class="header">MAIN NAVIGATION</li>
      <!-- ================== LOOP THIS SECTION WITH ROLE MENU============================= -->
        <li>
          <a href="<?php echo $this->config->base_url();?>index.php/home/index">
            <i class="fa fa-home"></i> <span>Home</span>
            <span class="pull-right-container">
              <i class="fa pull-right"></i>
            </span>
          </a>
        </li>
      
        <?php foreach($menus as $menu){?>
      <!-- ================== LOOP THIS SECTION WITH ROLE MENU============================= -->
      <?php if($menu->KdMenu == 'webDPAdigi0008') { ?>
          <li>
              <a href="<?php echo $this->config->base_url();?>index.php/<?php echo $menu->Url ?>">
                <i class="<?php echo $menu->IconMenu ?>"></i> <span><?php echo $menu->NamaMenu ?> 
                
                <span class="label label-danger"><?php echo $event_notif_count ?></span></span>

                <span class="pull-right-container">

                  <i class="fa pull-right"></i>
                </span>
              </a>
          </li>

        <?php } else if($menu->KdMenu == 'webDPAdigi0017') { ?>
          <li>
              <a href="<?php echo $this->config->base_url();?>index.php/<?php echo $menu->Url ?>">
                <i class="<?php echo $menu->IconMenu ?>"></i> <span><?php echo $menu->NamaMenu ?> 
                
                <span class="label label-danger"><?php echo $promo_notif_count ?></span></span>

                <span class="pull-right-container">

                  <i class="fa pull-right"></i>
                </span>
              </a>
          </li>
      <?php } else { ?>
        <li>
              <a href="<?php echo $this->config->base_url();?>index.php/<?php echo $menu->Url ?>">
                <i class="<?php echo $menu->Icon ?>"></i> <span><?php echo $menu->NamaMenu ?></span>
                <span class="pull-right-container">

                  <i class="fa pull-right"></i>
                </span>
              </a>
          </li>
          <?php } ?>
     <!-- ================================================================================= -->
     <?php } ?>
     </ul>

    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <?php if($contents!=null) 
        {            
                echo $contents;
        } ?>
    </section>
  </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <!-- Ubah bagian ini ketika ada perbaruan di production -->
      <!-- Last update 05-05-2019 19.49 -->
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2019 <a href="https://dapenastra.com/">Tokopedia</a>.</strong> All rights
    reserved.
  </footer>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
</div>
<!-- ./wrapper -->


<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>dist/js/demo.js"></script>
<!-- fullCalendar -->
<script src="<?php echo $this->config->base_url(); ?>assets/bower_components/moment/moment.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

</body>
</html>
