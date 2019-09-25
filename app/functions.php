<?php

$filenames = [
    0 => APP_PATH . '/functions/default_functions.php'
];

foreach ($filenames as $filename) {
    if (file_exists($filename)) {
        include_once $filename;
    }
}
