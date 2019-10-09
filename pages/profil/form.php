<?php
// ====== Get Data User =========
$NoReg = $user['RegPegawai'];
$username = $user['Username'];
$nama = $user['Nama'];
$tmplahir = $user['TempatLahir'];
$tgllahir = $user['TanggalLahir'];
$jkelamin = $user['Gender'];

// ====== Ubah Profil ========
if(isset($_POST['simpan'])){
    
    // Get Data Form
    $username = htmlspecialchars(trim($_POST['username']));
	$nama = htmlspecialchars(trim($_POST['nama']));
	$tmplahir = htmlspecialchars(trim($_POST['tmplahir']));
	$tgllahir = htmlspecialchars(trim($_POST['tgllahir']));
    $jkelamin = htmlspecialchars(trim($_POST['jenisKelamin']));
    
	$tgllahir = date("Y-m-d", strtotime($tgllahir));
    
    $Cek = $Query->CekData("pegawai","Username='$username' and Nama='$nama' and TempatLahir='$tmplahir' and TanggalLahir='$tgllahir' and Gender='$jkelamin'");
    if($Cek){
        $alert = $Komponen->Alert("warning","Tidak Ada Yang Ubah","A");
    }
    else{
        $ubah = $Query->Ubah("Username='$username',Nama='$nama',TempatLahir='$tmplahir',TanggalLahir='$tgllahir',Gender='$jkelamin'","pegawai","RegPegawai='$NoReg'");
        if($ubah){
            $alert = $Komponen->Alert("success","Data Berhasil Di Ubah","A");
        }
        else{
            $alert = $Komponen->Alert("danger","Data Gagal Di Ubah","A");
        }
    }
}



//======= Radio Gender =========
if($jkelamin=="L"){
    $lcheck = "checked";
}

if($jkelamin=="P"){
    $pcheck = "checked";
}

// ========== Radio Gender ==============
$radio = $Komponen->InputRadioCheck("radio","Laki Laki","jenisKelamin","L","$lcheck $dsbl")." ".$Komponen->InputRadioCheck("radio","Perempuan","jenisKelamin","P","$pcheck $dsbl");


// ======== Input Form ========
$Dinput = "
    Username = 2 + <input class='form-control' type='text' value='$username' name='username' $dsbl > = 4 | 
    Nama = 2 + <input class='form-control' type='text' value='$nama' name='nama' $dsbl > = 4 | 
    Tempat Lahir = 2 + <input class='form-control' type='text' value='$tmplahir' name='tmplahir' $dsbl> = 4 |
    Tanggal Lahir = 2 + ".$Komponen->InputGroup("<i class='fa fa-calendar'></i>", "<input class='form-control' type='text' value='$tgllahir' name='tgllahir' id='Date' placeholder='dd-mm-yyyy' $dsbl >","")." = 4 |
    Jenis Kelamin = 2 + $radio = 4 | 
     = 2 + <button type='submit' name='simpan' class='btn btn-md btn-primary' style='margin-top:5px' data-toggle='tooltip' title='Simpan'><i class='fa fa-floppy-o'></i></button> = 9 |

";


$JdSiteTam = "Edit Profil";
$JdKonten = "Edit Profil";
$TKonten = $Komponen->TombolLink("success","md","fa-lock","Ubah Password","?profil-ubahpass","");
$Konten = $alert.$Komponen->FormHorizontal($Dinput,""); 
