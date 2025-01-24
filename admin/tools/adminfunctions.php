<?php
    
    function validate_field($field){
        $field = htmlentities($field);
        if(strlen(trim($field))<1){
            return false;
        }else{
            return true;
        }
    }

    function validate_librarianemail($librarianEmail){
        // Check if the 'email' key exists in the $_POST array
        if (isset($librarianEmail)) {
            $librarianEmail = trim($librarianEmail); // Trim whitespace
            // Check if the email is not empty
            if (empty($librarianEmail)) {
                return 'Email is required';
            } else if (!filter_var($librarianEmail, FILTER_VALIDATE_EMAIL)) {
                // Check if the email has a valid format
                return 'Email is invalid format';
            } else {
                return 'success';
            }
        } else {
            return 'Email is required'; // 'email' key doesn't exist in $_POST
        }
    }    

    function validate_librarianpassword($librarianPassword) {
        $librarianPassword = htmlentities($librarianPassword);
        
        if (strlen(trim($librarianPassword)) < 1) {
            return "Password cannot be empty";
        } elseif (strlen($librarianPassword) < 8) {
            return "Password must be at least 8 characters long";
        } else {
            return "success"; // Indicates successful validation
        }
    }

    function validate_attendancecheckeremail($acEmail){
        // Check if the 'email' key exists in the $_POST array
        if (isset($acEmail)) {
            $acEmail = trim($acEmail); // Trim whitespace
            // Check if the email is not empty
            if (empty($acEmail)) {
                return 'Email is required';
            } else if (!filter_var($acEmail, FILTER_VALIDATE_EMAIL)) {
                // Check if the email has a valid format
                return 'Email is invalid format';
            } else {
                return 'success';
            }
        } else {
            return 'Email is required'; // 'email' key doesn't exist in $_POST
        }
    }    

    function validate_attendancecheckerpassword($acPassword) {
        $acPassword = htmlentities($acPassword);
        
        if (strlen(trim($acPassword)) < 1) {
            return "Password cannot be empty";
        } elseif (strlen($acPassword) < 8) {
            return "Password must be at least 8 characters long";
        } else {
            return "success"; // Indicates successful validation
        }
    }
    
    // function validate_contact($POST) {
    //     $pattern = "#^\d{11}$#";
    
    //     if (preg_match($pattern, $POST['librarian_contactno'])) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // function validate_cpw($password, $cpassword){
    //     $pw = htmlentities($password);
    //     $cpw = htmlentities($cpassword);
    //     if(strcmp($pw, $cpw) == 0){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    function validate_adminemail($adminEmail){
        // Check if the 'email' key exists in the $_POST array
        if (isset($adminEmail)) {
            $adminEmail = trim($adminEmail); // Trim whitespace
            // Check if the email is not empty
            if (empty($adminEmail)) {
                return 'Email is required';
            } else if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                // Check if the email has a valid format
                return 'Email has invalid format';
            } else {
                return 'success';
            }
        } else {
            return 'Email is required'; // 'email' key doesn't exist in $_POST
        }
    }

    function validate_adminpassword($adminPassword) {
        $adminPassword = htmlentities($adminPassword);
        
        if (strlen(trim($adminPassword)) < 1) {
            return "Password cannot be empty";
        } elseif (strlen($adminPassword) < 8) {
            return "Password must be at least 8 characters long";
        } else {
            return "success"; // Indicates successful validation
        }
    }    

    function validate_admincpw($adminPassword, $confirmpassword){
        $pw = htmlentities($adminPassword);
        $cpw = htmlentities($confirmpassword);
        if(strcmp($pw, $cpw) == 0){
            return true;
        }else{
            return false;
        }
    }

    function validate_clubname($clubName){
        // Check if the 'email' key exists in the $_POST array
        if (isset($clubName)) {
            $clubName = trim($clubName); // Trim whitespace
            // Check if the email is not empty
            if (empty($clubName)) {
                return 'Club name is required';
            } else {
                return 'success';
            }
        } else {
            return 'Club name is required'; // 'email' key doesn't exist in $_POST
        }
    }  

?>