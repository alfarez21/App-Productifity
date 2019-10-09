<?php

	if($user['IdLevel']!=3){
		$Komponen->Redirect("");
		die;
	}
	$DRen = $Query->CustomQuery("SELECT Target,Tanggal,IdDetailProduksi,HasilProduksi,RegProduksi FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE detail_produksi.RegPegawai={$user['RegPegawai']}");
	$no = 1;

	while($RenPro = mysqli_fetch_assoc($DRen)){
		$aksi = $Komponen->TombolLink("info","md","Hasil Produksi","Hasil Produksi","?produksi-tamhas-{$RenPro['IdDetailProduksi']}","");

		$hasil = $RenPro['HasilProduksi'];
		$target = $RenPro['Target'];
		$presentase = round($hasil/$target*100);

		$TBody .= "$no = top + {$RenPro['Tanggal']} = center + $target = center + $presentase% = center + $hasil = center + $aksi = center |";
	}

	$THead = "NO = 1 + WAKTU = 25 + TARGET = 12 + PRESNTESE = 12 + HASIL = 15 + AKSI = 15";
		

	$JdSiteTam="Daftar Rencana Produksi";
	$JdKonten = "Daftar Rencana Produksi";
	$Konten = $Komponen->TabelDaftar("100",$THead,$TBody,"","TableFull"); 

?>