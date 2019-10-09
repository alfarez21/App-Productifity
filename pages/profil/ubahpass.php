<?php

$NoReg = $user['RegPegawai'];
$pass = md5(htmlspecialchars(trim($_POST['oldpass'])));
$conpass = md5(htmlspecialchars(trim($_POST['newpass'])));

if(isset($_POST['simpan'])){
    if($pass === $conpass){
        $ubah = $Query->Ubah("Password='$pass'","pegawai","RegPegawai='$NoReg'");  
        if($ubah){
            $alert = $Komponen->Alert("success","Berhasil Diubah","A");
        }
        else{
            $alert = $Komponen->Alert("Danger","Gagal Diubah","A");
        }
    }
    else{
        $alert = $Komponen->Alert("danger","Password Lama Salah","A");        
    }
}
// ======== Input Form ========
$Dinput = "
    Password = 2 + <input class='form-control' type='password' value='$username' name='oldpass' $dsbl required > = 4 | 
    Ubah Password = 2 + <input class='form-control' type='password' value='$nama' name='newpass' $dsbl required > = 4 | 
     = 2 + <button type='submit' name='simpan' class='btn btn-md btn-primary' style='margin-top:5px' data-toggle='tooltip' title='Simpan'><i class='fa fa-floppy-o'></i></button> = 9 |

";


$JdSiteTam = "Ubah Password";
$JdKonten = "Ubah Password";
$TKonten = $Komponen->TombolLink("success","md","fa-arrow-left","Kembali","?profil-form","");
$Konten = $alert.$Komponen->FormHorizontal($Dinput,""); 
