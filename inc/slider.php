<section class="main-slider style-two">
    <div class="main-slider-carousel owl-carousel owl-theme">
        <?php

        $sliderpram = array();
        $sliders = $core->getslider($sliderpram);
        $ie = 0;
        foreach ($sliders as $i => $slider) {
        ?>
            <div class="slide">
                <img src="images/<?= $slider["image"] ?>" alt="welcome to " />
                <div class="decrepation-sl">
                    <div class="container">
                        <div class="content alternate">
                            <h1 class="">
                                <?= $slider["title"] ?>
                            </h1>
                            <p class="title">
                                <?= $slider["description"] ?>
                            </p>
                            <a href="<?= $core->getPageUrl(1) ?>" class="theme-btn btn-style-one">
                                <span class="btn-title">Who We Are <i class="fa fa-angle-right"></i></span>
                            </a>
                            <a href="#" class="theme-btn btn-style-five"><span class="btn-title">Become A Member</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>