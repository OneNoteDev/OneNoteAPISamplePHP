<?php
//*********************************************************
// Copyright (c) Microsoft Corporation
// All rights reserved. 
//
// Licensed under the Apache License, Version 2.0 (the ""License""); 
// you may not use this file except in compliance with the License. 
// You may obtain a copy of the License at 
// http://www.apache.org/licenses/LICENSE-2.0 
//
// THIS CODE IS PROVIDED ON AN  *AS IS* BASIS, WITHOUT 
// WARRANTIES OR CONDITIONS OF ANY KIND, EITHER EXPRESS 
// OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED 
// WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR 
// PURPOSE, MERCHANTABLITY OR NON-INFRINGEMENT. 
//
// See the Apache Version 2.0 License for specific language 
// governing permissions and limitations under the License.
//*********************************************************
error_reporting(E_ALL);
session_start();

//disallow other sites from embedding this page 
header("X-Frame-Options: SAMEORIGIN");

//HTTPS endpoint to create pages with POST
define('URL','https://www.onenote.com/api/v1.0/pages');

function parseQueryString($query)
{
    $result = array();
    $arr = preg_split('/&/', $query);
    foreach ($arr as $arg)
    {
        if (strpos($arg, '=') !== false)
        {
            $kv = preg_split('/=/', $arg);
            $result[rawurldecode($kv[0])] = rawurldecode($kv[1]);
        }
    }
    return $result;
}

class OneNoteRequest
{
    
    //the boundary between multipart request parts
    private $boundary;
	
    //constructor
    function OneNoteRequest()
    {
        //generate a random string to serve as the multipart boundary
        $this->boundary = hash('sha256',rand());
    }
    
    function createPageWithSimpleText()
    {
        $ch = $this->initCurl('simple');
        
        //ISO 8601 standard time stamp
        $date = date('c');
        
        //Just the POST data -- multipart not required for simple pages
        $postdata = <<<POSTDATA
<!DOCTYPE html>
<html>
  <head>
    <title>A page created from basic HTML-formatted text (PHP Sample)</title>
    <meta name="created" value="$date"/>
  </head>
  <body>
    <p>This is a page that just contains some simple <i>formatted</i> <b>text</b></p>
  </body>
</html>

POSTDATA;

        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        $response = curl_exec($ch);       
        $this->finish($ch,$response);
    }
    
    function createPageWithFile()
    {
        
        $ch = $this->initCurl();
        
        //ISO 8601 standard time stamp
        $date = date('c');
        
        //Read the file into memory
        //Note that reading entire large files into memory could create problems if 
        //  PHP doesn't have enough memory to work with
        $fileContents = file_get_contents("attachment.pdf");
        
        //Includes the  Presentation part and embedded file data part
        //Each has its own Content-Disposition and Content-Type headers
        //The request must end with a blank line to be a valid Multipart request
        $postdata = <<<POSTDATA
--{$this->boundary}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html

<!DOCTYPE html>
<html>
  <head>
    <title>A page created with a file attachment (PHP Sample)</title>
    <meta name="created" value="$date"/>
  </head>
  <body>
  <h1>This is a page with a PDF file attachment</h1>
    <object 
        data-attachment="attachment.pdf" 
        data="name:embeddedFile" 
        type="application/pdf" />
	<p>Here's the content of the PDF document :</p>
	<img data-render-src="name:embeddedFile" alt="Hello World" width="1500" />
  </body>
</html>
--{$this->boundary}
Content-Disposition: form-data; name="embeddedFile"
Content-Type: application/pdf

$fileContents
--{$this->boundary}--

POSTDATA;
        
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        $response = curl_exec($ch);
        $this->finish($ch,$response);
    }
    
    function createPageWithTextandImage()
    {        
        $imageData = file_get_contents("Logo.jpg");
        $ch = $this->initCurl();
        
        //ISO 8601 standard time stamp
        $date = date('c');
        
        //Includes just the single Presentation part
        //It has its own Content-Disposition and Content-Type headers
        //The request must end with a blank line to be a valid Multipart request
        $postdata = <<<POSTDATA
--{$this->boundary}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html

<!DOCTYPE html>
<html>
  <head>
    <title>A page created containing an image (PHP Sample)</title>
    <meta name="created" value="$date"/>
  </head>
  <body>
    <p>This is a page that just contains some simple <i>formatted</i> <b>text</b> and an image</p>
    <img src="name:imageData" alt="A beautiful logo" width=\"426\" height=\"68\" />
  </body>
</html>
--{$this->boundary}
Content-Disposition: form-data; name="imageData"
Content-Type: image/jpeg

$imageData
--{$this->boundary}--

POSTDATA;
   
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        $response = curl_exec($ch);
        $this->finish($ch,$response);
    }
    
    function createPageWithScreenshotFromUrl()
    {
        $ch = $this->initCurl('simple');
        
        //ISO 8601 standard time stamp
        $date = date('c');
        
        //Just the POST data -- multipart not required for simple pages
        $postdata = <<<POSTDATA
<!DOCTYPE html>
<html>
  <head>
    <title>A page created with a URL snapshot on it (PHP Sample)</title>
    <meta name="created" value="$date"/>
  </head>
  <body>
    <img data-render-src="http://www.onenote.com" alt="An important web page" />
    Source URL: <a href="http://www.onenote.com">http://www.onenote.com</a>
  </body>
</html>

POSTDATA;
        
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        $response = curl_exec($ch);
        $this->finish($ch,$response);
    }
    
    function createPageWithScreenshotFromHtml()
    {
        $html = "<html>" .
                "<head>" .
                "<title>Embedded HTML</title>" .
                "</head>" .
                "<body>" .
                "<h1>This is a screen grab of a web page</h1>" .
                "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vehicula magna quis mauris accumsan, nec imperdiet nisi tempus. Suspendisse potenti. " .
                "Duis vel nulla sit amet turpis venenatis elementum. Cras laoreet quis nisi et sagittis. Donec euismod at tortor ut porta. Duis libero urna, viverra id " .
                "aliquam in, ornare sed orci. Pellentesque condimentum gravida felis, sed pulvinar erat suscipit sit amet. Nulla id felis quis sem blandit dapibus. Ut " .
                "viverra auctor nisi ac egestas. Quisque ac neque nec velit fringilla sagittis porttitor sit amet quam.</p>" .
                "</body>" .
                "</html>";
        
        $ch = $this->initCurl();
        
        //ISO 8601 standard time stamp
        $date = date('c');
       
        //Includes each part of the multipart request
        //Each part has its own Content-Disposition and Content-Type headers
        //The request must end with a blank line to be a valid Multipart request
        $postdata = <<<POSTDATA
--{$this->boundary}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html

<!DOCTYPE html>
<html>
  <head>
    <title>A page created with a screenshot of HTML on it (PHP Sample)</title>
    <meta name="created" value="$date"/>
  </head>
  <body>
    <img data-render-src="name:HtmlForScreenshot" />
  </body>
</html>

--{$this->boundary}
Content-Disposition: form-data; name="HtmlForScreenshot"
Content-Type:text/html

$html
--{$this->boundary}--


POSTDATA;
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        
        $response = curl_exec($ch);
              
        $this->finish($ch,$response);
    }
    

    function initCurl($type = 'multipart')
    {
        $cookieValues = parseQueryString(@$_COOKIE['wl_auth']);
        
        //Since cookies are user-supplied content, it must be encoded to avoid header injection
        $encodedAccessToken = rawurlencode(@$cookieValues['access_token']);
            
        $ch = curl_init(URL);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        if ($type == 'multipart') {
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: multipart/form-data; boundary=$this->boundary\r\n".
                                                        "Authorization: Bearer ".$encodedAccessToken));
        }
        else { //simple single-part request
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type:text/html\r\n".
                                                        "Authorization: Bearer ".$encodedAccessToken));
        }
        
        //configures curl_exec() to return the response as a string rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        
        //use HTTP POST method
        curl_setopt($ch,CURLOPT_POST,true);
        return $ch;
    }
    
    function finish($ch,$response)
    {
        
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        if ($info['http_code'] == 201) 
        {
            echo '<h2>Page created!</h2>';
            $response_without_header = substr($response,$info['header_size']);
            $decoded = json_decode($response_without_header);
            echo 'Open page in <a href="'.
                $decoded->links->oneNoteClientUrl->href.
                    '">OneNote</a> or <a href="'.
                $decoded->links->oneNoteWebUrl->href.
                    '">OneNote Online</a>';
        }
        elseif ($info['http_code'] == 401)
        {
            echo '<h2>Authorization failed. Try signing out and signing in again.</h2>';
        }
        else 
        {
            echo '<h2>Something went wrong...</h2>';
        }
        echo '</b></h2>';
        
        echo '<h3>Response</h3>';
        echo '<pre>';
        echo htmlspecialchars($response);
        echo '</pre>';
    }
}

echo '<html><head><title>OneNote Service API Result</title></head><body>';
echo '<h1>OneNote Service API Result</h1>';

$OneNoteRequest = new OneNoteRequest();

if (isset($_POST['submit'])) //form submission?
{
    //CSRF protection: check that the form that submitted this request was generated by the same PHP session
    if (empty($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] != $_SESSION['csrf_token'])
    {
        echo "Error: Your session timed out. Please go back and try again. (Cross-site request forgery protection check failed.)";
    }
    elseif (empty($_COOKIE['wl_auth'])) {
        echo "Error: Not signed in.";
    }
    else {
        switch ($_POST['submit']) {
            case "text": 
                $OneNoteRequest->createPageWithSimpleText(); 
                break;
            case "file": 
                $OneNoteRequest->createPageWithFile(); 
                break;
            case "textimage": 
                $OneNoteRequest->createPageWithTextAndImage();
                break;
            case "url":
                $OneNoteRequest->createPageWithScreenshotFromUrl();
                break;
            case "html":
                $OneNoteRequest->createPageWithScreenshotFromHtml();
                break;
        }
    }
}

echo '<br /><a href="index.php">&lt;- Go back</a></body></html>';
?>
