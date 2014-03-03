<?php
    //Include menu options applicable to all pages of the web site
    include("PhpSampleTemplate.php");
    require_once 'Settings.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            Create an Extension
        </title>
        <link rel="stylesheet" type="text/css" href="StyleSheet.css" />
    </head>
    <body>
        <?php
            // If this was not a post back show the create user form
            if (!isset($_POST['submit'])) {          
        ?>        
        <form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">            
            <table>
                
                <tr><td><b>Name:</b></td><td><input type="text" size="20" maxlength="15" name="extensionName"></td></tr>
                <tr><td><b>Data Type:</b></td><td><select name="dataType"><option>String</option><option>Binary</option></select></td></tr>
                <tr><td><b>Target Objects:</b></td><td><input type="checkbox" name="targetObjects[]" value="User">User</td></tr>
                <tr><td></td><td><input type="checkbox" name="targetObjects[]" value="TenantDetail">TenantDetail</td></tr>
                <tr><td></td><td><input type="checkbox" name="targetObjects[]" value="Group">Group</td></tr>
                <tr><td></td><td><input type="checkbox" name="targetObjects[]" value="Device">Device</td></tr>
                <tr><td></td><td><input type="checkbox" name="targetObjects[]" value="Application">Application</td></tr>
                <tr><td></td><td><input type="checkbox" name="targetObjects[]" value="ServicePrincipal">Service Principal</td></tr>
                <tr><td><input type="submit" value="submit" name="submit"></td></tr> 
            </table>
        </form>        
 <?php
 } else {
            if((empty($_POST["extensionName"])) or (empty($_POST["dataType"])) or (empty($_POST["targetObjects"]))) {
                echo('<p>One of the required fields is empty. Please go back to <a href="CreateExtension.php">Create Extension</a></p>');
            }
            else {
                $name = $_POST["extensionName"];
                $dataType = $_POST["dataType"];
                $targetObjects = $_POST["targetObjects"];
                $extension = array(
                    'name'=> $name,
                    'dataType' => $dataType ,
                    'targetObjects' => $targetObjects);

                // Create the extension
                $extensionCreated = GraphServiceAccessHelper::addEntryToFeed('applications/'.Settings::$appObjectId.'/extensionProperties',$extension);
               
                // Check to see if we got back an error.
                if(!empty($extensionCreated->{'odata.error'}))
                {
                    $message = $extensionCreated->{'odata.error'}->{'message'};
                    echo('<p>Extension creation failed. Service returned error:<b>'.$message->{'value'}. '</b>  Please go back to <a href="createExtension.php">Create Extension</a></p>');
                }
                else {
                    header('Location: DisplayExtensions.php');
                }
            }
 }
 ?>        
</body>
</html>
