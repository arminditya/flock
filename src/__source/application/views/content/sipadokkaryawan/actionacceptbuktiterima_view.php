<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?php echo base_url('assets/dist/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets/dist/js/jquery-2.1.4.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/dist/js/jquery.dataTables.min.js') ?>"></script>
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  
  

</head>

<body>

<div class="">
  <h2><?php echo $header ?> </h2>
<br>

<!-- Bagian isi data -->
<div class="container col-md-8">
          <div class="box" >
            <div class="box-header">
              <h3>Data Paket / Dokumen</h3>
            </div>

            <div class="box-body"  style="overflow-x:auto;">
                <table id="datapadok" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    
                    <!-- Jenis Form -->
                    <tr>
                      <td width="35%">Kode Paket / Dokumen</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $KdDataPadok ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Tanggal Paket / Dokumen Masuk</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $TglPadokMasuk ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Nama Penerima</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $Penerima ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Nama Pengirim</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $Pengirim ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Tipe</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $KdTipePadok ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Jasa Ekspedisi</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $KdJasaEkspedisi ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Nama Kurir</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $NamaKurir ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Nomor Telpon Kurir</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $NomorTelpKurir ?></td>
                    </tr>

                    <tr>
                      <td width="35%">Lokasi Paket / Dokumen</td>
                      <td width="3%"> : </td>
                      <td width="62%"><?php echo $KdLokasiPadok ?></td>
                    </tr>
                    

                    </tr>
                </table>
            </div>
            <!-- /.box-body -->

          </div>
</div>

<div class="container col-md-8">
          <div class="box" >
            <div class="box-header">
              <h4>Saya <?php echo $Penerima ?> menyatakan bahwa telah menerima paket tersebut </h4>
            </div>

            <div class="box-body"  style="overflow-x:auto;">
                <form id="requestpengambilan" name="requestpengambilan" method="post" action="<?php echo base_url().'index.php/SipadokKaryawan/ActionAcceptBuktiTerima/do_save_action' ?>">
                    <input type="hidden" name="KdTransaksiPadok" value="<?php echo $KdTransaksiPadok ?>"> 
                    <input type="hidden" name="UpdatedBy" value="<?php echo $UpdatedBy ?>"> 
                    <input type="hidden" name="BktTerimaStatus" value="2"> 
                    <div id='divKeluar' name='divKeluar'>

                        <table id="validasipengambilan" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                          <tr>
                            <td width="35%">Pada </td>
                            <td width="3%"> : </td>
                            <td width="62%"><?php echo $PengambilanRealOn ?></td>
                          </tr>

                          <tr>
                            <td width="35%">Paket / Dokumen diserahkan oleh </td>
                            <td width="3%"> : </td>
                            <td width="62%"><?php echo $DilayaniOlehOa ?></td>
                          </tr>

                        </table>

                        <table id="table-button" class="table" role="">
                          <tr>
                            <td></td>
                            <td></td>
                            <td>
                              <button id="btnsubmit" type="submit" class="btn btn-primary" style="float: right;">SAYA SETUJU</button>
                            </td>
                          </tr>
                        </table>

                    </div>


                </form>
            </div>
            <!-- /.box-body -->

          </div>
</div>
<!-- End Bagian isi data -->
</div>



<div class="row">
<div class="col-md-12">
    
<!-- End of disclaimer -->
</div>
</div>
<!-- </div> -->


</body>
</html>
