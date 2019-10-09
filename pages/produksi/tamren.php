<?php

if($user['IdLevel']!=2){
    $Komponen->Redirect("");
    die;
}

$DProduksi = mysqli_fetch_assoc($Query->TampilSemua('',"produksi","Tanggal='$v1'"));

if($v1=="hapus"){
    $dtT = mysqli_fetch_assoc($Query->customQuery("SELECT * FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE IdDetailProduksi=$v2"));
    $hps = $Query->Hapus("detail_produksi","IdDetailProduksi=$v2");
    if($hps){
        $tgl = date("Ymd", strtotime($dtT['Tanggal']));
        $Komponen->Redirect("produksi-tamren-$tgl");
    }
    else{
        $alert = $Komponen->Alert("danger","Data Gagal Dihapus!!","A");
    }

}
if(isset($_POST['simpan'])){

    // =========== Vars =========
    $tglproduksi = htmlspecialchars(trim($_POST['tglproduksi']));
    $target = htmlspecialchars(trim($_POST['target']));
    $line = htmlspecialchars(trim($_POST['line']));
	if($line==0){$line = 'null';}    
    $noRegis = date('Ymdhis');
    
    
    $tglproduksi = date("Y-m-d", strtotime($tglproduksi));
    
    $cek = $Query->CekData('produksi',"Tanggal='$tglproduksi'");
    
    $RegPeg = mysqli_fetch_assoc($Query->TampilSemua("RegPegawai","pegawai","IdLine='$line' and IdLevel=3"));
    $RegPeg = $RegPeg['RegPegawai'];
    if($v1==date("Ymd", strtotime($DProduksi['Tanggal'])) && $v1!=""){
        if($Query->CekData('detail_produksi',"IdLine=$line and RegProduksi={$DProduksi['RegProduksi']}")){
            $updt = $Query->Ubah("Target=$target","detail_produksi","IdLine=$line and RegProduksi={$DProduksi['RegProduksi']}");
            if($updt){
                $alert = $Komponen->Alert("success","Rencana Produksi Telah Ditambahkan","A");
                $line = "";
                $target = "";
            }
            else{
                $alert = $Komponen->Alert("danger","Rencana Produksi Gagal Ditambahkan","A");
            }
        }
        else{
            $tam = $Query->Tambah("detail_produksi","IdDetailProduksi,RegProduksi,RegPegawai,IdLine,Target","'$noRegis','{$DProduksi['RegProduksi']}','$RegPeg','$line','$target'");
            if($tam){
                $line = "";
                $target = "";
                $alert = $Komponen->Alert("success","Rencana Produksi Telah Ditambahkan","A");
            }
            else{
                $alert = $Komponen->Alert("danger","Rencana Produksi Gagal Ditambahkan","A");
            }
        }
    }
    else{
        if($cek){
            $tglproduksi = date("Ymd", strtotime($tglproduksi));
            $Komponen->Redirect("produksi-tamren-$tglproduksi");
        }
        else{
            $tam = $Query->Tambah("produksi","RegProduksi,RegPegawai,Tanggal","'$noRegis','{$user['RegPegawai']}','$tglproduksi'");
            $tglproduksi = date("Ymd", strtotime($tglproduksi));
            $Komponen->Redirect("produksi-tamren-$tglproduksi");
        }       
    }
    
    
}

$Dline = $Query->TampilSemua("","line","","");

while($line = mysqli_fetch_assoc($Dline)){
    if($DPegawai['IdLine']==$line['IdLine']){
        $Lopt .= "<option value='{$line['IdLine']}' selected>{$line['NamaLine']}</option>";
    }
    else{
        $Lopt .= "<option value='{$line['IdLine']}'>{$line['NamaLine']}</option>";
    }
}

$select = "
<select name='line' class='form-control select2 custom-select' required>
    <option value='0'>Line</option>
    $Lopt
</select>
";
    
$Bsimpan = "<button type='submit' name='simpan' class='btn btn-md btn-success' style='margin-top:5px' data-toggle='tooltip' title='Simpan'><i class='fa fa-floppy-o'></i></button>";
$Bbaru = "<a href='?produksi-tamren' class='btn btn-md btn-primary' style='margin-top:5px' data-toggle='tooltip' title='Baru'><i class='fa fa-plus-square'></i></a>";


if($v1==date("Ymd", strtotime($DProduksi['Tanggal'])) && $v1!=""){

    $tglpro = date("Y-m-d", strtotime($v1));

    $DRen = $Query->customQuery("SELECT * FROM detail_produksi JOIN produksi USING(RegProduksi) JOIN pegawai ON detail_produksi.RegPegawai = pegawai.RegPegawai WHERE Tanggal = '$tglpro'");

    while($RenPro = mysqli_fetch_assoc($DRen)){

        $aksi = $Komponen->TombolLink("danger","md","fa-trash","hapus","?produksi-tamren-hapus-{$RenPro['IdDetailProduksi']}",""); 
        $TBody .= "1 = top + Line {$RenPro['IdLine']} = center + {$RenPro['Nama']} = center + {$RenPro['Target']} = center + $aksi = center |";
    }

    $THead = "NO = 1 + LINE = 12 + LEADER = 25 + TARGET = 12 + AKSI = 15";


    $tabel = $Komponen->TabelDaftar("100",$THead,$TBody,"","TableFull"); 



    $tglproduksi = date("d-m-Y", strtotime($DProduksi['Tanggal']));

    $lineS = "Line = 2 + $select = 2 | ";
    $dsbl = "readonly";
    $target = "Target = 2 + <input class='form-control' type='number' value='$target' name='target' required> = 2 | ";
    $Tform = "$Bsimpan $Bbaru";
}
else{

    $lineS = "";
    $Target = "";
    $Tform = $Bsimpan;
    $tabel = "";
}


$IForm="
Tanggal = 2 + ".$Komponen->InputGroup("<i class='fa fa-calendar'></i>", "<input class='form-control' type='text' value='$tglproduksi' name='tglproduksi' id='Date' placeholder='dd-mm-yyyy' $dsbl >","")." = 2 |
$lineS
$target
 = 2 + $Tform = 9 |
";

$form=$Komponen->FormHorizontal($IForm);

$TKonten = $Komponen->TombolLink("info","md","fa-arrow-left","Kembali","?produksi-daftar","");
$JdSiteTam="Tambah Rencana Produksi";
$JdKonten = "Tambah Rencana Produksi";
$Konten = "
$alert
$form			
$tabel
"; 