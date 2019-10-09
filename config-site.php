<?php
/*
Nusantara Global
Team : Nans, M. Rifki
*/

$user = $Query->TampilSatu("","pegawai","RegPegawai='{$_SESSION['idUser']}'");

//Browser
$IcoBrowser="ng.jpg";

//Footer
$FYear="2019";
$FVersion="<strong>Version 1.0.0</strong>";
$FSupport="<a href='' style='text-decoration:none'>PT Handsome</a>";
$FInstansi="PT Handsome";
$JdSite="Productifity";

//SidebarHeader
$SHeaderLong="Productifity";
$SHeaderShort="AB";

//NavbarHeader
$NHImages="images/avatar-5.jpg";
$NHName=$user['Nama'];
$NHKeterangan="Hai, Saya {$user['Nama']}";

//Konfigurasi dashboard
$SkinDashboard="blue";
$WarnaCardBody="primary";
?>