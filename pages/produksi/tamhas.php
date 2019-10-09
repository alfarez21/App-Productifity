<?php

if($user['IdLevel']!=3){
    $Komponen->Redirect("");
    die;
}

$cek = $Query->CekData("detail_produksi","IdDetailProduksi=$v1");
$hasil = htmlspecialchars(trim($_POST['hasil']));

if(!$cek){
    $Komponen->Redirect("produksi-daftarline");
}

$DHas = $Query->customQuery("SELECT * FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE IdDetailProduksi=$v1");
$DHas = mysqli_fetch_assoc($DHas);

if(isset($_POST['simpan'])){
    $up = $Query->Ubah("HasilProduksi='$hasil'","detail_produksi","IdDetailProduksi=$v1");
    if($up){
        $Komponen->Redirect("produksi-daftarline");
    }
    else{
        $alert = $Komponen->Alert("danger","Data Gagal Ditambah!!","A");
    }
}
$tglpro = date("d-m-Y", strtotime($DHas['Tanggal']));

$hasil = $DHas['HasilProduksi'];

$IForm="
Tanggal = 2 + ".$Komponen->InputGroup("<i class='fa fa-calendar'></i>", "<input class='form-control' type='text' value='$tglpro' name='tgllahir' id='Date' placeholder='dd-mm-yyyy' readonly >","")." = 2 |
Hasil = 2 + <input class='form-control' type='number' value='$hasil' name='hasil' $dsbl > = 2 | 
 = 2 + <button type='submit' name='simpan' class='btn btn-md btn-primary' style='margin-top:5px' data-toggle='tooltip' title='Simpan'><i class='fa fa-floppy-o'></i></button> = 9 |
";

$form=$Komponen->FormHorizontal($IForm);

$JdSiteTam="Tambah Hasil Produksi";
$JdKonten = "Tambah Hasil Produksi";
$TKonten = $Komponen->TombolLink("info","md","fa-arrow-left","Kembali","?produksi-daftarline","");
$Konten = "
$alert
$form			
"; 