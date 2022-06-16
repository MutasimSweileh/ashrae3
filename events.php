<?php

$pagg = 3;

include "inc.php";

$id = isv("id");

if ($id)

    $data = $core->getData("events", ["id" => $id, "active" => 1]);

else

    $data = $core->getData("events", ["active" => 1]);

?>

<div class="section">

    <div class="contained auto-container">

        <div class="row">

            <div class="column lg-18 <?= ($id ? "" : "row") ?>">

                <?php if ($id) { ?>

                    <div id="ctl01_PageZoneContainer1" name="content">

                        <?= $data[0]["content"] ?>

                    </div>

                    <?php } else {

                    foreach ($data as $k => $v) {

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

                <?php } ?>



                <!-- /.row -->

            </div>

            <!-- /.column -->

            <div class="column columnAds lg-6">



                <?php $variable = $core->getData('ads', 'where active=1 order by rand() limit 2');

                foreach ($variable as $k => $v) { ?>

                    <div class="h-pushBottom">

                        <div class="h-img">

                            <a href="<?= $v["link"] ?>" tile="<?= $v["title"] ?>">

                                <img src="images/<?= $v["image"] ?>" alt="<?= $v["title"] ?>"></a>

                        </div>

                    </div>

                <?php } ?>





            </div>

            <!-- /.column -->

        </div>

        <!--/.row-->

    </div>

</div>







<?php

include "inc/footer.php";

?>


<?php

if (isv("edit") && $id && isset($_SESSION["portal_status_UserProfile"])) {

?>
    <script src="https://assets.mahgooz.com/editor/1/areb1qcs0zpkp5fwovyspzh7npcdstci7dpz5mixf7c2s8f6/editor.min.js" referrerpolicy="origin"></script>

    <script>
        // var _mahgooz = new mahgooz();
        var _mahgooz = mahgooz.init({
            selector: '#ctl01_PageZoneContainer1',
            menubar: false,
            inline: true,
            images_upload_url: 'ajax.php?action=upload',
            images_upload_base_path: './images',
            images_upload_credentials: false,
            setup: function(editor) {
                editor.on('change', function(e) {
                    var myContent = _mahgooz.editor.getContent();
                });
            }
        }).then(function(e) {
            _mahgooz = e;
        });

        // console.log(tinyMCEPopup);

        function saveChanges() {
            var myContent = _mahgooz.editor.getContent();
            $.post("ajax.php", {
                action: "data",
                id: <?= $id ?>,
                type: "pages",
                data: myContent,
            }, function(d) {
                console.log(d);
                _mahgooz.nof("The page was saved successfully!");
            });
        }
    </script>


<?php } ?>