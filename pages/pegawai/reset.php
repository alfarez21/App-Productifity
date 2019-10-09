<?php

	if($user['IdLevel']!=1){
		$Komponen->Redirect("");
		die;
	}
	
	if(isset($_POST['reset'])){
		$depass = $Komponen->AutoKode(5);
		$enpass = md5($depass);
		$ubah = $Query->Ubah("Password='$enpass'","pegawai","RegPegawai = '$v1'");
		if($ubah){
			$Komponen->set_flashmsg("success","Password berhasil direset");
		}
		else{
			$Komponen->set_flashmsg("danger","Gagal Direset");
		}
	}

	echo "$de <br> $en";
	$aksi = "<form method='post'>".$Komponen->TombolForm("warning","md","fa-lock","Reset Password","reset","")."</form>";

	$Pegawai = $Query->TampilSatu("","pegawai,level","RegPegawai='$v1' and pegawai.IdLevel = level.IdLevel");
	$Dta = "
	Nama = 200 + {$Pegawai['Nama']} = 700 | 
	Jabatan = 200 + {$Pegawai['NamaLevel']} = 700 |
	Password = 200 + $depass = 700 |
	 = 200 + $aksi
	";

	$View = $Komponen->ViewTable($Dta);

	$alert= $Komponen->flashmsg();

	$JdSiteTam="Reset Password";
	$JdKonten = "Reset Password";
	$TKonten = $Komponen->TombolLink("success","md","fa-arrow-left","Kembali","?pegawai-daftar","");
	$Konten = "
	<div class='ViewTable-Custom'>
		$alert
		$View
	</div>
	"; 

?>