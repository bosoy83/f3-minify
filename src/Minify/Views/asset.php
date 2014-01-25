<?php
//header('Content-type: '.(\Web::instance()->mime($file)));
apache_setenv('no-gzip', '1');
//$finfo = new \finfo(FILEINFO_MIME_TYPE);
//echo $finfo->buffer(file_get_contents( $file ));
//echo \Dsc\Image::dataUri( file_get_contents( $file ) );

$lastModified = time();
$etagFile = md5_file( $file );

//$output = file_get_contents($file);

//echo \Dsc\Debug::dump(filesize($file));
//exit;
header('Accept-Ranges: bytes');
//set last-modified header
//header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
//set etag-header
header("Etag: $etagFile");
//make sure caching is turned on
header('Cache-Control: public');
// set content type header
header('Content-type: '. \Web::instance()->mime($file) );
/*
$getInfo = getimagesize($file);
echo \Dsc\Debug::dump($getInfo);
echo \Dsc\Debug::dump(filesize($file));
echo $file; exit;
*/

//echo $output;

//readfile($file);
/*
$handle = fopen ($file, 'rb');
$size = filesize ($file);
$contents = fread ($handle, $size);
fclose ($handle);
*/
//echo $contents;

$string = \Base::instance()->read( $file );
//header('Content-Length: ' . strlen($string) );
echo (string) trim($string);
//ob_flush();
//flush();

/*
set_time_limit(0);
$f = @fopen($file,"rb");
while(!feof($f))
{
    print(@fread($f, 1024*8));
    ob_flush();
    flush();
} 
*/
//echo base64_encode(file_get_contents($file));
?>