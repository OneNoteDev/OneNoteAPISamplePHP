
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
* [POST page to a specific section](http://msdn.microsoft.com/en-us/library/office/dn672416(v=office.15).aspx)
* [Extract the returned oneNoteClientURL and oneNoteWebURL links](http://msdn.microsoft.com/EN-US/library/office/dn575433.aspx)

### Prerequisites

**Tools and Libraries** you will need to download, install, and configure for your development environment. 

The PHP sample runs on a web server. The Live Connect OAUTH service and the client browser needs 
to be able to access the web server to complete the handshake. Make sure that you install the 
PHP files so that:

* The web server you're using is accessible from the Internet
* The web server has PHP installed, with the cURL package enabled  
* You have a normal URL with hostname (not just an IP address) to use for the Redirect URL. If you run this from your own desktop, you'll need to modify your Hosts file (in C:\Windows\System32\drivers\etc for Windows machines and /private/etc for Macs) and map your local server IP address to a new domain name, as in the following example.
 ![](images/HostsFile.png) 

**Accounts**

* As the developer, you'll need to [have a Microsoft account and get a client ID string](http://msdn.microsoft.com/EN-US/library/office/dn575426.aspx) 
so your app can authenticate with the Microsoft Live connect SDK.
* As the user of the sample, you'll need a Microsoft account so the OneNote API can 
send the pages to your OneDrive.

### Register the sample

After you've setup your web server described above,....

1. Clone the Git repository to a folder on your local machine.
2. Go to the [Microsoft app registration page](https://account.live.com/developers/applications/index).
3. On the API Settings page, set Mobile or desktop setting to No.
4. Set the Redirect URL to the address of the callback.php file on your hosted deployment. If the root deployment URL is http://onenoteapisamples.com:3000, then specify http://onenoteapisamples.com:3000/callback.php as the Redirect URL (as in the following example). This URL must exactly match the deployed redirect URL. The root domain name must be unique, so if you use one domain for testing and another for production, you'll need to register separate client ids and secrets for each domain.
![](images/OneNoteMSAScreen.png)

### Set up the sample

1. Replace the following placeholders in the callback.php and index.php files with the associated values from the App Settings page:
	1. Replace %CLIENT_ID% with the client ID value.
	2. Replace %CLIENT_SECRET% with the client secret value.
	3. Replace %REDIRECT_URI_PATH% with the value of the deployment root URL. The deployment root URL consists of "http://" plus the root domain URL, so if your redirect URL looks like http://onenoteapisamples.com/callback.php, the deployment root URL is "http://onenoteapisamples.com." At run time, the redirect URL value will resolve to "http://onenoteapisamples.com/callback.php."
2. Put the sample files in the root directory on your web server. 
3. Open a browser and navigate to the default .php page.
4. Login using your Microsoft account, and allow the app to create pages in your OneNote notebooks.

### Version info

This is the initial public release for this code sample.

### Known issues

* If you're running the sample on a web server on a home network, and you don't have
a fixed IP address and assigned domain name, you may need to use a DDNS
provider, and then forward the HTTP/S ports to your local server. 
* The PHP files in this sample contain CRLF line endings. You'll need to retain these line endings when you open and edit these files in your editor. See [Dealing with line endings](https://help.github.com/articles/dealing-with-line-endings#platform-all) for guidance on how to retain CRLF line endings on all platforms.
  
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

  
