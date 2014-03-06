Goals
When we started working on directory extensions, we had two goals: 1. Enable organizations to move their applications to the cloud. Seamlessly synchronizing on-premises schema extensions to Azure AD will allow organizations to leverage investments in on-premises applications as they move to the cloud. 2. Enable ISVs to build more powerful directory-aware applications. Allowing application developers to extend the directory allows them to develop richer directory-aware applications without worrying about access controls, availability requirements, etc. of a user profile store.

The first goal really brings on-premises AD and Azure AD together, which we know is hugely important to you. However, the second goal is a prerequisite for the first; therefore, that is where we started. This preview provides REST interfaces for registering, reading, writing, and filtering by extension values.



Application-Centric Model
Since most people think of directory extensions as belonging to the tenant, let me take a moment to explain our application-centric approach. You may want to read this post to understand how to write an application to access the Graph API. To enable an application to register extensions (goal #2), the extensions are registered on the Application object in the directory and referenced from all the tenants consenting to that Application. Once a customer tenant has consented to an Application (even for read) the extensions registered on that Application are available in the consenting tenant for reading/writing by any Application that has the appropriate access. If the app developer wants to add more extension attributes, she can update her Application (in her developer tenant) and any tenants that are currently consented to this Application will instantly be enabled for the new attributes. If consent is removed, if the extension is deleted, or if the Application is deleted, the extension values will no longer be accessible (and cleaned up as a background task once we implement garbage collection) on the corresponding directory objects.



Types and Limitations
Currently “User”, “Group”, “TenantDetail”, “Device”, “Application” and “ServicePrincipal” entities can be extended with “String” type or “Binary” type single-valued attributes. String type extensions can have maximum of 256 characters and binary extensions are limited to 256 bytes. 100 extension values (across ALL types and ALL applications) can be written to any single object. Prefix searches on extensions are limited to 71 characters for string searches and 207 bytes for searches on binary extensions.



Registering an Extension
Let’s walk through an example. Contoso has built an OrgChart application and wants to allow users to make Skype calls from it. AAD does not expose a SkypeID user property. The OrgChart developer could use a separate store such as SQL Azure to store a record for each user’s SkypeID. Instead, the developer registers a String extension on the User object in his tenant. He does this by creating an “extensionProperty” on the Application using Graph API. POST https://graph.windows.net/contoso.com/applications//extensionProperties?api-version=1.21-preview { “name”: “skypeId”, “dataType”: “String”, “targetObjects”: [“User”] } If the operation is successful, it will return 201 along with the fully qualified extension property name to be used for updating the intended types. 201 Created { “objectId”: “5ea3a29b-8efd-46bf-9dc7-f226e839d146”, “objectType”: “ExtensionProperty”, “name”: “extension_d8dde29f1095422e91537a6cb22a2f74_skypeId”, “dataType”: “String”,
“targetObjects”: [“User”] }



Viewing Directory Extensions Registered by your Application
You can view extensions registered by your application by issuing a GET of the extension properties of the application. This will provide object ID, data type, and target objects for each extension registered by the application. GET https://graph.windows.net/contoso.com/applications//extensionProperties?api-version=1.21-preview 



Unregistering an Extension
You can unregister an extension registered by your application by issuing a DELETE of the extension object ID as follows: DELETE https://graph.windows.net/contoso.com/applications//extensionProperties/?api-version=1.21-preview 



Writing Extension Values
Once this application is consented by the admin, any user in the tenant can be updated to include this new property. For example, PATCH https://graph.windows.net/contoso.com/users/joe@contoso.com?api-version=1.21-preview { “extension_d8dde29f1095422e91537a6cb22a2f74_skypeId”: “joe.smith” } The server will return a 204 if user was successfully updated. The extension value can be removed by sending the same PATCH request with “null” value. PATCH https://graph.windows.net/contoso.com/users/joe@contoso.com?api-version=1.21-preview { “extension_d8dde29f1095422e91537a6cb22a2f74_skypeId”: null }



Reading Extension Values
When directory objects are retrieved, they automatically include the extension values. For example: GET https://graph.windows.net/contoso.com/users/joe@contoso.com?api-version=1.21-preview 200 OK { “objectId”: “ff7cd54a-84e8-4b48-ac5a-21abdbaef321”, “displayName”: “Joe Smith”, “userPrincipalName”: “joe@contoso.com“, “objectType”: “User”, “mail”: “null”, “accountEnabled”: “True” , “extension_d8dde29f1095422e91537a6cb22a2f74_skypeId”: “joe.smith” }



Filtering by Extension Values
The extension values can also be used as a part of $filter to search directory similar to any existing property. For example: GET https://graph.windows.net/contoso.com/users/joe@contoso.com?api-version=1.21-preview&$filter=extension_d8dde29f1095422e91537a6cb22a2f74_skypeId+eq+'joe.smith'



Sample Code
We have published a couple of samples to GitHub to showcase and illustrate the use of directory extensions. We plan to enhance them based on your feedback and as the feature evolves. 

PHP Sample
https://github.com/WindowsAzureAD/WindowsAzureAD-GraphAPI-Sample-PHP
This sample shows how to create directory extensions and use them on users of Windows Azure Active Directory. Settings.php contains the following information for a predefined tenant that should be updated to the developer's tenant to have write permissions using "Manage Access" option and selecting "Single sign-on, read and write directory data" access for your application.

The "Client ID" for the application should be used as $appPrincipalId and a new key can be created using "keys" section. The value generated must be used for $password.

$appObjectId is the unique object identifier of the application. This can be obtained by using "View Applications" link in the home page. That page will display all the applications defined in the current tenant including the appPrincipalId and the objectId.

$skypeExtension can be updated once an extension is created with it's fully qualified name.

public static $appTenantDomainName = 'graphdir1.onMicrosoft.com'; --> Name of the tenant or any verified domain. 
public static $appPrincipalId = '118473c2-7619-46e3-a8e4-6da8d5f56e12';
public static $appObjectId = 'fe82d9ae-b178-41f4-bf3f-8c4d7c35736e';
public static $password = 'hOrJ0r0TZ4GQ3obp+vk3FZ7JBVP+TX353kNo6QwNq7Q=';
public static $skypeExtension = 'extension_118473c2761946e3a8e46da8d5f56e12_skypeId';
