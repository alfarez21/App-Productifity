<?php
/*
Nusantara Global
Team : Nans, M. Rifki
*/

error_reporting(0);
session_start();
date_default_timezone_set("Asia/Jakarta");

include("common/Koneksi.php");
include("config.php");
include("common/Query.php");
include("common/Komponen.php");
include("config-site.php");
include("common/link.php");

if(!$kon)
{
	echo $Komponen->AlertServer($Jd="NoConect",$Icon="user",$Ket="Tidak konek");
}

// include("template/dashboard/dashboard.php");

if(strtolower($_SERVER['QUERY_STRING'])=="logout"){
	session_destroy();
	$Komponen->Redirect('');
}
else
{
	if(isset($_SESSION['login'])){
		include("template/dashboard/dashboard.php");
	}
	else{
		include("pages/login.php");
	}

}


?>