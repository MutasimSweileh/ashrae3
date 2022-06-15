<?php
include_once("classes/core.php");
$core = new core;
include("inc/inc_formemail.php");
$name = pathinfo(basename($_SERVER["PHP_SELF"]))["filename"];
$lang = (strpos($name, "arabic") ? "arabic" : "english");
$plang = ($lang == "arabic" ? $lang : "");
$clang = ($lang == "english" ? "" : "_arabic");
include  "inc/header.php";
if ($pagg == 1)
    include  "inc/slider.php";
$s_type = "services";
$s_type = "products";
if (strpos($pname, "product") !== false || strpos($pname, "services") !== false)
    $s_type = str_replace("arabic", "", $pname);

//if(strpos($FUr,"php") === false)
//header("Location: indexarabic.php");
$s_img = "about.jpg";
