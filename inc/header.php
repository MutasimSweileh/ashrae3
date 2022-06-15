<?php
ob_start();
session_start();
$issingle = 0;
$engine = array();
$engines = $core->getEngines($engine);
$titlee = $core->getEngines(array("page" => "info" . $plang))[0];
$title = $titlee["title"];
$str = $titlee["title"];
$alt = $titlee["title"];
$alt_ar = "";
$description =  $titlee["description"];
$keywords = $titlee["keywords"];
$name = pathinfo(basename($_SERVER["PHP_SELF"]))["filename"];
$pname = pathinfo(basename($_SERVER["PHP_SELF"]))["filename"];
$pageName = str_replace("arabic", "", $pname);
$exname = pathinfo(basename($_SERVER["PHP_SELF"]))["extension"];
$id = isv("id");
if (is_array(@$engines)) {
    foreach ($engines as $engine) {
        //if(basename($_SERVER["PHP_SELF"]).($_SERVER["QUERY_STRING"] ? "?" . $_SERVER["QUERY_STRING"] : "" ) == $engine["page"]) {
        if ($name . ".php" == $engine["page"]) {
            $exDescription = $engine["description"];
            $exKeywords = $engine["keywords"];
            $exTitle = $engine["title"];
            $id = isv("id");
            if (!$id)
                $id = isv("level");
            $exTitle = $engine["title"];
            if ($id) {
                $array = array("id" => $id);
                $exTitle = (strpos($name, "news") !== false ? $core->getevents($array)[0]["name" . $clang] : (strpos($name, "services") !== false && $core->getservices($array)[0]["name" . $clang] ? $core->getservices($array)[0]["name" . $clang] : (strpos($name, "products") !== false || $pagg == 3 ? $core->getproducts($array)[0]["name" . $clang] : $core->getprojects($array)[0]["name" . $clang])));
                $exTitle = (strpos($name, "page") !== false ? $core->getData("pages", $array)[0]["title" . $clang] : $exTitle);
                $exTitle = (strpos($name, "events") !== false ? $core->getgetData("events", $array)[0]["title" . $clang] : $exTitle);
                $exTitle = (strpos($name, "elevatorcontrollers") !== false ? $core->getData("elevatorcontrollers", $array)[0]["name" . $clang] : $exTitle);
                if (!$exTitle)
                    $exTitle = $engine["title"];
            }
            $pageTitle = $exTitle;
        }
    }
}
if ($id) {
    $array = array("id" => $id);
    $exTitle = (strpos($name, "page") !== false ? $core->getData("pages", $array)[0]["title"] : $exTitle);
    $exTitle = (strpos($name, "events") !== false ? $core->getgetData("events", $array)[0]["title"] : $exTitle);
}
if (@$exTitle) $title = $exTitle  . " | $str";
if (@$exDescription) $description = $exDescription . " | $description";
if (@$exKeywords) $keywords = $keywords . "," . $exKeywords;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Description" content="<?= $description ?>" />
    <title><?= $title ?></title>
    <meta name="keywords" content="<?= $keywords ?>" />
    <!-- responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Css Base And Vendor 
    ===================================-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/fontawesome-all.css" rel="stylesheet" />
    <link href="css/animate.css" rel="stylesheet" />
    <link href="css/custom-animate.css" rel="stylesheet" />
    <link href="css/flaticon.css" rel="stylesheet" />
    <link href="css/newicons.css" rel="stylesheet" />
    <link href="css/owl.css" rel="stylesheet" />
    <link href="css/jquery-ui.css" rel="stylesheet" />
    <link href="css/jquery.fancybox.min.css" rel="stylesheet" />
    <link href="css/scrollbar.css" rel="stylesheet" />
    <link href="css/hover.css" rel="stylesheet" />
    <link href="css/jquery.touchspin.css" rel="stylesheet" />
    <link href="css/botstrap-select.min.css" rel="stylesheet" />
    <link href="css/shop.css" rel="stylesheet" />
    <link href="css/swiper.min.css" rel="stylesheet" />
    <link href="css/color-5.css" rel="stylesheet" />
    <?php if ($pagg != 1) { ?>
        <link href="css/main.css" rel="stylesheet" />
    <?php  } ?>
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <link rel="icon" href="images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <link rel="icon" href="images/favicon.png" type="image/x-icon" />
    <!-- Site Css
    ====================================-->
    <link rel="stylesheet" href="css/style.css" />
    <style>
        .tox.tox-tinymce-inline {
            z-index: 1300;
        }

        .page-title .content-box h1 {
            text-transform: capitalize;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <header class="main-header header-style-four">
            <!-- Header Middle -->
            <div class="header-top style-two">
                <div class="auto-container">
                    <div class="inner">
                        <div class="top-left">
                            <div class="top-left">
                                <ul class="social-links clearfix">
                                    <li>
                                        <a href="<?= getValue("facebook") ?>" target="_blank" title="">
                                            <div class="main-ico"><span class="fab fa-facebook-f"></span></div>
                                            <div class="hover-ico"><span class="facebook fab fa-facebook-f"></span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= getValue("twitter") ?>" target="_blank" title="">
                                            <div class="main-ico"><span class="fab fa-twitter"></span></div>
                                            <div class="hover-ico"><span class="twitter fab fa-twitter"></span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= getValue("linkedin") ?>" target="_blank" title="">
                                            <div class="main-ico"><span class="fab fa-linkedin-in"></span></div>
                                            <div class="hover-ico"><span class="linkedin fab fa-linkedin-in"></span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= getValue("instagram") ?>" target="_blank" title="">
                                            <div class="main-ico"><span class="fab fa-instagram"></span></div>
                                            <div class="hover-ico"><span class="instagram fab fa-instagram"></span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= getValue("youtube") ?>" target="_blank" title="">
                                            <div class="main-ico"><span class="fab fa-youtube"></span></div>
                                            <div class="hover-ico"><span class="youtube fab fa-youtube"></span></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="top-right">
                            <ul class="contact-info-two">
                                <li class=""><a href="<?= $core->getPageUrl("join") ?>">Join</a></li>
                                <li class=""><a href="<?= $core->getPageUrl(430) ?>">Volunteer</a></li>
                                <li class=""><a href="<?= $core->getPageUrl(1132) ?>">Make A Gift</a></li>
                            </ul>
                            <!--
                      <div class="language">
                            <span class="flaticon-global"></span>
                            <form action="#" class="language-switcher">
                                <select class="selectpicker">
                                    <option value="1">English</option>
                                    <option value="1">French</option>
                                    <option value="1">Arabic</option>
                                </select>
                            </form>
                        </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle">
                <div class="auto-container">
                    <div class="outer-box">
                        <div class="wrapper-box">
                            <div class="row align-items-center">
                                <div class="img-mao">
                                    <span>Shaping Tomorrow's Built Environment Today</span>
                                </div>
                                <div class="col-lg-3">
                                    <!--Logo-->
                                    <div class="logo-box">
                                        <div class="logo">
                                            <a href="<?= $core->getPageUrl("index") ?>"><img src="images/logo.png" alt="" /></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="row m-0 justify-content-end">
                                        <div class="link-btn">
                                            <a href="https://www.techstreet.com/ashrae/pages/home" class="theme-btn btn-style-one"><span class="btn-title"><i class="fal fa-book-reader"></i>BookStore</span></a>
                                            <a href="<?= $core->getPageUrl("login") ?>" class="theme-btn btn-style-one"><span class="btn-title"><i class="fal fa-sign-in-alt"></i>login</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Upper -->
            <div class="header-upper style-four">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <!--Nav Box-->
                        <div class="nav-outer clearfix">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler"><img src="images/icon-bar.png" alt="" /></div>
                            <!-- Main Menu -->
                            <nav class="main-menu navbar-expand-md navbar-light">
                                <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <?php $variable = $core->getData('pages', ["active" => 1, "menu" => 1, "level" => 0, "footer" => 0]);
                                        foreach ($variable as $k => $v) { ?>
                                            <li class="dropdown hasChildren is-mega">
                                                <a href="<?= $core->getPageUrl($v) ?>" <?= ($v["link"] ? 'target="_blank"' : "") ?>><?= $v["title"] ?><?= ($v["link"] ? '<i class="icon-link-ext"></i>' : "") ?></a>
                                                <ul>
                                                    <?php $menu = $core->getData('pages', ["active" => 1, "menu" => 1, "level" => $v["id"]]);
                                                    $count = 1;
                                                    $new = 0;
                                                    for ($i = 0; $i < count($menu); $i++) {
                                                        $menu1 = $core->getData('pages', ["active" => 1, "menu" => 1, "level" => $menu[$i]["id"]]);
                                                        if ((count($menu1) - 1 + $count) > 10) {
                                                            $count = 1;
                                                            $new = 1;
                                                            echo '</div>';
                                                        } ?>
                                                        <?= (!$i || $new ? '<div class="mega-column">' : "") ?>
                                                        <li class="<?= ($menu1 ? "" : "dropdown") ?>">
                                                            <a href="<?= $core->getPageUrl($menu[$i]) ?>" <?= ($menu[$i]["link"] ? 'target="_blank"' : "") ?>><?= $menu[$i]["title"] ?><?= ($menu[$i]["link"] ? '<i class="icon-link-ext"></i>' : "") ?></a>
                                                            <?php if ($menu1) { ?>
                                                                <ul class="mega-column--inset">
                                                                    <?php
                                                                    foreach ($menu1 as $k2 => $v2) { ?>
                                                                        <li class=""><a href="<?= $core->getPageUrl($v2) ?>" <?= ($v2["link"] ? 'target="_blank"' : "") ?>><?= $v2["title"] ?><?= ($v2["link"] ? '<i class="icon-link-ext"></i>' : "") ?></a></li>
                                                                    <?php $count++;
                                                                    } ?>
                                                                </ul>
                                                            <?php } ?>
                                                        </li>
                                                        <?= (($i == count($menu) - 1) ||  $count >= 10 ? '</div>' : "") ?>
                                                    <?php
                                                        if ($new)
                                                            $new = 0;
                                                        if ($count >= 10) {
                                                            $count = 1;
                                                            $new = 1;
                                                        } else
                                                            $count++;
                                                    } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </nav>
                            <!-- Main Menu End-->
                            <div class="navbar-right-info">
                                <a href="https://www.techstreet.com/ashrae/pages/home" class="themone"><i class="fal fa-book-reader"></i><span class="btn-title">BookStore</span></a>
                                <a href="#" class="themone"><i class="fal fa-sign-in-alt"></i><span class="btn-title">login</span></a>
                                <button type="button" class="theme-btn search-toggler"><span class="flaticon-search"></span></button>
                                <div class="sidemenu-nav-toggler">
                                    <a id="nav-expander" class="humburger nav-expander side-nav-opener" href="#">
                                        <span class="dot1"></span>
                                        <span class="dot2"></span>
                                        <span class="dot3"></span>
                                        <span class="dot4"></span>
                                        <span class="dot5"></span>
                                        <span class="dot6"></span>
                                        <span class="dot7"></span>
                                        <span class="dot8"></span>
                                        <span class="dot9"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Header Upper-->
            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="fal fa-times"></span></div>
                <nav class="menu-box">
                    <div class="nav-logo">
                        <a href="<?= $core->getPageUrl("index") ?>"><img src="images/wlogo.png" alt="" title="" /></a>
                    </div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
                    <!--Social Links-->
                    <div class="social-links">
                        <ul class="clearfix">
                            <li><a href="<?= getValue("facebook") ?>" target="_blank"><span class="fab fa-facebook-f"></span></a></li>
                            <li><a href="<?= getValue("twitter") ?>" target="_blank"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="<?= getValue("youtube") ?>" target="_blank"><span class="fab fa-youtube"></span></a></li>
                            <li><a href="<?= getValue("instagram") ?>" target="_blank"><span class="fab fa-instagram"></span></a></li>
                            <li><a href="<?= getValue("linkedin") ?>" target="_blank"><span class="fab fa-linkedin-in"></span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- End Mobile Menu -->
            <div class="nav-overlay">
                <div class="cursor" style="top: 413px; left: 501px;"></div>
                <div class="cursor-follower" style="top: 391px; left: 479px;"></div>
            </div>
        </header>
        <!--Search Popup-->
        <div id="search-popup" class="search-popup">
            <div class="close-search theme-btn"><span class="fa fa-close"></span></div>
            <div class="popup-inner">
                <div class="overlay-layer"></div>
                <div class="search-form">
                    <form method="get" action="<?= $core->getPageUrl("search") ?>">
                        <div class="form-group">
                            <fieldset>
                                <input type="search" class="form-control" name="q" value="" placeholder="Search Here" required />
                                <input type="submit" value="Search Now!" class="theme-btn" />
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Hidden Sidebar -->
        <section class="hidden-sidebar close-sidebar">
            <div class="wrapper-box">
                <div class="hidden-sidebar-close"><span class="flaticon-remove"></span></div>
                <div class="logo"><a href="#"><img src="images/logo.png" alt=""></a></div>
                <div class="content">
                    <div class="about-widget-two sidebar-widget">
                        <h3> ASHRAE Task Force </h3>
                        <div class="text">
                            <?= getValue("about", $lang) ?>
                        </div>
                    </div>
                    <div class="sidebar__contact mt-30 mb-20">
                        <h4>Contact Info</h4>
                        <ul>
                            <li class="d-flex align-items-center">
                                <div class="sidebar__contact-icon mr-15">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="sidebar__contact-text">
                                    <a target="_blank" href=""> <?= getValue("headeraddress") ?></a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="sidebar__contact-icon mr-15">
                                    <i class="far fa-phone"></i>
                                </div>
                                <div class="sidebar__contact-text">
                                    <a href=""><?= getValue("mobilepage") ?></a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="sidebar__contact-icon mr-15">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="sidebar__contact-text">
                                    <a href="mailto:<?= getValue("headeremail") ?>"><span class="__cf_email__" data-cfemail=""><?= getValue("headeremail") ?></span></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="sidebar__social">
                        <ul>
                            <li><a href="<?= getValue("facebook") ?>" target="_blank"><span class="fab fa-facebook-f"></span></a></li>
                            <li><a href="<?= getValue("twitter") ?>" target="_blank"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="<?= getValue("youtube") ?>" target="_blank"><span class="fab fa-youtube"></span></a></li>
                            <li><a href="<?= getValue("instagram") ?>" target="_blank"><span class="fab fa-instagram"></span></a></li>
                            <li><a href="<?= getValue("linkedin") ?>" target="_blank"><span class="fab fa-linkedin-in"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php
        if ($pagg != 1 && $pagg != 3) {
            $id = isv("id");
            $data = $core->getData("pages", ["id" => $id, "active" => 1]);
            if ($data[0]["level"]) {
            }
        ?>
            <section class="page-title" style="background-image: url(images/profdev.png);">
                <div class="auto-container">
                    <div class="content-box">
                        <div class="content-wrapper">
                            <div class="title">
                                <h1><?= $data[0]["title"] ?></h1>
                            </div>
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <?php if ($data[0]["level"]) {
                                    $pe = $core->getData("pages", ["id" => $data[0]["level"], "active" => 1]); ?>
                                    <li><a href="<?= $core->getPageUrl($pe[0]) ?>"><?= $pe[0]["title"] ?></a></li>
                                <?php } ?>
                                <li><?= $data[0]["title"] ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (!isv("edit") || !isset($_SESSION["portal_status_UserProfile"]) || 1 == 1) { ?>
                <div class="section h-hard socialShare section--contrastLight">
                    <div class="auto-container" style="display: flex;
    align-content: center;
    justify-content: space-between;
    align-items: center;">
                        <div class="socialShare-inner" style="    text-align: left;
    margin: unset;">
                            <h4 class="socialShare-heading">Share This</h4>
                            <div class="socialShare-icons">
                                <span class="st-custom-button st_twitter_large" data-network="twitter">
                                    <span class="stButton">
                                        <span class="stLarge"> </span>
                                    </span>
                                </span>
                                <span class="st-custom-button st_facebook_large" data-network="facebook">
                                    <span class="stButton">
                                        <span class="stLarge"> </span>
                                    </span>
                                </span>
                                <span class="st-custom-button st_email_large" data-network="email">
                                    <span class="stButton">
                                        <span class="stLarge"> </span>
                                    </span>
                                </span>
                                <span class="st-custom-button st_print_large" data-network="print">
                                    <span class="stButton">
                                        <span class="stLarge"> </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div>
                            <?php if (!isv("edit") && isset($_SESSION["portal_status_UserProfile"])) { ?>
                                <a href="<?= $core->getPageUrl((int)$id) ?>&edit=<?= $id ?>" class="theme-btn btn-style-one"><span style="    padding: 5px;" class="btn-title"><i style="margin-right: 10px;    margin-left: 5px;" class="fal fa-edit"></i>Live Editor</span></a>
                            <?php  } ?>
                            <?php if (isv("edit") && isset($_SESSION["portal_status_UserProfile"])) { ?>
                                <a href="#" class="theme-btn btn-style-one" onclick="saveChanges();return false;"><span style="    padding: 5px;" class="btn-title"><i style="margin-right: 10px;    margin-left: 5px;"><span class="fal fa-edit"></i>Save Changes</span></a>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            <?php }
        } else if ($pagg == 3) {
            $id = isv("id");
            if ($id) {
                $data = $core->getData("events", ["id" => $id, "active" => 1]);
                $title = $data[0]["title"];
            } else
                $title = ucfirst($name);
            ?>
            <div class="pageMeta" style="margin-top: 56px;">
                <div class="pageMeta-inner auto-container">
                    <nav role="navigation" class="navSecondary">
                        <div id="ctl01_ctlBreadcrumbNav_Breadcrumb" class="Breadcrumb">
                            <ul class="navSecondary-breadcrumb">
                                <li><span class="navSecondaryToggle"></span><a href="index.php">Home</a></li>
                                <?php if ($id) { ?>
                                    <li><a href="<?= $core->getPageUrl("events") ?>">Events</a></li>
                                <?php   } ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="section section--contrastLight pageTitle pageTitle--center " style="background-image:url(https://www.ashrae.org/Image%20Library/Global%20Content/Banners/Skylines/profdev.png)">
                <div class="contained">
                    <div class="pageTitleCopy">
                        <h1 id="ctl01_ctlPageTitle_cltitle" class="pageTitleCopy-heading">
                            <?= $title ?>
                        </h1>
                    </div>
                </div>
            </div>
        <?php } ?>