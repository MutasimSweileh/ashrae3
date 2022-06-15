<?php
$pagg = 2;
include "inc.php";
$id = isv("id");
$data = $core->getData("pages", ["id" => $id, "active" => 1]);
?>
<div class="section">
    <div class="contained auto-container">
        <div class="row">
            <div class="column lg-18">
                <div id="ctl01_PageZoneContainer1" name="content">
                    <?= $data[0]["content"] ?>
                </div>
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
<script src="https://assets.mahgooz.com/editor/1/areb1qcs0zpkp5fwovyspzh7npcdstci7dpz5mixf7c2s8f6/editor.min.js" referrerpolicy="origin"></script>
<?php
if (isv("edit") && $id && isset($_SESSION["portal_status_UserProfile"]) || 1 == 1) {
?>
    <script>
        mahgooz.init({
            selector: '#ctl01_PageZoneContainer1',
            menubar: false,
            inline: true,
            images_upload_url: 'ajax.php?action=upload',
            images_upload_base_path: './images',
            images_upload_credentials: false,
            setup: function(editor) {
                editor.on('change', function(e) {
                    var myContent = tinymce.activeEditor.getContent();
                    console.log(myContent);
                });
            },
            change: (editor) => {
                var content = editor.getContent();
            },
            //file_browser_callback_types: 'file image media',
            // file_picker_types: 'file image media',
            // file_picker_callback: function(cb, value, meta) {
            //     var input = document.createElement('input');
            //     input.setAttribute('type', 'file');
            //     input.onchange = function() {
            //         var file = this.files[0];
            //         var reader = new FileReader();

            //         // FormData
            //         var fd = new FormData();
            //         var files = file;
            //         fd.append('filetype', meta.filetype);
            //         fd.append("file", files);

            //         var filename = "";

            //         // AJAX
            //         var xhr, formData;
            //         xhr = new XMLHttpRequest();
            //         xhr.withCredentials = false;
            //         xhr.open('POST', '/your-endpoint');

            //         xhr.onload = function() {
            //             var json;
            //             if (xhr.status != 200) {
            //                 failure('HTTP Error: ' + xhr.status);
            //                 return;
            //             }
            //             json = JSON.parse(xhr.responseText);
            //             if (!json || typeof json.location != 'string') {
            //                 failure('Invalid JSON: ' + xhr.responseText);
            //                 return;
            //             }
            //             success(json.location);
            //             filename = json.location;
            //         };
            //         xhr.send(fd);

            //         reader.onload = function(e) {
            //             cb(filename);
            //         };
            //         reader.readAsDataURL(file);
            //         return
            //     };

            //     input.click();
            // },
        });
        //console.log(editor);
        function saveChanges() {
            var myContent = tinymce.activeEditor.getContent();
            console.log(myContent);
            $.post("ajax.php", {
                action: "data",
                id: <?= $id ?>,
                type: "pages",
                data: myContent,
            }, function(d) {
                console.log(d);
                alert("The page was saved successfully!");
            });
        }
    </script>

<?php } ?>