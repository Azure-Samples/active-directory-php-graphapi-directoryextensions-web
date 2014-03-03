WindowsAzureAD-GraphAPI-Sample-PHP
==================================

This sample shows how to create directory extensions and use them on users of Windows Azure Active Directory. Settings.php contains the following information for a predefined tenant that should be updated to the developer's tenant to have write permissions using "Manage Access" option and selecting "Single sign-on, read and write directory data" access for your application.

The "Client ID" for the application should be used as $appPrincipalId and a new key can be created using "keys" section. The value generated must be used for $password.

$appObjectId is the unique object identifier of the application. This can be obtained by using "View Applications" link in the home page. That page will display all the applications defined in the current tenant including the appPrincipalId and the objectId.

$skypeExtension can be updated once an extension is created with it's fully qualified name.

public static $appTenantDomainName = 'graphdir1.onMicrosoft.com'; --> Name of the tenant or any verified domain. public static $appPrincipalId = '118473c2-7619-46e3-a8e4-6da8d5f56e12'; public static $appObjectId = 'fe82d9ae-b178-41f4-bf3f-8c4d7c35736e';
 public static $password = 'hOrJ0r0TZ4GQ3obp+vk3FZ7JBVP+TX353kNo6QwNq7Q='; public static $skypeExtension = 'extension_118473c2761946e3a8e46da8d5f56e12_skypeId';
