<?php
//function to connect to database
function doDB(){
    global $mysql;
    $mysql=mysqli_connect("localhost","root","","phpTutorial");

    if(mysqli_connect_errno()){
        printf("Connection failed : ",mysqli_connect_error());
        exit();
    }
}

//function to check email address
function emailChecker($email){
    global $mysqli,$safeEmail,$checkRes;
    $safeEmail=mysqli_real_escape_string($mysqli,$email);
    $checksql="SELECT id FROM subcribers WHERE email='".$safeEmail."'";
    $checkRes=mysqli_query($mysqli,$checksql);
}


