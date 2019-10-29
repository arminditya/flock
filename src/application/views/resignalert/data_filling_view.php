<!DOCTYPE html>
<html lang="en">
<head>
<title>Form Klaim</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?php echo base_url('assets/dist/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> <!-- Google Font -->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
  <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 
  <!--Font Awesome (added because you use icons in your prepend/append)-->
  <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
  <!-- Inline CSS based on choices in "Settings" tab -->
  <style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: #1a6c94}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}.bootstrap-iso form .input-group-addon {color:#040404; background-color: #aaf09a; border-radius: 4px; padding-left:12px}</style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets/dist/js/jquery-2.1.4.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/dist/js/jquery.dataTables.min.js') ?>"></script>
</head>
<body>

  <div class="container">
    <h2>Form Klaim</h2>
  </div>

  <div class="bootstrap-iso">
  <div class="container-fluid">
    <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">

      <!-- Begin - Form -->
      <form action="<?php echo $this->config->base_url();?>index.php/ResignAlert/DataFilling/doSubmitForm" method="post">

      <!-- Begin - Bagian bertindak sebagai siapa -->
      <div class="form-group ">
        <label class="control-label requiredField">
        Saya yang bertanda tangan di bawah ini, bertindak sebagai:
        <span class="asteriskField">
          *
        </span>
        </label>
        <!-- Begin - Radio button pilihan bertindak sebagai siapa -->
        <div class="">
        <div class="radio">
          <label class="radio">
          <input name="rbBertindakAtasNama" type="radio" value="Diri Sendiri"/>
          Diri Sendiri
          </label>
        </div>
        <div class="radio">
          <label class="radio">
          <input name="rbBertindakAtasNama" type="radio" value="Suami / Istri / Anak"/>
          Suami / Istri / Anak
          </label>
        </div>
        <div class="radio">
          <label class="radio">
          <input name="rbBertindakAtasNama" type="radio" value="Ahli waris / Pihak yang ditunjuk"/>
          Ahli waris / Pihak yang ditunjuk
          </label>
        </div>
        </div>
        <!-- End - Radio button pilihan bertindak sebagai siapa -->
      </div>
      <!-- End - Bagian bertindak sebagai siapa -->

      <!-- Begin - Bagian nama peserta -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtNamaPeserta">
        Nama Peserta (sesuai KTP)
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtNamaPeserta" name="txtNamaPeserta" placeholder="Nama Lengkap" type="text"/>
        <span class="help-block" id="hint_txtNamaPeserta">
        Wajib melampirkan fotocopy KTP
        </span>
      </div>
      <!-- End - Bagian nama peserta -->

      <!-- Begin - Bagian Nomor KTP -->
      <div class="form-group ">
        <label class="control-label " for="txtNomorKTP">
        Nomor KTP
        </label>
        <input class="form-control" id="txtNomorKTP" name="txtNomorKTP" placeholder="Nomor KTP" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "16"/>
      </div>
      <!-- End - Bagian Nomor KTP -->

      <!-- Begin - Bagian tanggal lahir -->
      <div class="form-group ">
        <label class="control-label requiredField" for="dateTglLahir">
        Tanggal Lahir
        <span class="asteriskField">
          *
        </span>
        </label>
        <div class="input-group">
        <div class="input-group-addon">
          <i class="fa fa-calendar">
          </i>
        </div>
        <input class="form-control" id="dateTglLahir" name="dateTglLahir" placeholder="DD/MM/YYYY" type="date"/>
        </div>
        <span class="help-block" id="hint_dateTglLahir">
        Tanggal / Bulan / Tahun
        </span>
      </div>
      <!-- End - Bagian tanggal lahir -->

      <!-- Begin - Bagian Nama Perusahaan -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtNamaPerusahaan">
        Nama Perusahaan
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtNamaPerusahaan" name="txtNamaPerusahaan" placeholder="Nama Perusahaan" type="text"/>
      </div>
      <!-- End - Bagian Nama Perusahaan -->

      <!-- Begin - Bagian NIK -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtNIK">
        Nomor Induk Karyawan
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtNIK" name="txtNIK" placeholder="NIK / NIP" type="text"/>
      </div>
      <!-- End - Bagian NIK -->

      <!-- Begin - Bagian NPWP -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtNPWP">
        NPWP
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtNPWP" name="txtNPWP" placeholder="NPWP" type="text"/>
      </div>
      <!-- End - Bagian NPWP -->

      <!-- Begin - Bagian telfon rumah -->
      <div class="form-group ">
        <label class="control-label " for="txtTelfonRumah">
        Telfon Rumah
        </label>
        <div class="input-group">
        <div class="input-group-addon">
          +62
        </div>
        <input class="form-control" id="txtTelfonRumah" name="txtTelfonRumah" placeholder="21876xxx" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "9"/>
        </div>
      </div>
      <!-- End - Bagian telfon rumah -->

      <!-- Begin - Bagian telfon handphone -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtTelfonHandphone">
        Telfon Handphone
        <span class="asteriskField">
          *
        </span>
        </label>
        <div class="input-group">
        <div class="input-group-addon">
          +62
        </div>
        <input class="form-control" id="txtTelfonHandphone" name="txtTelfonHandphone" placeholder="82345678xxx" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "13"/>
        </div>
      </div>
      <!-- End - Bagian telfon handphone -->

      <!-- Begin - Bagian berhenti sejak -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtBerhentiSejak">
        Berhenti Sejak
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtBerhentiSejak" name="txtBerhentiSejak" placeholder="MM/YYYY" type="text" maxlength = "7"/>
        <span class="help-block" id="hint_txtBerhentiSejak">
        Contoh: 09/2016
        </span>
      </div>
      <!-- End - Bagian berhenti sejak -->

      <!-- Begin - Bagian nomor rekening -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtNomorRekening">
        Nomor Rekening
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtNomorRekening" name="txtNomorRekening" placeholder="Nomor Rekening" type="number"/>
      </div>
      <!-- End - Bagian nomor rekening -->

      <!-- Begin - Bagian nama pemilik rekening -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtNamaPemilikRekening">
        Nama Pemilik Rekening
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtNamaPemilikRekening" name="txtNamaPemilikRekening" placeholder="Pemilik Rekening" type="text"/>
      </div>
      <!-- End - Bagian nama pemilik rekening -->

      <!-- Begin - Bagian nama bank -->
      <div class="form-group ">
        <label class="control-label requiredField" for="PilihNamaBank">
        Nama Bank
        <span class="asteriskField">
          *
        </span>
        </label>
        <!-- Begin - Pilihan nama bank -->
        <select class="select form-control" id="PilihNamaBank" name="PilihNamaBank" onchange=getTextBank()>
            <option value=''>Pilih Bank</option>
              <?php 
              
              foreach($bank as $f){
                if($f->KodeMstrBank == $user->KodeMstrBank){
                  $selected = " selected=selected ";
                } else {
                  $selected = "";
                }
                
                echo "<option $selected value=" . $f->KodeMstrBank . ">" . $f->Deskripsi . "</option>";
              }	
            ?>		
        <!-- <option value="Bank 1">
          Bank 1
        </option>
        <option value="Bank 2">
          Bank 2
        </option>
        <option value="Bank 3">
          Bank 3
        </option> -->
        </select>
        <!-- End - Pilihan nama bank -->
        <span class="help-block" id="hint_PilihNamaBank">
        Pilih salah satu bank yang tersedia
        </span>
      </div>
      <!-- End - Bagian nama bank -->

      <!-- Begin - Bagian pertanyaan masa kepesertaan -->
      <div class="form-group ">
        <label class="control-label requiredField">
        Apakah masa kepesertaan lebih dari 3 tahun dan saat ini belum mencapai usia 45 tahun
        <span class="asteriskField">
          *
        </span>
        </label>
        <div class="">
        <div class="radio">
          <label class="radio">
          <input name="rbPertanyaanMasaKepesertaan" type="radio" value="Ya"/>
          Ya
          </label>
        </div>
        <div class="radio">
          <label class="radio">
          <input name="rbPertanyaanMasaKepesertaan" type="radio" value="Tidak"/>
          Tidak
          </label>
        </div>
        </div>
      </div>
      <!-- End - Bagian pertanyaan masa kepesertaan -->

      <!-- Begin - Bagian DPLK -->
      <div class="form-group ">
        <label class="control-label " for="txtDPLK">
        Manfaat Pensiun saya dialihkan ke DPLK
        </label>
        <input class="form-control" id="txtDPLK" name="txtDPLK" placeholder="DPLK yang dipilih" type="text"/>
        <span class="help-block" id="hint_txtDPLK">
        Informasi tentang DPLK yang ada dalam daftar OJK (Otoritas Jasa Keuangan) dapat dilihat pada web www.dapenastra.com
        </span>
      </div>
      <!-- End - Bagian DPLK -->

      <!-- Begin - Bagian pertanyaan apakah harus membeli anuitas-->
      <div class="form-group ">
        <label class="control-label requiredField">
        Apakah kepesertaan anda merupakan Peserta DPA 2 yang memiliki masa kepesertaan lebih dari 3 tahun dan telah mencapai usia 45 tahun, serta 80% Manfaat Pensiun melebihi Rp. 500.000.000 ?
        <span class="asteriskField">
          *
        </span>
        </label>
        <div class="">
        <div class="radio">
          <label class="radio">
          <input name="rbAsuransi" type="radio" value="Ya"/>
          Ya
          </label>
        </div>
        <div class="radio">
          <label class="radio">
          <input name="rbAsuransi" type="radio" value="Ragu"/>
          Ragu
          </label>
        </div>
        <div class="radio">
          <label class="radio">
          <input name="rbAsuransi" type="radio" value="Tidak"/>
          Tidak
          </label>
        </div>
        </div>
      </div>
      <!-- End - Bagian pertanyaan apakah harus membeli anuitas-->

      <!-- Begin - Bagian memilih asuransi untuk Anuitas -->
      <div class="form-group ">
        <label class="control-label " for="txtAsuransiJiwa">
        Saya mohon 80% dari Manfaat Pensiun saya dibelikan produk Anuitas pilihan saya dari perusahaan Asuransi Jiwa
        </label>
        <input class="form-control" id="txtAsuransiJiwa" name="txtAsuransiJiwa" placeholder="Asuransi Jiwa" type="text"/>
        <span class="help-block" id="hint_txtAsuransiJiwa">
        Informasi tentang Asuransi Jiwa yang ada dalam daftar OJK (Otoritas Jasa Keuangan) dapat dilihat pada web www.dapenastra.com
        </span>
      </div>
      <!-- End - Bagian memilih asuransi untuk Anuitas -->

      <!-- Begin - Bagian email pemohon -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtEmailPemohon">
        Email Pemohon
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtEmailPemohon" name="txtEmailPemohon" placeholder="Alamat Email" type="email"/>
      </div>
      <!-- End - Bagian email pemohon -->

      <!-- Begin - Bagian Nama Pemohon -->
      <div class="form-group ">
        <label class="control-label requiredField" for="txtNamaPemohon">
        Nama Pemohon
        <span class="asteriskField">
          *
        </span>
        </label>
        <input class="form-control" id="txtNamaPemohon" name="txtNamaPemohon" placeholder="Nama Lengkap Pemohon" type="text"/>
      </div>
      <!-- End - Bagian Nama Pemohon -->

      <!-- Begin - Button Submit -->
      <div class="form-group">
        <div>
        <button class="btn btn-primary " name="submit" type="submit">
          Submit
        </button>
        </div>
      </div>
      <!-- End - Button Submit -->
      </form>
      <!-- End - Form -->

    </div>
    </div>
  </div>
  </div>


</body>
</html>

<script type="text/javascript">
  function getTextBank()
		{
			var textbank=$('#bank option:selected').text();
			$('#namaBank').val(textbank);
			//alert(textbank);
		}		
  </script>


