<?php

	if($user['IdLevel']!=1){
		$Komponen->Redirect("");
		die;
	}
	// ======= Set Title Page ==========
	if($v1=="tambah"){
		$JdSiteTam="Tambah Pegawai";
	}
	if($v1=="edit"){
		$JdSiteTam="Edit Pegawai";
	}	
	
	// ========= Get Data For Form =======
	$DPegawai = mysqli_fetch_assoc($Query->TampilSemua("","pegawai","RegPegawai=$v2"));
	
	//========= Set Data For Edit =======
	if($v1=="edit"){

		$username = $DPegawai['Username'];
		$nama = $DPegawai['Nama'];
		$tmplahir = $DPegawai['TempatLahir'];
		$tgllahir = date("d-m-Y", strtotime($DPegawai['TanggalLahir']));;
		$jkelamin = $DPegawai['Gender'];
		$jabatan = $DPegawai['IdLevel'];
		$line = $DPegawai['IdLine'];

	}
	
	// ========== Tambah Data Pegawai =========
	if(isset($_POST['simpan'])){

		// =========== Vars =========
		$username = htmlspecialchars(trim($_POST['username']));
		$nama = htmlspecialchars(trim($_POST['nama']));
		$tmplahir = htmlspecialchars(trim($_POST['tmplahir']));
		$tgllahir = htmlspecialchars(trim($_POST['tgllahir']));
		$jkelamin = htmlspecialchars(trim($_POST['jenisKelamin']));
		$jabatan = htmlspecialchars(trim($_POST['jabatan']));
		$line = htmlspecialchars(trim($_POST['line']));

		$tgllahir = date("Y-m-d", strtotime($tgllahir));
		$noRegis = date('Ymdhis');
		if($line==0){$line = 'null';}

		if($v1=="edit"){
			if($Cek){
				$alert = $Komponen->Alert("warning","Tidak Ada Yang Ubah","A");
			}
			else{
				$ubah = $Query->Ubah("Username='$username',Nama='$nama',TempatLahir='$tmplahir',TanggalLahir='$tgllahir',Gender='$jkelamin',IdLevel='$jabatan',IdLine=$line","pegawai","RegPegawai='{$DPegawai['RegPegawai']}'");
				if($ubah){
					$alert = $Komponen->Alert("success","Data Berhasil Di Ubah","A");
					// $Komponen->Redirect("pegawai-form-edit-$v2");
				}
				else{
					$alert = $Komponen->Alert("danger","Data Gagal Di Ubah","A");
				}
			}
		}

		$Cek = $Query->CekData("pegawai","Username='$username' and Nama='$nama' and TempatLahir='$tmplahir' and TanggalLahir='$tgllahir' and Gender='$jkelamin'");
		if($v1=="tambah"){
			if($Cek){
				$alert = $Komponen->Alert("danger","Data Sudah Ada!!","A");
			}
			else{
				$tam = $Query->Tambah("pegawai","RegPegawai,Username,Nama,TempatLahir,TanggalLahir,Gender,IdLevel,IdLine","'$noRegis','$username','$nama','$tmplahir','$tgllahir','$jkelamin','$jabatan',$line");
				if($tam){
					$alert = $Komponen->Alert("success","Data Berhasil Disimpan !!","A");
					$username = "";
					$nama = "";
					$tmplahir = "";
					$tgllahir = "";
					$jkelamin = "";
					$jabatan = "";
					$line = "";
 				}else{
					$alert = $Komponen->Alert("danger","Data Gagal Disimpan !!","A");
				}
			}
		}
		

	}


	// ========= Button/Tombol ===========
	$Bsimpan = "<button type='submit' name='simpan' class='btn btn-md btn-primary' style='margin-top:5px' data-toggle='tooltip' title='Simpan'><i class='fa fa-floppy-o'></i></button>";
	$Bbaru = $Komponen->TombolLink("info","md","fa-plus-square","Baru","?pegawai-form-tambah","");
	$Bbatal = $Komponen->TombolLink("danger","md","fa-times","Batal","?pegawai-daftar","");



	// ============== Page Conditioning ===========
	if($v1=="tambah"){
		$JdSiteTam = "Tambah Pegawai";
		if($v2=="baru"){	
			$dsbl = "disabled";
			$btnForm = "$Bbaru";
		}
		else{
			$btnForm = "$Bsimpan $Bbatal";
		}
	}
	else if($v1=="edit"){
		$JdSiteTam = "Edit Pegawai";
		$btnForm = "$Bsimpan $Bbaru $Bbatal";
	}

	


	// ======== Get Data Level  and Line ==============
	$Dlevel = $Query->TampilSemua("","level","");
	$Dline = $Query->TampilSemua("","line","");


	
	// ========= Select & Radio Inputs Selector/Chacker=========
	// Radio Gender
	if($jkelamin=="L"){
		$lcheck = "checked";
	}

	if($jkelamin=="P"){
		$pcheck = "checked";
	}

	// Option Jabatan 
	while($level = mysqli_fetch_assoc($Dlevel)){
		if($jabatan==$level['IdLevel']){
			$Jopt .= "<option value='{$level['IdLevel']}' selected>{$level['NamaLevel']}</option>";
		}
		else{
			$Jopt .= "<option value='{$level['IdLevel']}'>{$level['NamaLevel']}</option>";
		}
	}



	// ========== Radio Gender ==============
	$radio = $Komponen->InputRadioCheck("radio","Laki Laki","jenisKelamin","L","$lcheck $dsbl required")." ".$Komponen->InputRadioCheck("radio","Perempuan","jenisKelamin","P","$pcheck $dsbl required");



	// ======== Select Jabatan ===========
	$Jselect = "
	<select name='jabatan' id='jabatan' class='form-control select2 custom-select' onchange='shline()' $dsbl required>
	    <option>------ Jabatan ------</option>
	    $Jopt
	</select>
	";



	// ======= Select Line =======
	$Dline = $Query->TampilSemua("","line","","");
	
	while($line = mysqli_fetch_assoc($Dline)){
		if($DPegawai['IdLine']==$line['IdLine']){
			$Lopt .= "<option value='{$line['IdLine']}' selected>{$line['NamaLine']}</option>";
		}
		else{
			$Lopt .= "<option value='{$line['IdLine']}'>{$line['NamaLine']}</option>";
		}
	}

	$Lselect = "
	<select name='line' class='form-control select2 custom-select' style='width:100%' $dsbl>
		<option value='0'>Line</option>
		$Lopt
	</select>
	";



	$JdKonten = ucfirst($v1)." Pegawai";
	$TKonten = $Komponen->TombolLink("success","md","fa-arrow-left","Kembali","?pegawai-daftar","");
	$Konten = " 
	$alert
	<form method='post'  enctype='multipart/form-data' class='form-horizontal' autocomplete='off'>
		<div class='form-group'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'>Username</span></label>
			<div class='col-sm-4'>
				<input class='form-control' type='text' value='$username' name='username' $dsbl required>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'>Nama</span></label>
			<div class='col-sm-4'>
				<input class='form-control' type='text' value='$nama' name='nama' $dsbl required>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'>Tempat Lahir</span></label>
			<div class='col-sm-4'>
				<input class='form-control' type='text' value='$tmplahir' name='tmplahir' $dsbl required>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'>Tanggal Lahir</span></label>
			<div class='col-sm-4'>
				<div class='input-group'>
					<span class='input-group-addon' style='background:#f3f3f3'><i class='fa fa-calendar'></i></span>
					<input class='form-control' type='text' value='$tgllahir' name='tgllahir' id='Date' placeholder='dd-mm-yyyy' $dsbl required>
				</div>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'>Jenis Kelamin</span></label>
			<div class='col-sm-4'>
				$radio
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'>Jabatan</span></label>
			<div class='col-sm-4'>
				$Jselect
			</div>
		</div>
		<div class='form-group' id='line' style='display:none'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'>Line</span></label>
			<div class='col-sm-2'>
				$Lselect
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label'><span class='pull-left' style='font-weight:normal'></span></label>
			<div class='col-sm-4'>
				$btnForm
			</div>
		</div>
	</form>

	<script>
		function shline(){
			jabatan = document.getElementById('jabatan').value;
			if(jabatan==3){
				document.getElementById('line').style.display = 'block';
			}
			else{
				document.getElementById('line').style.display = 'none';
			}
		}

		shline();
	</script>
	";
	 

?>