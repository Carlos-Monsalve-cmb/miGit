<?php
/*
|--------------------------------------------------------------------------
| Image Preset Sizes
|--------------------------------------------------------------------------
|
| Specify the preset sizes you want to use in your code. Only these preset
| will be accepted by the controller for security.
|
| Each preset exists of a width and height. If one of the dimensions are
| equal to 0, it will automatically calculate a matching width or height
| to maintain the original ratio.
|
| If both dimensions are specified it will automatically crop the
| resulting image so that it fits those dimensions.
|
*/

$config['image_sizes']['small'] = array(75, 50);
$config['image_sizes']['medium'] = array(1024, 683);
$config['image_sizes']['large'] = array(1024, 0);
$config['image_sizes']['featured'] = array(219, 123);  
$config['image_sizes']['list'] = array(480, 320);

/* End of file images.php */
/* Location: ./app/config/images.php */