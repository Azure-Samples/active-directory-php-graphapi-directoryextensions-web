<?php
    //Include menu options applicable to all pages of the web site
    include("PhpSampleTemplate.php");
?>

<HTML>
    <head>
        <title>
            Administration Page For extensions
        </title>    
		 <link rel="stylesheet" type="text/css" href="StyleSheet.css" />
    </head>

    <BODY>
        <h1>
            /extensions
        </h1>  
        <a href="CreateExtension.php"><b>Create And Add A New extension</b></a>    
        <br/><br/>
        <table id="directoryObjects">
            <tr>
            <th>Name</th>
            <th>Data Type</th>
            <th>Target Objects</th>
            </tr>  
            <?php
                $extensions = GraphServiceAccessHelper::getFeed('applications/'.Settings::$appObjectId.'/extensionProperties');    
                if (isset($extensions))
                {   
                    foreach ($extensions as $extension){
                        echo('<tr><td>'. $extension->{'name'}. '</td><td>'. $extension->{'dataType'} .'</td><td>'. implode(", ", $extension->{'targetObjects'}) .'</td></tr>');
                    }
                }
            ?>
        </table>
    </BODY>
</HTML>