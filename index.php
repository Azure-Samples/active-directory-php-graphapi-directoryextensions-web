<HTML>
<head>
<?php
    //Include menu options applicable to all pages of the web site
    include("PhpSampleTemplate.php");
    //Enable the option to display any parsing errors.
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
?>
<title>
Windows Azure Active Directory Graph Sample
</title>
        <style>
    html *
    {
       color: #000 !important;
       font-family:"Segoe UI", Arial, Helvetica, sans-serif;
    }
    </style>
</head>
<BODY>
<h1>
    Windows Azure Active Directory Graph Sample
</h1>
<p>
    <a href="DisplayUsers.php"><b>User Management</b></a>
    <br/><br/>
    <a href="DisplayExtensions.php"><b>Extension Management</b></a>
    <br/><br/>
    <a href="DisplayApplications.php"><b>View Applications</b></a>
    <br/>
</p>
</BODY>
</HTML>