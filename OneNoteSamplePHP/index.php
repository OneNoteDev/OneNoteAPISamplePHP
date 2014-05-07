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
session_start();
if (!isset($_SESSION['csrf_token'])) 
{
    $_SESSION['csrf_token'] = hash('sha256',rand());
}
//disallow other sites from embedding this page 
header("X-Frame-Options: SAMEORIGIN");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <!-- *************************************************** -->
    <!--This page's OAuth implementation is based on https://github.com/liveservices/LiveSDK/tree/master/Samples/PHP/OauthSample -->
    <!--Please see that page for documentation -->
    <!-- *************************************************** -->

    <title>OneNote Service PHP Sample</title>
    <style>
        <!--

        body {
    padding: 50px;
    font: 14px "Lucida Grande", Helvetica, Arial, sans-serif;
}

a {
    color: #00B7FF;
}

button {
    padding: 10px 20px;
    margin-bottom: 10px;
}


        -->
    </style>
    </head>
<body>
<h1>OneNote Service PHP Sample</h1>

<div>
    <div id="meName" class="Name"></div>
    <div id="meImg"></div>
    <div id="signin"></div>
    <div id="OneNoteForm">
        <form method="POST" action="submit.php">
            <br />
            <input type="hidden" name="csrf_token" value="<?php /* Print the automatically generated session ID for CSRF protection */ echo htmlspecialchars($_SESSION['csrf_token']); ?>" />
	        <p>Enter Section Name:</p>
	        <input type="text" name="section" />
	        <br/>
            <button type="submit" name="submit" value="text">Create OneNote Page with Text</button> <br />
            <button type="submit" name="submit" value="textimage">Create OneNote Page with Text and Images</button><br />
            <button type="submit" name="submit" value="html">Create OneNote Page with a Screenshot of HTML</button><br />
            <button type="submit" name="submit" value="url">Create OneNote Page with a Screenshot of a URL</button><br />
            <button type="submit" name="submit" value="file">Create OneNote Page with an Attached and Rendered PDF File</button>
        </form>

    </div>
</div>
<script src="//js.live.net/v5.0/wl.js" type="text/javascript"></script>
<script type="text/javascript">

    // Update the following values
    var client_id = "%CLIENT_ID%",
        scope = ["wl.signin", "wl.basic", "wl.offline_access", "office.onenote_create"],
        redirect_uri = "%REDIRECT_URI_PATH%/callback.php";

    function id(domId) { 
        return document.getElementById(domId);
    }

    function displayMe() {  
        var imgHolder = id("meImg"),
            nameHolder = id("meName");

        if (imgHolder.innerHTML != "") return;

        if (WL.getSession() != null) {
            WL.api({ path: "me/picture", method: "get" }).then(
                    function (response) {
                        if (response.location) {
                            imgHolder.innerHTML = "<img src='" + response.location + "' />";
                        }
                    }
                );

            WL.api({ path: "me", method: "get" }).then(
                    function (response) {
                        nameHolder.innerHTML = response.name;
                    }
                );
        }
    }

    function clearMe() {
        id("meImg").innerHTML = "";
        id("meName").innerHTML = "";
    }

    WL.Event.subscribe("auth.sessionChange",
        function (e) {
            if (e.session) {
                displayMe();
            }
            else {
                clearMe();
            }            
        }
    );

    WL.init({ client_id: client_id, redirect_uri: redirect_uri, response_type: "code", scope: scope });

    WL.ui({ name: "signin", element: "signin" });

</script>
</body>
</html>
