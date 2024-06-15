<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$image = Image::canvas(800, 600, '#ff0000');
$image->text('Hello, Intervention Image', 400, 300, function($font) {
    $font->file('path/to/font.ttf');
    $font->size(48);
    $font->color('#ffffff');
    $font->align('center');
    $font->valign('center');
});
$image->save('test_image.jpg');
echo "Image created successfully.";
?>
