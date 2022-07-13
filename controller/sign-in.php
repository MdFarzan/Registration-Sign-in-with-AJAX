<?php

require_once('../config/db.php');

$db = new mysqli(DB_HOST, DB_USER, DB_PASSKEY, DB_NAME);

// if error
if($db->connect_error){
   die('Something went wrong please try again!');
}

// connected
else{
    
    extract($_POST);
    
    // validation
    $errors = [
                'email_error' => validateEmail($email),
                'passkey_error' => validatePassword($passkey)
    ];
    
    // any values is not true, means error
    if($errors['email_error'] !== true || $errors['passkey_error'] !== true){
        $errors['is_error'] = true;
        echo json_encode($errors);
    }

    // else all values are true, means no error
    else{

        // trimming data
        $email = trim($email);
        $passkey = md5($passkey);

        // checking is email exists
        $query = "SELECT * FROM user_registration WHERE email = '$email';";
        $data = $db->query($query);
        
        if($data->num_rows == 0){
            $errors['is_error'] = true;
            $errors['email_error'] = 'This email is not registered with us. Please registered first!';
            echo json_encode($errors);
        }
        
        else{
            
            if($data->num_rows > 0){
                $data = $data->fetch_array(MYSQLI_ASSOC);

                // checking password
                if($data['passkey'] == $passkey){
                    
                    session_start();
                    $_SESSION['SIGN_IN'] = true;
                    $_SESSION['USER_NAME'] = $data['full_name'];
                    echo json_encode(['status'=>'SUCCESS']);
                }
                    
            }

            else{
                echo json_encode(['status'=>'FAILED']);
            }

        }
        

        
    }
  

}


$db->close();


function validateFullName($name){
    if($name == ''){

        return  "This field cannot be empty!" ;
    }

    else if(preg_match("/^[a-zA-Z]([-']?[a-zA-Z]+)*( [a-zA-Z]([-']?[a-zA-Z]+)*)+$/", $name)){
        
        return true;
    }

    else{
        
        return "Please enter a valid full name!";
    }

}

function validateEmail($email){
    if($email == ''){
        
        return  "This field cannot be empty!" ;
    }

    else if(preg_match("/[a-z0-9]+@[a-z]+\.[a-z]{2,3}/", $email)){
        return true;
    }

    else{
        
        return "Please enter a valid email!";
    }

}

function validateMobileNo($mobile){
    if($mobile == ''){
        
        return  "This field cannot be empty!" ;
    }

    else if(preg_match("/^[0-9]{10}$/", $mobile)){
        return true;
    }

    else{
        
        return  "Please enter valid 10 digit mobile no.!" ;
    }

}

function validatePassword($passkey){
    if($passkey == ''){
        
        return  "This field cannot be empty!" ;
    }

    else if(strlen($passkey) < 6){
        
        return  "Password must be greater than 6 characters!" ;
    }

    else{
        return true;
    }

}