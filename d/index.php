<?php

$dpath = "/d";

// Use PHP to serve files too big for Apache to deliver (>2GB)
function serveFile($file){
	if (file_exists($file)){
		$path_parts = pathinfo($file);
		$as = $path_parts['basename'];
		// Exec to determine correct file size (see's bigger files than PHP can see)
		$size = trim(`stat -c%s "$file"`);
		set_time_limit(0);

		header("Expires: Mon, 1 Jan 2010 01:00:00 GMT");
		header("Pragma: no-cache");
		header("Cache-Control: private");
		header("Content-Description: File Download");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".urlencode($as)."\"");
		header("Content-Length: $size");
		header("Content-Transfer-Encoding: binary");

		flush();
		$fp = popen("cat \"$file\" 2>&1", "r");
		while(!feof($fp))
		{
			// send the current file part to the browser
			print fread($fp, 1024);
			// flush the content to the browser
			flush();
		}
		fclose($fp);
	} else {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		print "File not found";
	}
}

$file = "../" . str_replace(array("$dpath/", "?f=","../"), "", trim(urldecode($_SERVER['REQUEST_URI'])));

// If the last character of the URL is & then trigger for Download
if (substr($_SERVER['REQUEST_URI'], -1) == "&"){
	$download = true;
	// Strip off & from the end of the $file variable
	$file = substr_replace($file, '', strlen($file)-1, 1);
}else{
	$download = false;
}

if (isset($_GET['f']) && $download == false){
	if (file_exists($file)){
		$size = number_format(trim(`stat -c%s "$file"`));
		$path_parts = pathinfo($file);
		$url_path = str_replace(array(" ","../"), array("%20",""), $file);
		print "Click to download <a href=\"$dpath/?f=".$url_path."&\">".$path_parts['basename']."</a>";
		print " (".$size." bytes)";
	} else {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		print "File not found";
	}
} else {
	serveFile($file);
}

?>
