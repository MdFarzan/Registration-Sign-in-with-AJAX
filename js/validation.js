/* 
    validation.js
    contains functions for fields validation
*/

const DEFAULT_BORDER = '1px solid #ced4da';

function validateFullName(elm, errorElm){
    let val = elm.value;
    errorElm.innerHTML = '';
    elm.style.border = DEFAULT_BORDER;

    let pattern = /^[a-zA-Z]([-']?[a-zA-Z]+)*( [a-zA-Z]([-']?[a-zA-Z]+)*)+$/g;
    if(val == ""){
        
        elm.style.border = "1px solid red";
        
        errorElm.innerHTML = "This value cannot be empty!";
        return false;
    }

    else if(pattern.test(val)){    
        
        return true;
    }

    else{

        elm.style.border = "1px solid red";
        errorElm.innerHTML = "Please enter a valid full name!";
        return false;
    }
        
}


// validate email
function validateEmail(elm, errorElm){
    val = elm.value;
    errorElm.innerHTML = '';
    elm.style.border = DEFAULT_BORDER;

    let pattern =  /[a-z0-9]+@[a-z]+\.[a-z]{2,3}/g;
    
    if(val == ''){
        errorElm.innerHTML = 'This field cannot be empty!';
        elm.style.border = '1px solid red';
        return false;
    }

    else if(pattern.test(val)){
        return true;
    }

    else{
        errorElm.innerHTML = 'Please enter valid email!';
        elm.style.border = '1px solid red';
        return false;
    }

}


// validate mobile no
function validateMobileNo(elm, errorElm){
    
    let val = elm.value;
    errorElm.innerHTML = '';
    elm.style.border = DEFAULT_BORDER;

    if(val == ''){
        elm.style.border = '1px solid red';
        errorElm.innerHTML = "This field cannot be empty!"
        return false;
    }

    else if(/^[0-9]{10}$/.test(val)){
        return true;
    }

    else{
        elm.style.border = '1px solid red';
        errorElm.innerHTML = 'Please enter validate Mobile 10 digit No.!';
        return false;
    }

}


// validate mobile no
function validatePassword(elm, errorElm){
    let val = elm.value;
    elm.style.border = DEFAULT_BORDER;
    errorElm.innerHTML =  '';

    if(val == ''){
        elm.style.border = '1px solid red';
        errorElm.innerHTML = 'This field cannot be empty!';
        return false;
    }

    else if(val.length <= 6){
        elm.style.border = '1px solid red';
        errorElm.innerHTML = 'Password must be more than 6 characters!';
        return false;
    }

    else{
        return true;
    }
  
}