<?php
    //Include menu options applicable to all pages of the web site
    include("PhpSampleTemplate.php");
?>

<HTML>
    <head>
        <title>
            Administration Page For applicationss
        </title>    
		 <link rel="stylesheet" type="text/css" href="StyleSheet.css" />
    </head>

    <BODY>
        <h1>
            /applications
        </h1>  
        <br/><br/>
        <table id="directoryObjects">
            <tr>
            <th>Name</th>
            <th>ObjectId</th>
            <th>AppPrincipalId</th>
            </tr>  
            <?php
                $applications = GraphServiceAccessHelper::getFeed('applications');    
                if (isset($applications))
                {   
                    foreach ($applications as $applications){
                        echo('<tr><td>'. $applications->{'displayName'}. '</td><td>'. $applications->{'objectId'} .'</td><td>'. $applications->{'appId'}.'</td></tr>');
                    }
                }
            ?>
        </table>
    </BODY>
</HTML>