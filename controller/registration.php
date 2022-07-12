<?php

require_once('../config/db.php');

$db = new mysqli(DB_HOST, DB_USER, DB_PASSKEY, DB_NAME);

// if error
if($db->connect_error){
   die('Someting went wrong please try again!');
}

// connected
else{
    
    extract($_POST);
    
    // validation
    $errors = [
                'name_error' => validateFullName($full_name),
                'email_error' => validateEmail($email),
                'mobile_error' => validateMobileNo($mobile_no),
                'passkey_error' => validatePassword($passkey)
    ];
    
    // any values is not true, means error
    if($errors['name_error'] !== true || $errors['email_error'] !== true ||
        $errors['mobile_error'] !== true || $errors['passkey_error'] !== true){

        $errors['is_error'] = true;
        echo json_encode($errors);
    }

    // else all values are true, means no error
    else{

        // trimming data
        
        $full_name = trim($full_name);
        $email = trim($email);
        $mobile_no = trim($mobile_no);
        $passkey = md5($passkey);

        // checking is email exists
        $query = "SELECT * FROM user_registration WHERE email = '$email';";
        $data = $db->query($query);
        
        if($data->num_rows > 0){
            $errors['is_error'] = true;
            $errors['email_error'] = 'This email is already registered please Sign In!';
            echo json_encode($errors);
        }
        
        else{
            
            
            $query = "INSERT INTO user_registration(full_name, email, mobile_no, passkey) VALUES('$full_name', '$email', '$mobile_no', '$passkey')";
            if($db->query($query) === TRUE){
                echo json_encode(['status'=>'SUCCESS']);
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