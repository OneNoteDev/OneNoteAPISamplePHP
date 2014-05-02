
## OneNote API PHP Sample README

Created by Microsoft Corporation, 2014. Provided As-is without warranty. Trademarks mentioned here are the property of their owners.

### API functionality demonstrated in this sample

The following aspects of the API are covered in this sample. You can 
find additional documentation at the links below.

* [Log-in the user](http://msdn.microsoft.com/EN-US/library/office/dn575435.aspx)
* [POST simple HTML to a new OneNote QuickNotes page](http://msdn.microsoft.com/EN-US/library/office/dn575428.aspx)
* [POST multi-part message with image data included in the request](http://msdn.microsoft.com/EN-US/library/office/dn575432.aspx)
* [POST page with a URL rendered as an image](http://msdn.microsoft.com/EN-US/library/office/dn575431.aspx)
* [POST page with HTML rendered as an image](http://msdn.microsoft.com/en-us/library/office/dn575432.aspx)
* [POST page with a PDF file rendered and attached](http://msdn.microsoft.com/EN-US/library/office/dn655137.aspx)
* [Extract the returned oneNoteClientURL and oneNoteWebURL links](http://msdn.microsoft.com/EN-US/library/office/dn575433.aspx)

### Prerequisites

**Tools and Libraries** you will need to download, install, and configure for your development environment. 

The PHP sample runs on a web server. The Live Connect OAUTH service and the client browser needs 
to be able to access the web server to complete the handshake. Make sure that you install the 
PHP files so that:

* The web server you're using is accessible from the Internet
* The web server has PHP installed, with the cURL package enabled  
* You have a normal URL with hostname (not just an IP address) to use for the Redirect URL. 

**Accounts**

* As the developer, you'll need to [have a Microsoft account and get a client ID string](http://msdn.microsoft.com/EN-US/library/office/dn575426.aspx) 
so your app can authenticate with the Microsoft Live connect SDK.
* As the user of the sample, you'll need a Microsoft account so the OneNote API can 
send the pages to your OneDrive.

### Using the sample

After you've setup your web server described above,....

1. Download the repo as a ZIP file to your local computer, and extract the files. Or, clone the repository into a local copy of Git.
2. Configure a subdomain directory for the sample app. We recommend using a subdomain because you can only 
register a single app with the root domain name on the Live Connect Developer Center. 
3. Go to the [Microsoft app registration page](https://account.live.com/developers/applications/index).
4. On the API Settings page, set Mobile or desktop setting to No.
5. Set the Redirect URI to the sub-domain name of your web site. 
6. On the App Setting page, copy the client ID and secret into the Callback.php file at ~lines 32 and 33. 
7. Put the sample files to the subdomain document directory on your web server. 
8. Using a web browser, access the default.php page
9. Login using your Microsoft account, and allow the app to create pages in your OneNote notebooks.

### Version info

This is the initial public release for this code sample.

### Known issues

* If you're running the sample on a web server on a home network, and you don't have
a fixed IP address and assigned domain name, you may need to use a DDNS
provider, and then forward the HTTP/S ports to your local server. 
  
### Learning more

* Visit the [dev.onenote.com](http://dev.onenote.com) Dev Center
* Contact us on [StackOverflow (tagged OneNote)](http://go.microsoft.com/fwlink/?LinkID=390182)
* Follow us on [Twitter @onenotedev](http://www.twitter.com/onenotedev)
* Read our [OneNote Developer blog](http://go.microsoft.com/fwlink/?LinkID=390183)
* Explore the API using the [apigee.com interactive console](http://go.microsoft.com/fwlink/?LinkID=392871).
Also, see the [short overview/tutorial](http://go.microsoft.com/fwlink/?LinkID=390179). 
* [API Reference](http://msdn.microsoft.com/en-us/library/office/dn575437.aspx) documentation
* [Debugging / Troubleshooting](http://msdn.microsoft.com/EN-US/library/office/dn575430.aspx)
* [Getting Started](http://go.microsoft.com/fwlink/?LinkID=331026) with the OneNote API

  
