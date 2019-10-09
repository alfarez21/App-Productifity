<?php

	if($user['IdLevel']!=2){
		$Komponen->Redirect("");
		die;
	}

	if($v1=="hapus"){
		$hps1 = $Query->Hapus("detail_produksi","RegProduksi=$v2");
		$hps2 = $Query->Hapus("produksi","RegProduksi=$v2");
		if($hps1 && $hps2 ){
			$Komponen->Redirect("produksi-daftar");
		}
		else{
			$alert = $Komponen->Alert("danger","Data Gagal Dihapus!!","A");
		}
	}

	$DRen = $Query->CustomQuery("SELECT SUM(Target) as jumTar,Tanggal,IdDetailProduksi,SUM(HasilProduksi) as hasil,RegProduksi FROM detail_produksi JOIN produksi USING(RegProduksi) GROUP BY Tanggal");
	$no = 1;
	
	while($RenPro = mysqli_fetch_assoc($DRen)){
		$tglproduksi = date("Ymd", strtotime($RenPro['Tanggal']));

		$Bdetail = $Komponen->TombolLink("info","md","fa-eye","Detail","?produksi-tamren-{$tglproduksi}","");
		$Bhapus = $Komponen->TombolLink("danger","md","fa-trash","hapus","?produksi-daftar-hapus-{$RenPro['RegProduksi']}","");

		$target = $RenPro['jumTar'];
		$hasil = $RenPro['hasil'];
		$presentase = round($hasil/$target*100);

		$aksi = "$Bdetail $Bhapus";

		$TBody .= "$no = top + {$RenPro['Tanggal']} = center + $target = center + $presentase% = center + $hasil = center + $aksi = center |";
	}
	$THead = "NO = 1 + WAKTU = 25 + TARGET = 12 + PRESNTESE = 12 + HASIL = 15 + AKSI = 15";
	
	$Komponen->TombolLink("success","md","fa-plus-square","Tambah","?produksi-tamren","");
	
	$JdSiteTam="Daftar Rencana Produksi";
	$JdKonten = "Daftar Rencana Produksi";
	$TKonten = $Komponen->TombolLink("success","md","fa-plus-square","Tambah","?produksi-tamren","");
	$Konten = $alert.$Komponen->TabelDaftar("100",$THead,$TBody,"","TableFull"); 
?>