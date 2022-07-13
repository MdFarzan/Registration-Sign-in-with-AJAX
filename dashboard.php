<?php
    session_start();
    if(isset($_SESSION['SIGN_IN']) && $_SESSION['SIGN_IN'] == true){
        echo "Welcome ".$_SESSION['USER_NAME'];
    }

    else{
        header('Location: sign-in.php');
    }