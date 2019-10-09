<?php

	if($user['IdLevel']!=1){
		$Komponen->Redirect("");
		die;
	}
	// ==== Hapus Data ====
	if($v1=="hapus"){
		$Query->Hapus("pegawai","RegPegawai=$v2");
		$Komponen->Redirect("pegawai-daftar");
	}

	$data = $Query->TampilSemua("","pegawai,level","pegawai.IdLevel = level.IdLevel","");
	$no = 1;

	while($pegawai = mysqli_fetch_assoc($data)){
	
		$Bedit = $Komponen->TombolLink("info","md","fa-pencil-square-o","Edit","?pegawai-form-edit-{$pegawai['RegPegawai']}","");
		$Breset = $Komponen->TombolLink("warning","md","fa-lock","Reset Password","?pegawai-reset-{$pegawai['RegPegawai']}","");
		$Bhapus = $Komponen->TombolLink("danger","md","fa-trash","Hapus","?pegawai-daftar-hapus-{$pegawai['RegPegawai']}","");

		$aksi = "$Bedit $Breset $Bhapus";
		$Dbody .= "$no = center + {$pegawai['RegPegawai']} = center + {$pegawai['Nama']} = left + {$pegawai['NamaLevel']} = center + $aksi = center |";

		$no++;
	}

	$THead = "NO = 1 + NO REGISTRASI = 12 + NAMA = 25 + JABATAN = 15 + AKSI = 15";
	$TBody = $Dbody;
	
	$Bkanan = $Komponen->TombolLink("success","md","fa-plus-square","Tambah","?pegawai-form-tambah-baru","");
	
	$JdSiteTam="Kelola Pegawai";
	$JdKonten = "Daftar Pegawai";
	$TKonten = $Bkanan;
	$Konten = $Komponen->TabelDaftar("100",$THead,$TBody,"","TableFull"); 
?>