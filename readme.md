
PHP Download
-----------------------

This is a simple PHP Download script designed to solve a few basic problems.

1. Allow downloading of files no matter how big.
>Note: On some Apache servers, when downloading large files (>2GB), Apache will fail to download.
2. Force download of txt/image/script or other file that normally displays in the browser.
3. Provide the user a small page to tell them what they are about to download and how big it is.
4. Obfuscate the true location of a download on the server.
5. Provide a download link to a file from a directory that is not directly accessible within the webroot.
6. Counter to track the number of  downloads. *
7. To run PHP script upon download, such as generate image, dynamically watermark a PDF, etc. *

*You will need to extend the script to implement the last two.


Instructions
-----------------------

The script is currently configured to be used on a PHP webserver in a directory called /d (for download).  From this path, you can construct download links such as:
http://example.com/d/path/to/download.tgz

This will host a simple page that displays the size of the download file with a link to download it.  You can skip this page by offering a direct download url which is the same as the first but adding a '?' at the end such as:
http://example.com/d/path/to/download.tgz?


If you wish to rename the directory to something else, for example "download", you need to make the following modifications:

###.htaccess

FROM:<br>
`RewriteBase /d/`

TO:<br>
`RewriteBase /download/`


###index.php

FROM:<br>
`$dpath = "/d";`

TO:<br>
`$dpath = "/download";`
