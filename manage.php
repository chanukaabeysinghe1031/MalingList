<?php
include 'include.php';
if (!$_POST) {
    $display_block = <<<END_OF_BLOCK
        <form method="POST" action="$_SERVER[PHP_SELF]">
            <p><label for="email">Your Email Address :</label><br/>>
            <input type="email" id="email" name="email" size="40" maxlength="150"/> </p>

            <fieldset>
                <legend>Action : </legend><br/>
                <input type="radio" id="actionSub" name="action" value="sub" checked>
                <label for="actionSub">Subcribe</label> 
                <input type="radio" id="actionUnSub" name="action" value="unsub">  
                <label for="actionUnSub">Unsubcribe</label>
            </fieldset>

            <button type="submit" name="submit" value="submit">Submit</button>
        </form>
END_OF_BLOCK;
}else if (($_POST)&&($_POST['action']=='sub')){
    if($_POST[email==""]){
        header("Location : manage.php");
        exit();
    }else {
        doDB();
        emailChecker($_POST['email']);

        if (mysqli_num_row($checkRes) < 1) {
            mysqli_free_result($checkRes);
            $addsql = "INSERT INTO subcribers (email) Values('" . $safeEmail . "')";
            $addres = mysqli_query($mysqli, $addsql) or die(mysqli_error($mysqli));
            $displayBlock = "<p>Thanks For Signing Up</p>";
            mysqli_close($mysqli);
        } else {
            $displayBlock = "<p>You are already subscribed!</p>";
        }
    }

}else if(($_POST)&&($_POST['action']=='unsub')){

    if($_POST[email==""]){
        header("Location : manage.php");
        exit();
    }else {
        //connect to the database
        doDB();
        //check the database ehether email is existing or not
        emailChecker($_POST['email']);

        if (mysqli_num_row($checkRes) < 1) {
            mysqli_free_result($checkRes);
            $mysqli_free_result($checkRes);
            $displayBlock = "<p>Couldn't find youe email address ! No action was taken.</p>";
            mysqli_close($mysqli);
        } else {
            //get value id from result
            while($row=mysqli_fetch_row($mysqli)){
                $id=$row['id'];
            }

            //unsubscribe the address
            $delSql="DELETE FROM subcribers WHERE id='".$id."'";
            $delRes=mysqli_query($mysqli,$delSql) or die (mysqli_error($mysqli));
            $displayBlock = "<p>You are unsubcribed successfully!!/p>";
        }
        mysqli_close($mysqli);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Subcribe/Unsubcribe to a Mailing List</title></head>
<body>
<h1>Subcribe / Unsubcribe to  a Mailing List</h1>
<?php echo "$display_block"?>
</body>
</html>
