<?php
    
    function validate_field($field){
        $field = htmlentities($field);
        if(strlen(trim($field))<1){
            return false;
        }else{
            return true;
        }
    }

    function validate_useremail($customerEmail){
        // Check if the 'email' key exists in the $_POST array
        if (isset($customerEmail)) {
            $customerEmail = trim($customerEmail); // Trim whitespace
            // Check if the email is not empty
            if (empty($customerEmail)) {
                return 'Email is required';
            } else if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                // Check if the email has a valid format
                return 'Email has invalid format';
            } else {
                return 'success';
            }
        } else {
            return 'Email is required'; // 'email' key doesn't exist in $_POST
        }
    }

    function validate_userpassword($customerPassword) {
        $customerPassword = htmlentities($customerPassword);
        
        if (strlen(trim($customerPassword)) < 1) {
            return "Password cannot be empty";
        } elseif (strlen($customerPassword) < 8) {
            return "Password must be at least 8 characters long";
        } else {
            return "success"; // Indicates successful validation
        }
    }    

    function validate_usercpw($customerPassword, $confirmpassword){
        $pw = htmlentities($customerPassword);
        $cpw = htmlentities($confirmpassword);
        if(strcmp($pw, $cpw) == 0){
            return true;
        }else{
            return false;
        }
    }

?>