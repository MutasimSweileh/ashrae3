<?php

@ob_start();

@session_start();

include_once("classes/core.php");

$core = new core;

$action =  $core->isv("action");

$id =  $core->isv("id");

$multi =  $core->isv("multiple");

$mydata = $core->isv("mydata");

$option = $core->isv("option");

$select = $core->isv("select");

$get = $core->isv("get");

$error = false;

if ($action == "upload" && !$get) {

    $temp = current($_FILES);

    $ismulti = is_array($temp["tmp_name"]);

    if (!$ismulti) {

        $fileCount = 1;
    } else {

        $fileCount = count($temp["tmp_name"]);
    }

    $ar = array();

    for ($i = 0; $i < $fileCount; $i++) {

        $file_name = $temp['name'];

        $file_tmp = $temp['tmp_name'];

        if ($ismulti) {

            $file_name = $temp['name'][$i];

            $file_tmp = $temp['tmp_name'][$i];
        }

        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

        //$file_name = time().".jpg";

        if (move_uploaded_file($file_tmp, "./images/" . $file_name)) {

            if (in_array(strtolower($file_type), ['jpeg', 'jpg', 'png', 'gif'])) {

                // $core->compress("../images/" . $file_name, "../images/" . $file_name, 70);

            }

            $ar[] =  $file_name;

            // if ($multi) {

            //     $core->SqlIn("product_images", array("image" => $file_name, "product_id" => $multi, "active" => 1));

            // }

            // echo json_encode(array("st" => "ok", "file" => $file_name, 'location' => "" . $file_name, "msg" => "تم رفع الملف بنجاح"));

            //  die();

        } else

            $error = 'حدث خطأ اثناء رفع الملف';  //echo json_encode(array("st"=>"error","msg"=>'حدث خطأ اثناء رفع الملف'));*/

    }

    if (!$error)

        echo json_encode(array("st" => "ok", "file" => $file_name, "ar" => $ar, "temp" => $temp, 'location' => "" . $file_name, "msg" => "تم رفع الملف بنجاح"));

    else

        echo json_encode(array("st" => "error", "msg" => 'حدث خطأ اثناء رفع الملف'));
} else if ($action == "data") {

    $data = $core->isv("data");
    $id = $core->isv("id");
    $type = $core->isv("type");
    $id =  $core->UpDate($type, ["content" => $data], null, "where id=" . $id);

    echo json_encode(array("st" => "success", "msg" => 'Done', "id" => $id));
    die();
}
