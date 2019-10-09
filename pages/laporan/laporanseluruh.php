<?php
if($user['IdLevel']!=2){
    $Komponen->Redirect("");
    die;
}
$Bdetail = $Komponen->TombolLink("info","md","fa-plus-square","Detail","","");
$Bhapus = $Komponen->TombolLink("danger","md","fa-plus-square","hapus","","");

$aksi = "$Bdetail $Bhapus";

$THead = "NO = 1 + WAKTU = 25 + TARGET = 12 + PRESNTESE = 12 + HASIL = 15 + AKSI = 15";
$TBody = "1 = top + 21-05-01 = center + 1200 = center + 0 = center + 0% = center + $aksi = center |";


$jnislap = $_POST['jnislap'];
$dat = $_POST['dat'];
$thn = $_POST['thn'];
$blmthn = $_POST['blmthn'];

if($jnislap==1){
    $sltd2 = "selected";
    $inpt = "Tahun = 2 + ".$Komponen->InputGroup("<i class='fa fa-calendar'></i>", "<input class='form-control' type='text' value='$thn' name='thn' placeholder='yyyy' maxlength='4'>","")." = 2 | ";

    $SQL = $Query->customQuery("SELECT * FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE year(Tanggal) = '$thn' GROUP BY detail_produksi.IdLine");

    $DtLap = $SQL;
    if($thn=="" || mysqli_num_rows($SQL)==0){
        $bulan = "<th colspan='3' style='text-align:center'>-</th>";
        $tr = "
            <tr>
                <td>Data Kosong</td>
            </tr>
        ";
    }
    else{
        
        $SQL2 = $Query->customQuery("SELECT month(Tanggal) as mnt FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE year(Tanggal) = '$thn' GROUP BY month(Tanggal)");

        while ($DL = mysqli_fetch_assoc($SQL2)) {
        
            $bln = $Komponen->NBulan($DL['mnt']);

            $arBln[] = $DL['mnt'];

            $bulan .= "<th colspan='3' style='text-align:center'>$bln</th>";
            $th .= "
            <th style='width:50px;text-align:center'>Target</th>
            <th style='width:50px;text-align:center'>Output</th>
            <th style='width:50px;text-align:center'>%</th>
            ";

        }

        $no = 1;
        while ($DLap = mysqli_fetch_assoc($DtLap)) {
            
            $line = $DLap['IdLine'];
            $tr .="
            <tr>
                <td>$no</td>
                <td>Line $line</td>
            ";
            
            $DtLap2 = $Query->customQuery("SELECT month(Tanggal) as Mon FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE year(Tanggal) = '$thn' AND detail_produksi.IdLine=$line GROUP BY month(Tanggal)");
            $a = 0;
            while ($DLap2 = mysqli_fetch_assoc($DtLap2)) {

                $month = $DLap2['Mon'];

                $DtLap3 = $Query->customQuery("SELECT SUM(Target) as target,SUM(HasilProduksi) as hasil FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE month(Tanggal) = '$month' AND detail_produksi.IdLine=$line");
        
                while ($DLap3 = mysqli_fetch_assoc($DtLap3)) {
                    
                    $target = $DLap3['target'];
                    $hasil = $DLap3['hasil'];
                    $presentase = round($hasil/$target*100);
                    
                    if($month!=$arBln[$a]){
                        $tr .="
                            <td style='text-align:center'>-</td>
                            <td style='text-align:center'>-</td>
                            <td style='text-align:center'>-</td>
                        ";
                    }
                    $tr .="
                        <td style='text-align:center'>$target</td>
                        <td style='text-align:center'>$hasil</td>
                        <td style='text-align:center'>$presentase</td>
                    ";
                }

                $a++;

            }

            $tr .="</tr>";
        
            $no++;
        }
     
    }
}

if($jnislap==2){
    $sltd3 = "selected";
    $inpt = "Bulan-Tahun = 2 + ".$Komponen->InputGroup("<i class='fa fa-calendar'></i>", "<input class='form-control' type='text' value='$blmthn' name='blmthn' placeholder='mm-yyyy' maxlength='7'>","")." = 2 | ";
    
    $blmthn = explode("-",$blmthn);
    $bln = $blmthn[0];
    $thn = $blmthn[1];

    $SQL = $Query->customQuery("SELECT * FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE year(Tanggal) = '$thn' AND month(Tanggal) = '$bln' GROUP BY detail_produksi.IdLine");

    $DtLap = $SQL;
    if($blmthn=="" || mysqli_num_rows($SQL)==0){
        $bulan = "<th colspan='3' style='text-align:center'>-</th>";
        $tr = "
            <tr>
                <td>Data Kosong</td>
            </tr>
        ";
    }
    else{
        
        $SQL2 = $Query->customQuery("SELECT month(Tanggal) as mnt,day(Tanggal) as tgl FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE year(Tanggal) = '$thn' AND month(Tanggal) = '$bln' GROUP BY day(Tanggal)");

        while ($DL = mysqli_fetch_assoc($SQL2)) {
        
            $buln = $Komponen->NBulan($DL['mnt']);
            $tgl = $DL['tgl'];

            $arTgl[] = $DL['tgl'];
            $bulan .= "<th colspan='3' style='text-align:center'>$tgl $buln</th>";
            $th .= "
                <th style='width:50px;text-align:center'>Target</th>
                <th style='width:50px;text-align:center'>Output</th>
                <th style='width:50px;text-align:center'>%</th>
            ";

        }
        
        $no = 1;
        while ($DLap = mysqli_fetch_assoc($DtLap)) {
            
            $line = $DLap['IdLine'];
            $tr .="
            <tr>
                <td>$no</td>
                <td>Line $line</td>
            ";
            
            $DtLap2 = $Query->customQuery("SELECT month(Tanggal) as Mon, day(Tanggal) as  Dy FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE year(Tanggal) = '$thn' AND month(Tanggal) = '$bln' AND detail_produksi.IdLine=$line ORDER BY day(Tanggal)");
            $a = 0;
            while ($DLap2 = mysqli_fetch_assoc($DtLap2)) {

                $month = $DLap2['Mon'];
                $day = $DLap2['Dy'];

                $DtLap3 = $Query->customQuery("SELECT Target as target,HasilProduksi as hasil,day(Tanggal) as TGL FROM detail_produksi JOIN produksi USING(RegProduksi) WHERE day(Tanggal) = '$day' AND month(Tanggal) = '$month'AND year(Tanggal) = '$thn' AND detail_produksi.IdLine = $line");
                while ($DLap3 = mysqli_fetch_assoc($DtLap3)) {
            
                    $target = $DLap3['target'];
                    $hasil = $DLap3['hasil'];
                    $tang = $DLap3['TGL'];
                    $presentase = round($hasil/$target*100);
            
                    if($tang!=$arTgl[$a]){
                        $tr .="
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        ";
                    }
                    
                    $tr .="
                    <td>$target</td>
                    <td>$hasil</td>
                    <td>$presentase</td>
                    ";
                    
                    
                    
                }
                
                $a++;
            }

            $tr .="</tr>";
        
            $no++;
        }
     
    }

}

$tabel = "
<div class='table-responsive'>
    <table class='table table-bordered' style='width:auto'>
        <thead>
            <tr>
                <th rowspan='2'>No</th>
                <th rowspan='2' style='width:150px'>Line</th>
                $bulan
            </tr>
            <tr>
                $th
            </tr>
        </thead>
        <tbody>
            $tr
        </tbody>
    </table>
</div>
"; 

if($jnislap==0){
    $tabel = "";
    $sltd1 = "selected";
}

$select = "
<select name='jnislap' class='form-control select2 custom-select' onchange='submit()'  $dsbl>
    <option $sltd1 value='0'>Jenis Laporan</option>
    <option $sltd2 value='1'>Tahunan</option>
    <option $sltd3 value='2'>Bulanan</option>
</select>
";
    
$IForm="
Jenis Laporan = 2 + $select = 2 | 
$inpt
 = 2 + <button type='submit' name='simpan' class='btn btn-md btn-primary' style='margin-top:5px' data-toggle='tooltip' title='Lihat'><i class='fa fa-eye'></i></button> = 9 |
";

$form=$Komponen->FormHorizontal($IForm);

$JdSiteTam="Laporan Hasil Produksi";
$JdKonten = "Laporan Hasil Produksi";
$Konten = "
$form			
$tabel
"; 