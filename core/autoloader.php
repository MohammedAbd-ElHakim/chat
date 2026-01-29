<?php

spl_autoload_register(function ($className) {
#folder which have a classes  
$dirs = [
        __DIR__ . '/database/tables/',
        __DIR__ .'/database/',
        __DIR__ .'/security_layers/',
        __DIR__ .'/../chat/checkdata/'
    ];

#search on files of classes inside folders
    foreach ($dirs as $dir) {
        $file = $dir . $className . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return; // توقف عن البحث بمجرد إيجاد الملف
        }
    }

    //إذا لم يجد الملف في أي مكان  
    // echo "Class $className not found in defined directories.";
});

?>