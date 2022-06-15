<?php if (isset($_POST["subscribe"])) {

    $text =  $_POST["name"] . "<br>" . $_POST["email"];

    require("class.phpmailer.php");

    $mail = new PHPMailer();

    $mail->IsSMTP();

    $mail->Host = "mail.sherktk.net";



    $mail->SMTPAuth = true;

    //$mail->SMTPSecure = "ssl";

    $mail->Port = 587;

    $mail->Username = "mail@sherktk.net";

    $mail->Password = "JCrS%^)qc!eH";



    $mail->From = "mail@sherktk.net";



    $mail->FromName = $name;

    $info_media["code"] = "email";

    $contents = $core->getinfo_media($info_media);

    $emaills = $contents[0]["link"];

    $mail->AddAddress($emaills);

    //$mail->AddReplyTo("mail@mail.com");

    $mail->IsHTML(true);

    $mail->Subject = "Subscribe";

    $mail->Body = $text;



    //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";



    $core->addemail(array("email" => $_POST["email"]));

    if ($mail->Send()) {

?>



        <script type="text/javascript">
            alert("Thank you !!");
        </script>



    <?php

    } else { ?>

        <script type="text/javascript">
            alert("<?= trim(htmlspecialchars_decode(str_replace("</p>", " ", str_replace("<p>", " ", $mail->ErrorInfo)))) ?>");
        </script>

<?php  }
} ?>





<!-- Main Footer -->

<footer class="main-footer style-five">

    <div class="auto-container">

        <!--Widgets Section-->

        <div class="widgets-section">

            <div class="row clearfix">





                <div class="col-md-3 col-12">

                    <div class="footer-widget logo-widget">

                        <div class="widget-content">

                            <div class="footer-logo">

                                <a href=""><img class="" src="images/wlogo.png" alt="" /></a>

                            </div>

                            <div class="text"><?= getValue('footer_text', $lang) ?></div>

                        </div>

                    </div>

                </div>



                <div class="col-md-2 col-12">

                    <div class="footer-widget links-widget slap">

                        <h3 class="widget-title">quick links</h3>

                        <div class="widget-content">

                            <ul>

                                <?php $variable = $core->getData('pages', ["active" => 1, "menu" => 1, "level" => 0, "footer" => 0]);

                                foreach ($variable as $k => $v) { ?>

                                    <li><a href="<?= $core->getPageUrl($v) ?>"><?= $v["title"] ?></a></li>

                                <?php  } ?>

                            </ul>

                        </div>

                    </div>

                </div>







                <div class="col-md-4 col-12">

                    <div class="footer-widget links-widget gla">

                        <h3 class="widget-title">communities</h3>

                        <div class="widget-content">

                            <ul>

                                <?php $variable = $core->getData('pages', ["active" => 1, "menu" => 1, "level" => 412, "footer" => 0]);

                                foreach ($variable as $k => $v) { ?>

                                    <li><a href="<?= $core->getPageUrl($v) ?>"><?= $v["title"] ?></a></li>

                                <?php  } ?>



                            </ul>

                        </div>

                    </div>

                </div>













                <div class="col-lg-3 col-12">

                    <div class="footer-widget contact-widget">

                        <h3 class="widget-title">Contact Details</h3>

                        <div class="widget-content">

                            <ul class="list">

                                <li>Call Us : <a href="tel:<?= getValue('mobilepage') ?>"><?= getValue('mobilepage') ?></a>

                                </li>

                                <li>Mail us : <a href="mailto:<?= getValue('email') ?>"><?= getValue('email') ?></a>

                                </li>

                            </ul>

                            <ul class="social-links clearfix">

                                <li><a href="<?= getValue("facebook") ?>" target="_blank"><span class="fab fa-facebook-f"></span></a></li>

                                <li><a href="<?= getValue("twitter") ?>" target="_blank"><span class="fab fa-twitter"></span></a></li>

                                <li><a href="<?= getValue("youtube") ?>" target="_blank"><span class="fab fa-youtube"></span></a></li>

                                <li><a href="<?= getValue("instagram") ?>" target="_blank"><span class="fab fa-instagram"></span></a></li>

                                <li><a href="<?= getValue("linkedin") ?>" target="_blank"><span class="fab fa-linkedin-in"></span></a></li>

                            </ul>

                        </div>

                    </div>

                </div>





            </div>

        </div>

        <!-- Footer Bottom -->

        <div class="footer-bottom">

            <div class="row m-0 justify-content-between">

                <div class="copyright"><a href="">© 2022 Erasoft</a> All

                    Rights Reserved.</div>

                <ul class="menu">

                    <?php $variable = $core->getData('pages', ["active" => 1, "level" => 0, "footer" => 1]);

                    foreach ($variable as $k => $v) { ?>

                        <li><a href="<?= $core->getPageUrl($v) ?>"><?= $v["title"] ?></a></li>

                    <?php } ?>

                </ul>

            </div>

        </div>

    </div>

</footer>



</div>

<!--End pagewrapper-->



<!--Scroll to top-->

<div class="scroll-to-top scroll-to-target style-two" data-target="html">

    <span class="fal fa-arrow-up"></span>

</div>



<script src="js/jquery-3.5.1.min.js"></script>

<script src="js/jquery-ui.min.js"></script>



<script src="js/popper.min.js"></script>

<script src="js/bootstrap.min.js"></script>

<script src="js/bootstrap-select.min.js"></script>

<script src="js/jquery.fancybox.js"></script>

<script src="js/isotope.js"></script>

<script src="js/owl.js"></script>

<script src="js/appear.js"></script>

<script src="js/wow.js"></script>

<script src="js/lazyload.js"></script>

<script src="js/scrollbar.js"></script>

<script src="js/TweenMax.min.js"></script>

<script src="js/swiper.min.js"></script>

<script src="js/jquery.lettering.min.js"></script>

<script src="js/jquery.circleType.js"></script>

<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.validate.js"></script>

<script src="js/93.js"></script>

<script src="js/frontEnd.js"></script>

<script src="js/script.js"></script>

</body>



</html>