<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chart</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet"  href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet"  href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet"  href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet"  href="<?php echo $this->config->base_url()."assets/" ;?>bower_components/morris.js/morris.css">
  <!-- Theme style -->
  <link rel="stylesheet"  href="<?php echo $this->config->base_url()."assets/" ;?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet"  href="<?php echo $this->config->base_url()."assets/" ;?>dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="">
<div>
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
    
      <div class="row">
          <!-- BAR CHART -->

        <div class="col-md-12">  
            <div class="box box-success">
                <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title ?></h3>

                <div class="box-tools pull-right">
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button> -->
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
                </div>
                <div class="box-body chart-responsive">
                <div class="chart" id="bar-chart" style="height: 300px;"></div>
                </div>
                <!-- /.box-body -->
            </div>
          <!-- /.box -->

           <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $header ?></span>
                    <span class="info-box-number">Total Click: <?php echo $saldo ?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo number_format(($saldo/$total)*100,1) ?>%"></div>
                </div>
                    <span class="progress-description"><?php echo number_format($saldo/$day_number,1);?> Click per day</span>
            </div>
            <!-- =========================================== -->
            <!-- /.info-box-content -->
        
          </div>

          <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Simulasi MP</span>
                    <span class="info-box-number">Total Click: <?php echo $simulasi ?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo number_format(($simulasi/$total)*100,1) ?>%"></div>
                </div>
                    <span class="progress-description"><?php echo number_format($simulasi/$day_number,1);?> Click per day</span>
            </div>
            <!-- =========================================== -->
            <!-- /.info-box-content -->
        
          </div>

          <div class="info-box bg-red">
                <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Promosi</span>
                    <span class="info-box-number">Total Click: <?php echo $promo ?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo number_format(($promo/$total)*100,1) ?>%"></div>
                </div>
                    <span class="progress-description"><?php echo number_format($promo /$day_number,1);?> Click per day</span>
            </div>
            <!-- =========================================== -->
            <!-- /.info-box-content -->
        
          </div>

          <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Agenda</span>
                    <span class="info-box-number">Total Click: <?php echo $agenda ?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo number_format(($agenda/$total)*100,1) ?>%"></div>
                </div>
                    <span class="progress-description"><?php echo number_format( $agenda/$day_number,1);?> Click per day</span>
            </div>
            <!-- =========================================== -->
            <!-- /.info-box-content -->
        
          </div>

          <div class="info-box bg-gray">
                <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Berita</span>
                    <span class="info-box-number">Total Click: <?php echo $berita ?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo number_format(($berita/$total)*100,1) ?>%"></div>
                </div>
                    <span class="progress-description"><?php echo number_format($berita/$day_number,1);?> Click per day</span>
            </div>
            <!-- =========================================== -->
            <!-- /.info-box-content -->
        
          </div>

          <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kegiatan</span>
                    <span class="info-box-number">Total Click: <?php echo $kegiatan ?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo number_format(($kegiatan/$total)*100,1) ?>%"></div>
                </div>
                    <span class="progress-description"><?php echo number_format($kegiatan/$day_number,1);?> Click per day</span>
            </div>
            <!-- =========================================== -->
            <!-- /.info-box-content -->
        
          </div>

          

          

        </div>
        <!-- /.col (RIGHT) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer>
  
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/morris.js/morris.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->base_url()."assets/" ;?>dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    "use strict";
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: <?php echo $chart_data ?>, 
    //   data: [
    //     {y: '2018', a: 100, b: 90, c: 10, d: 29, e: 45, f: 20}
    //   ],
      barColors: ['#00A65A', '#F39C12', '#DD4B39', '#0073B7', '#D2D6DE', '#605CA8'],
      xkey: 'y',
      ykeys: ['a', 'b','c','d','e','f'],
    //   labels: ['Berita', 'Kegiatan','Info Saldo','Simulasi','Promosi','Agenda'],
      hideHover: 'auto'
    });
  });
</script>
</body>
</html>
