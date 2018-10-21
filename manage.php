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
        doDB();
        emailChecker($_POST['email']);

        if (mysqli_num_row($checkRes) < 1) {
            mysqli_free_result($checkRes);

            $displayBlock = "<p>Thanks For Signing Up</p>";
            mysqli_close($mysqli);
        } else {
            $displayBlock = "<p>You are already subscribed!</p>";
        }
    }
}
