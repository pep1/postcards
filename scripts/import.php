<?php
/**
 * get file post data
 * return url of uploaded image in "input" directory
 */

$deploymentpath = "/postcards/";
$uploaddir = dirname(__FILE__) . '/../input/';


$new_filename = generateRandomString() .".". pathinfo($_FILES['userimage']['name'], PATHINFO_EXTENSION);
$uploadfile = $uploaddir . $new_filename;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function make_thumb($src, $dest, $desired_width) {

	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height * ($desired_width / $width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest);

	return true;
}

if (make_thumb($_FILES['userimage']['tmp_name'], $uploadfile, 1000)) {
    echo $deploymentpath . "input/" . $new_filename;
} else {
    echo "Error during processing!\n";
}

?>
