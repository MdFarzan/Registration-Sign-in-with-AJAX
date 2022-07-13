<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="css/style.css" />

</head>

<body class="form-main">
    <main class="d-flex justify-content-center align-items-center vh-100 overflow-y">
        <section class="form-wrap">
            <div class="form-header text-center text-white">
                <h1>Sign In</h1>
                <p class="mb-0 ct-text">Welcome, Please sign in to proceed</p>
            </div>

            <div class="form-body text-white">
                <form autocomplete="off">

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required />
                        <div id="emailError" class="form-text text-danger field-error"></div>
                    </div>

                    <div class="mb-3">
                        <input type="password" name="passkey" class="form-control" id="passkey" placeholder="Password" required />
                        <div id="passkeyError" class="form-text text-danger field-error"></div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary rounded-0" id="form-btn">Sign In</button>
                    </div>

                    <p class="text-center mt-4 ct-text">Not Register Yet? <a href="index.php" title="Register Now">Register Now</a></p>
                </form>
            </div>

        </section>

    </main>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- main js -->
    <script src="js/script.js"></script>
    <script src="js/validation.js"></script>
    <script>
        let errors = [];

        // validating fields
        document.querySelector('#form-btn').addEventListener('click', function() {
            event.preventDefault();

            errors[1] = validateEmail(document.querySelector('#email'),
                document.querySelector('#email').nextElementSibling);

            errors[3] = validatePassword(document.querySelector('#passkey'),
                document.querySelector('#passkey').nextElementSibling);


            if (!errors.includes(false)) {
                let form = new FormData(document.forms[0]);


                let xhr = new XMLHttpRequest();
                
                xhr.onreadystatechange = ()=>{

                    // on success
                    if(xhr.readyState == 4){

                        if(xhr.status == 200){
                            let response = JSON.parse(xhr.responseText);
                            if(response.is_error == true){
                                showServerError('#emailError', response.email_error);
                                showServerError('#passkeyError', response.passkey_error);
                            }

                            else if(response.status == 'SUCCESS'){
                                alert('Signed in Successfully');
                                window.location.href = 'dashboard.php';
                            }
                            
                            else{
                                alert('Error! Something went wrong please try again.');
                            }
                            
                        }
                        else{
                            alert('Error! Unable to Sign In!);                                                                                                                                                                                                                                                 ');
                        }
                        
                    }

                }
                xhr.open('post','controller/sign-in.php', true);
                xhr.send(form);
            }

            else{
                alert('Error: Please ensure all fields are correct!');
            }

        });
    </script>
</body>

</html>