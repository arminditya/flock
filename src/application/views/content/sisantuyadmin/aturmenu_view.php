<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
 
<?php 
foreach($body->css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($body->js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
 

</head>
<body>
<!-- Beginning header -->
<h3>Atur Menu</h3>
<!-- End of header-->
    <div style='height:20px;'></div>  
    <div>
        <?php echo $body->output; ?>
    </div>
<!-- Beginning footer -->
<div>
    
    <!-- Begin - Bagian untuk meletakkan keterangan -->
    <br>
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Keterangan dan Bantuan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tbody><tr>
                  <th style="width: 10px">No.</th>
                  <th>Ketentuan</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Jangan lupa untuk menambahkan role yang dapat mengakses menu ini.</td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Format penulisan URL adalah: [Nama Folder di Contoller]/[Nama Class]/[Method]</td>
                </tr>
                <tr>
                  <td></td>
                  <td>Contoh penulisan URL adalah: SisantuyAll/AturProfilPribadi/index</td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Daftar icon dapat dipilih disini</td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
    <!-- End - Bagian untuk meletakkan keterangan -->

</div>
<!-- End of Footer -->
</body>
</html>