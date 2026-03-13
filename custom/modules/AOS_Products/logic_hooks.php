<?php
$hook_array['before_save'][] = array(
    1,
    'Fix sold datetime',
    'custom/modules/AOS_Products/SoldDateHook.php',
    'SoldDateHook',
    'saveDate'
);
$hook_array['after_retrieve'][] = Array(
    2,
    'Fetch related images for gallery',
    'custom/modules/AOS_Products/ProductGalleryHook.php',
    'ProductGalleryHook',
    'getImages'
);
