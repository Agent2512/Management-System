<?php
spl_autoload_register("myAutoloader");
function myAutoloader($className)
{
    $path = "app/";
    $ext = ".class.php";

    $dirs = [
        "",
        "modules/",
        "views/",
        "controller/",
    ];

    foreach ($dirs as $dir) {
        $fullPath = $path . $dir . $className . $ext;
        if (file_exists($fullPath)) {
            require_once $fullPath;
        }
    }
}
