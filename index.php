<?php
$pagg = 1;
include "inc.php";
/*
$lang : get form  inc.php  = arabic || english;
$plang : get form  inc.php for  php file name  = arabic || "";
$clang : get form  inc.php for column name  =  _arabic || "" ;
*/
function getName($url)
{
    // echo $url . "<br>";
    $url = explode("/", trim($url, "/"));
    return str_replace("-", " ", end($url));
}
function saveFile($file, $html = null)
{
    global $core, $site_url;
    $img = 'images/';
    $file = (strpos($file, $site_url) === false ? $site_url : "") . $file;
    $name = basename($file); // to get file name
    $ext = pathinfo($file, PATHINFO_EXTENSION); // to get extension
    $name2 = pathinfo($file, PATHINFO_FILENAME);
    $img .=  $name;
    //if (!file_exists($img))
    //echo $file . "<br />";
    //echo $html;
    //if (!file_exists($img))
    /// file_put_contents($img, (!$html ? $core->getPage($file) : $html));
    return $img;
}
// echo saveFile("https://www.ashrae.org/image%20library/main%20nav/about/aboutashrae.png");
// die();
function getAllPages($purl, $id = 0, $do = true)
{
    global $core, $site_url;
    $url = $site_url;
    $pages = [];

    $title = getName($purl);
    $sel = $core->getData("pages", ["title" => $title]);
    if (!$do && $sel[0]["content"]) {
        return $sel[0]["id"];
    }
    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    if ($sel && $sel[0]["content"])
        $html = $sel[0]["content"];
    else
        $html = $core->getHtml($purl);
    //echo $html;
    // die();
    if (!$html)
        return $id;
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    //$dom = $dom->getElementById("ctl01_PageZoneContainer1");
    $variable = $dom->getElementsByTagName("img");
    foreach ($variable as $key => $value) {
        $a = $value->getAttribute("src");
        $a =   saveFile($a);
        $value->setAttribute("src", $a);
    }
    $id = $core->CheckSQl("pages", ["title" => $title, "menu" => ($do ? 1 : 0), "active" => 1, "level" => $id]);
    $variable = $dom->getElementsByTagName("a");
    foreach ($variable as $key => $value) {
        $a = $value->getAttribute("href");
        if (strpos($a, $url) !== false && strpos($a, "#") === false && strpos($a, "page.php") === false) {
            //$html = $core->getHtml($a);
            $html = $core->getPage($a, 1);
            if (!$html[0] || strpos($a, ".pdf") !== false) {
                $a =   saveFile($a, $html[1]);
            } else if ($do) {
                if (!in_array($a, $pages))
                    $pages[] = $a;
                $id2 = $core->CheckSQl("pages", ["title" => getName($a), "menu" => 0, "active" => 1, "level" => $id]);
                $a = $core->getPageUrl($id2);
            }
            $value->setAttribute("href", $a);
        } else if (strpos($a, $url) !== false && strpos($a, "#") !== false) {
            $surl = parse_url($a);
            $value->setAttribute("href", "#" . $surl["fragment"]);
        }
    }
    foreach ($pages as $key => $value) {
        getAllPages($value, $id, false);
    }
    //$html = $core->DOMinnerHTML($dom);
    $html = $dom->saveHTML();
    // echo $html;
    //die();
    return $core->CheckSQl("pages", ["title" => $title, "active" => 1, "content" => $html, "id" => $id]);
}

if (isv("get")) {
    $site_url = "https://www.ashrae.org/";
    $html = $core->getPage($site_url);
    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $els = $core->getElementsByClassName($dom, "is-mega", "li");
    //echo count($els);
    foreach ($els as $key => $value) {
        if ($value->getAttribute("done"))
            continue;

        $id = 0;
        $a = $value->getElementsByTagName("a")[0];
        $l = $core->getElementsByClassName($a, "icon-link-ext", "i", "class");
        $link = "";
        if ($l || strpos($a->getAttribute("href"), "pdf") !== false) {
            $link = $a->getAttribute("href");
            if (strpos($link, "pdf") !== false)
                $link = saveFile($site_url . $link);
        }
        //echo $link;
        //die();
        // $html = $core->getHtml($url . $a->getAttribute("href"));
        if ($link)
            $id = $core->CheckSQl("pages", ["title" => $a->textContent, "menu" => 1, "active" => 1, "link" => $link]);
        else
            $id = getAllPages($site_url . $a->getAttribute("href"), 0);

        $els1 = $value->getElementsByTagName("li");
        $value->setAttribute("done", "true");
        //die();
        //$els1 = $core->getElementsByClassName($value, "dropdown", "li", "class", true);
        foreach ($els1 as $v) {
            if ($v->getAttribute("done"))
                continue;
            $a = $v->getElementsByTagName("a")[0];
            $l = $core->getElementsByClassName($a, "icon-link-ext", "i", "class");
            $link = "";
            if ($l || strpos($a->getAttribute("href"), "pdf") !== false) {
                $link = $a->getAttribute("href");
                if (strpos($link, "pdf") !== false)
                    $link = saveFile($site_url . $link);
            }
            $v->setAttribute("done", "true");
            if (!$link)
                $id2 =  getAllPages($site_url . $a->getAttribute("href"), $id);
            else
                $id2 = $core->CheckSQl("pages", ["title" => $a->textContent, "menu" => 1, "active" => 1, "level" => $id, "link" => $link]);
            $els2 =  $v->getElementsByTagName("li");
            foreach ($els2 as $v1) {
                if ($v1->getAttribute("done"))
                    continue;
                $a1 = $v1->getElementsByTagName("a")[0];
                $l = $core->getElementsByClassName($a1, "icon-link-ext", "i", "class");
                $link = "";
                if ($l || strpos($a1->getAttribute("href"), "pdf") !== false) {
                    $link = $a1->getAttribute("href");
                    if (strpos($link, "pdf") !== false)
                        $link = saveFile($site_url . $link);
                }
                if (!$link)
                    getAllPages($site_url . $a1->getAttribute("href"), $id2);
                else
                    $core->CheckSQl("pages", ["title" => $a1->textContent, "menu" => 1, "active" => 1, "level" => $id2, "link" => $link]);

                $v1->setAttribute("done", "true");
            }
            //$v->setAttribute("done", "true");
        }
    }
    die();
}
?>
<!-- About Section Four -->
<section class="about-section-four">
    <div class="auto-container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="image-block">
                    <div class="image-one wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="image-box"><img class="" src="images/about.jpg" alt="" /></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="sec-title style-four">
                    <h2>
                        ASHRAE Task Force <br> for Building
                        Decarbonization
                    </h2>
                    <span class="text-decoration-three"></span>
                </div>
                <div class="text">
                    <?= getValue('home_text', $lang) ?>
                </div>

                <div class="link-btn">
                    <a href="<?= $core->getPageUrl(1) ?>" class="theme-btn btn-style-one">
                        <span class="btn-title">Read More <i class="fal fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>


        </div>
    </div>
</section>


<!-- Services Section five -->
<section class="services-section-five">
    <div class="auto-container">
        <div class="top-content row m-0 justify-content-between">
            <div class="sec-title style-four">
                <h2>communities</h2>
                <span class="text-decoration-three"></span>
            </div>


            <div class="link-btn">

                <a href="<?= $core->getPageUrl(412) ?>" class="theme-btn btn-style-one"><span class="btn-title">More <i class="fal fa-arrow-right"></i></span></a>


            </div>


        </div>
        <div class="row">
            <?php $variable = $core->getData('pages', 'where level=412 and special=1');
            foreach ($variable as $k => $v) { ?>
                <div class="col service-block-five">
                    <div class="inner-box">
                        <a href="<?= $core->getPageUrl($v) ?>" title="" class="content-box">
                            <div class="icon"><img src="images/<?= $v["image"] ?>" alt="<?= $v["title"] ?>"></div>
                            <h4><?= $v["title"] ?></h4>
                        </a>
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>
</section>



<section class="cases-section">
    <div class="auto-container">
        <div class="row">
            <?php $variable = $core->getData('ads', ["active" => 1, "special" => 1]);
            foreach ($variable as $k => $v) { ?>
                <div class="col-lg-3 col-6 case-block-one">
                    <div class="inner-box">
                        <div class="image">
                            <img class="" src="images/<?= $v["image"] ?>" alt="<?= $v["title"] ?>">
                        </div>
                        <div class="overlay">
                            <div class="title"><span class="icon"><img src="images/wlogo.png" alt=""></span></div>
                            <div class="link-btn"><a href="<?= $v["link"] ?>"><i class="flaticon-right-arrow"></i></a>
                            </div>
                            <div class="content">
                                <h4><?= $v["title"] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            <?php  } ?>


        </div>
    </div>
</section>




<section class="cta-section-two" style="background-image: url(images/bg-5.jpg);">
    <div class="auto-container">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <h2><span class="flaticon-team"></span> ashrae members
                </h2>
                <p>
                    With more than 50,000 members from over 132 nations,
                    ASHRAE is a diverse organization dedicated to
                    advancing the arts and sciences of heating,
                    ventilation, air conditioning and refrigeration to
                    serve humanity and promote a sustainable world.</p>
            </div>
            <div class="col-lg-3">
                <div class="wrapper-box">
                    <a href="#" class="theme-btn btn-style-one"><span class="btn-title">Become A Member</span></a>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Services Section Four -->
<section class="services-section-four">
    <div class="sec-bg" style="/*!background-image: url(images/bg-24.jpg);*/"></div>
    <div class="auto-container">
        <div class="sec-title style-four text-center">
            <h2>Professional Development</h2>
            <span class="text-decoration-two"></span>
        </div>
        <div class="owl-carousel serv-slider custom-nav">
            <?php $variable = $core->getData('pages', 'where level=342 and special=1');
            foreach ($variable as $k => $v) { ?>
                <div class="service-block-four">
                    <div class="inner-box">
                        <div class="image-box">
                            <img class=" " src="images/<?= $v["image"] ?> " alt="<?= $v["title"] ?> ">
                            <div class="icon-box">
                                <h4><?= $v["title"] ?> </h4>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>



        </div>
    </div>
</section>



















<!-- News Section five -->
<section class="news-section-five" style="background-image: url(images/image-4.jpg);">
    <div class="auto-container">
        <div class="sec-title light text-center">
            <h2>upcoming events</h2>
            <span class="text-decoration-two"></span>
        </div>
        <div class="row">
            <?php $variable = $core->getData('events', 'where active=1 and special=1');
            foreach ($variable as $k => $v) {
                $date = getDateTime($v["date"], $lang);
            ?>
                <div class="news-block-five col-lg-4">
                    <div class="inner-box">
                        <div class="row m-0 justify-content-between">
                            <div class="date"><strong><?= $date[0] ?></strong><?= $date[1] ?> <?= $date[2] ?>
                            </div>
                        </div>
                        <div class="category"><?= $v["location"] ?></div>
                        <h4><a href="<?= $core->getPageUrl($v, "events") ?>"><?= $v["title"] ?></a></a></h4>
                        <div class="row m-0 justify-content-between align-items-center">
                            <div class="read-more-btn"><a href="<?= $core->getPageUrl($v, "events") ?>">Read More
                                    <i class="fal fa-arrow-right"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>


<!-- Testimonial Section Five -->
<section class="testimonial-section-five">
    <div class="quote"><img src="images/icon-37.png" alt=""></div>
    <div class="auto-container">
        <div class="testimonial-outer">
            <div class="testimonial-carousel">
                <div class="row m-0 align-items-end">
                    <div class="col-xl-6 p-0">
                        <div class="swiper-container testimonial-content wow fadeInUp" data-wow-delay="300ms">
                            <div class="swiper-wrapper">
                                <?php $variable = $core->getData('testimonials', ["active" => 1]);
                                foreach ($variable as $k => $v) { ?>
                                    <div class="swiper-slide">
                                        <!-- Testimonial Block Five -->
                                        <div class="testimonial-block-five">
                                            <div class="inner-box">
                                                <div class="logo"><img src="images/logo.png" alt=""></div>
                                                <h4> <?= $v["title"] ?></h4>
                                                <div class="text">
                                                    <?= $v["description"] ?>
                                                </div>
                                                <div class="rating">
                                                    <?php
                                                    for ($i = 0; $i < $v["rating"]; $i++) {
                                                    ?>
                                                        <span class="flaticon-star"></span>

                                                    <?php }  ?>

                                                </div>
                                                <div class="author-title">
                                                    <?= $v["name"] ?> <span class="designation"> <?= $v["role"] ?></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <div class="swiper-nav-button">
                                <!-- Add Arrows -->
                                <div class="swiper-button-next"><i class="flaticon-right-arrow"></i>
                                </div>
                                <div class="swiper-button-prev"><i class="flaticon-right-arrow"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 p-0">
                        <!-- Swiper -->
                        <div class="swiper-container testimonial-thumbs">
                            <div class="swiper-wrapper">
                                <?php $variable = $core->getData('testimonials', ["active" => 1]);
                                foreach ($variable as $k => $v) { ?>
                                    <div class="swiper-slide">
                                        <div class="author-thumb"><img src="images/<?= $v["image"] ?>" alt=""></div>
                                    </div>
                                <?php }  ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>








<div class="section featureBlock--six">
    <div class="contained">
        <div class="row h-flushSides">
            <div class="column col-md-4 col-12">
                <figure class="featureBlock-figure">
                    <a class="" href="<?= $core->getPageUrl(1123) ?>">
                        <img alt="" src="images/single-service-5.jpg" />
                    </a>
                    <figcaption class="featureBlock-figcaption">
                        <h3 class="featureBlock-subHeading">
                            Connect-a-Colleague</h3>

                        <p>Invite your colleagues to join the ASHRAE
                            community today. Connect-a-Colleague offers
                            a quick, pre-written (and customizable)
                            email invitation to join. It’s a win-win.
                        </p>

                        <a href="<?= $core->getPageUrl(1123) ?>" class="theme-btn btn-style-five">
                            <span class="btn-title">Read More </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
            <div class="column col-md-4 col-12">
                <figure class="featureBlock-figure">
                    <a class="" href="<?= $core->getPageUrl(8) ?>#m2m">
                        <img alt="" src="images/single-service-6.jpg" />
                    </a>
                    <figcaption class="featureBlock-figcaption">
                        <h3 class="featureBlock-subHeading">Lucy’s
                            Engineering Adventure</h3>

                        <p>Grab your hard hats and let’s go on <i>Lucy’s
                                Engineering Adventure</i>, a new
                            children’s book from ASHRAE.</p>

                        <a href="<?= $core->getPageUrl(8) ?>#m2m" class="theme-btn btn-style-five">
                            <span class="btn-title">Read More </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
            <div class="column col-md-4 col-12">
                <figure class="featureBlock-figure">
                    <a class="" href="<?= $core->getPageUrl(1001) ?>">
                        <img alt="" src="images/single-service-7.jpg" />
                    </a>
                    <figcaption class="featureBlock-figcaption">
                        <h3 class="featureBlock-subHeading">HVAC Design
                            Training</h3>

                        <p>Intensive, practical training comprised of a
                            series of four different training sessions.
                            ASHRAE offers several dates and locations,
                            with options for in-person and virtual.
                            Claim your spot today.</p>

                        <a href="<?= $core->getPageUrl(1001) ?>" class="theme-btn btn-style-five">
                            <span class="btn-title">Read More </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
            <div class="column col-md-4 col-12">
                <figure class="featureBlock-figure">
                    <a class="" href="<?= $core->getPageUrl(127) ?>">
                        <img alt="" src="images/single-service-8.jpg" />
                    </a>
                    <figcaption class="featureBlock-figcaption">
                        <h3 class="featureBlock-subHeading">ASHRAE
                            Newsletters</h3>

                        <p>
                            ASHRAE emails, at no cost, a variety of
                            information to members and the general
                            public at regular intervals. Subscribe to
                            the newsletters of interest to you and see
                            what you are eligible to receive as an
                            ASHRAE
                            member.<br />
                        </p>

                        <a href="<?= $core->getPageUrl(127) ?>" class="theme-btn btn-style-five">
                            <span class="btn-title">Read More </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
            <div class="column col-md-4 col-12">
                <figure class="featureBlock-figure">
                    <a class="" href="<?= $core->getPageUrl(352) ?>">
                        <img alt="" src="images/single-service-9.jpg" />
                    </a>
                    <figcaption class="featureBlock-figcaption">
                        <h3 class="featureBlock-subHeading">Affordable
                            and Convenient: ASHRAE eLearning</h3>

                        <p>
                            Need quick, affordable learning for yourself
                            or a group? ASHRAE eLearning courses are
                            just $42 for members with discounts
                            available for groups of 5 or more. Browse
                            the recently updated eLearning catalog of
                            over
                            90 available courses for convenient,
                            on-demand learning with PDHs.
                        </p>

                        <a href="<?= $core->getPageUrl(352) ?>" class="theme-btn btn-style-five">
                            <span class="btn-title">Read More </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
            <div class="column col-md-4 col-12">
                <figure class="featureBlock-figure">
                    <a class="" href="<?= $core->getPageUrl(241) ?>">
                        <img alt="" src="images/image-22.jpg" />
                    </a>
                    <figcaption class="featureBlock-figcaption">
                        <h3 class="featureBlock-subHeading">ASHRAE
                            Journal Podcast</h3>

                        <p>Tune into conversations between leading
                            ASHRAE experts as they discuss what HVAC
                            engineers need to know to design better
                            systems and grow the HVAC&amp;R industry.
                        </p>

                        <a href="<?= $core->getPageUrl(241) ?>" class="theme-btn btn-style-five">
                            <span class="btn-title">Read More </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>
</div>




<!--  News Section Three  -->
<section class="news-section-three style-two">
    <div class="auto-container">
        <div class="sec-title style-four text-center">
            <h2>Latest news</h2>
            <span class="text-decoration-three"></span>
        </div>
        <div class="owl-carousel blog-slider custom-nav">
            <?php $variable = $core->getData('pages', 'where level=54 and special=1');
            foreach ($variable as $k => $v) {
                $date = getDateTime($v["date"], $lang);
            ?>
                <div class="news-block-three">
                    <div class="inner-box">
                        <div class="image">
                            <a href="<?= $core->getPageUrl($v) ?>"><img class="" src="images/<?= $v["image"] ?>" alt=" <?= $v["title"] ?>" /></a>
                        </div>
                        <div class="lower-content">

                            <ul class="post-meta">
                                <li><a href=""><?= $date[0] ?> <?= $date[1] ?>, <?= $date[2] ?></a></li>
                            </ul>
                            <h4>
                                <a href="<?= $core->getPageUrl($v) ?>">
                                    <?= $v["title"] ?>
                                </a>
                            </h4>
                            <a href="<?= $core->getPageUrl($v) ?>" class="read-more-link">Read More<i class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Subscribe 

<section class="contact-section">
        <div class="auto-container">

            <div class="subscribe-newsletter">
                <div class="sec-title style-two light text-center">
                    <h2><span class="flaticon-endless"></span> Newsletter Subscription</h2>
                    <div class="text">Subscribe us and get news, offers and all updates in ashrae to  your inbox directly</div>
                </div>
                <form action="#">
                    <div class="form-group">
                        <i class="flaticon-mail"></i>
                        <input type="text" placeholder="Enter your email address...">
                        <button type="submit" class="btn-style-four"><span class="btn-title">Subscribe</span></button>
                    </div>
                </form>
            </div>
        </div>
    </section>

Newsletter -->

<div class="subscribe-newsletter-two" style="background-image: url(images/bg-11.png);">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Newsletter.</h2>
                        <div class="text">Subscribe us and get news,
                            offers and all updates in ashrae to your
                            inbox directly</div>
                    </div>
                    <div class="col-md-6">
                        <form action="#" method="post">
                            <div class="form-group">
                                <i class="flaticon-mail"></i>
                                <input type="email" placeholder="Enter your email...">
                                <button type="submit" value="subscribe" name="subscribe" class="theme-btn"><span class="flaticon-right"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div></div>
            </div>
        </div>
    </div>
</div>


<?php
include "inc/footer.php";
?>