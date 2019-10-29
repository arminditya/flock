<!DOCTYPE html>
<html lang="en">
<head>
    
<title><?php echo $title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <link href="<?php echo base_url('assets/dist/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets/dist/js/jquery-2.1.4.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/dist/js/jquery.dataTables.min.js') ?>"></script>
  <!-- <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> -->
  <!-- <script type="text/javascript" src="../assets/js/myfunction.js?v=2.14"></script> -->
  <!-- Latest compiled and minified CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css"> -->
  <!-- Latest compiled and minified JavaScript -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> -->
  <!-- (Optional) Latest compiled and minified JavaScript translation files -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script> -->
  
</head>
<body>
<!-- Beginning header -->
<h3><?php echo $title ?></h3>
<!-- End of header-->
		<div style='height:20px;'></div>  
		
		<div class="container row-md-4">
			<div class="container col-md-4">
          <div class="box" >
    
        <form action="<?php echo $this->config->base_url();?>index.php/SipadokAll/Pengaturan/change_password" method="post" >
      
		  <div class="form-group has-feedback">
			<input type="password" name="CurrentPassword" class="form-control" placeholder="Password saat ini">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		  
		  <div class="form-group has-feedback">
			<input type="password" name="NewPassword" class="form-control" placeholder="Password baru">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		  
		  <div class="form-group has-feedback">
			<input type="password" name="ConfNewPassword" class="form-control" placeholder="Konfirmasi password baru">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>

		   <input type="hidden" name="url" class="form-control" placeholder="" 
			value = '<?php echo $this->input->get('url'); ?>'>
			<div class="row">
			<!-- /.col -->

		  <div class="col-xs-6">
			<button type="submit" class="btn btn-primary btn-block btn-flat">Ubah Password</button>
		  </div>
			<!-- /.col -->
		  </div>
		</form>	
		
          </div>
					</div>
		</div>


		<div class="container row-md-4">
		<div class="container col-md-4">
          <div class="box" >
            <div class="box-header">
              <h4>Pengaturan Bahasa</h4>
            </div>

            <div class="box-body"  style="overflow-x:auto;">
                <form id="requestpengambilan" name="requestpengambilan" method="post" action="<?php echo base_url().'index.php/SipadokKaryawan/ActionRequestPengambilan/do_save_action' ?>">
                    <div id='divKeluar' name='divKeluar'>
                        <table id="tblKeluar" class="table" role="grid">
                          
                            <tr>
                                <td width="5%">Pilih Bahasa</td>
                                <td width="3%">: </td>
                                <td width="10%">
																<select class="form-control" name="PesertaBaruJenisKelamin">
																<option value="">Pilih Bahasa</option>
																	<option value="1">Indonesia</option>
																	<option value="2">English</option>
																</select>
                                </td>

                            </tr>

												</table>
												
												<table>
													<tr>
													<td width="10%">
                                  <button id="btnsubmit" name="btnsubmit" type="submit" class="btn btn-primary" style="float: right;">SIMPAN PERUBAHAN</button>
                            </td>
													</tr>
												</table>

                    </div>


                </form>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
</div>



    </div>
<!-- Beginning footer -->
<div></div>
<!-- End of Footer -->
</body>
</html>