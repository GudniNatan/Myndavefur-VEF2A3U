<?php
require_once('./includes/autoload.php');
$errors = [];
$missing = [];

// function to check for suspect phrases
function isSuspect($val, $pattern, &$suspect) {
    // if the variable is an array, loop through each element
    // and pass it recursively back to the same function
    if (is_array($val)) {
        foreach ($val as $item) {
            isSuspect($item, $pattern, $suspect);
        }
    } else {
        // if one of the suspect phrases is found, set Boolean to true
        if (preg_match($pattern, $val)) {
            $suspect = true;
        }
    }
}
// check if the form has been submitted
if (isset($_POST['sendregister'])) { //Register
    $expected = ['username', 'password', 'email', 'firstname', 'lastname', 'sq1', 'sq2', 'sq1ans', 'sq2ans'];
    // set required fields
    $required = ['username', 'password', 'email', 'firstname', 'lastname', 'sq1', 'sq2', 'sq1ans', 'sq2ans'];
    // assume nothing is suspect
    $suspect = false;
    // create a pattern to locate suspect phrases
    $pattern = '/Content-Type:|Bcc:|Cc:/i';

    // check the $_POST array and any subarrays for suspect content
    isSuspect($_POST, $pattern, $suspect);

    if (!$suspect) {
        foreach ($_POST as $key => $value) {
            // assign to temporary variable and strip whitespace if not an array
            $temp = is_array($value) ? $value : trim($value);
            // if empty and required, add to $missing array
            if (empty($temp) && in_array($key, $required)) {
                $missing[] = $key;
                ${$key} = '';
            } elseif (in_array($key, $expected)) {
                // otherwise, assign to a variable of the same name as $key
                ${$key} = $temp;
            }
        }
        foreach ($required as $key => $value) {
            //if required variable does not exist
            if (!isset(${$value})) {
                $missing[] = $value;
            }
        }
    }
    // validate the user's email
    if (!$suspect && !empty($email)) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $validemail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$validemail) {
            $errors['email'] = true;
        }
    }
    if (!empty($_POST["g-recaptcha-response"]))
    {
        $response = $_POST["g-recaptcha-response"];
        $secret = "6LdLtxcTAAAAAPl7aQ1Oa7Sm7vAVAj5k8FKO2Rqg";
        $siteKey = '6LdLtxcTAAAAAJrk7gzmEJmNJYoGyt9kpqBDm3_g';
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $remoteip);
        if (!$resp->isSuccess()){
            $errors['g-recaptcha'] = $resp->getErrorCodes();
        }
    }
    else{
        $missing['g-recaptcha'] = true;
    }
    if (!$suspect && !$missing && !$errors) {//Validated
        $validRegister = true;
    }
}
if (isset($_POST['sendupdate'])) { //Register
    $expected = ['username', 'password', 'email'];
    // set required fields
    $required = ['username', 'password', 'email'];
    // assume nothing is suspect
    $suspect = false;
    // create a pattern to locate suspect phrases
    $pattern = '/Content-Type:|Bcc:|Cc:/i';

    // check the $_POST array and any subarrays for suspect content
    isSuspect($_POST, $pattern, $suspect);

    if (!$suspect) {
        foreach ($_POST as $key => $value) {
            // assign to temporary variable and strip whitespace if not an array
            $temp = is_array($value) ? $value : trim($value);
            // if empty and required, add to $missing array
            if (empty($temp) && in_array($key, $required)) {
                $missing[] = $key;
                ${$key} = '';
            } elseif (in_array($key, $expected)) {
                // otherwise, assign to a variable of the same name as $key
                ${$key} = $temp;
            }
        }
        foreach ($required as $key => $value) {
            //if required variable does not exist
            if (!isset(${$value})) {
                $missing[] = $value;
            }
        }
    }
    // validate the user's email
    if (!$suspect && !empty($email)) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $validemail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$validemail) {
            $errors['email'] = true;
        }
    }
    if (!$suspect && !$missing && !$errors) {//Validated
        $validUpdate = true;
    }
}
if (isset($_POST['sendlogin'])) { //Login
    $expected = ['login_username', 'login_password'];
    // set required fields
    $required = ['login_username', 'login_password'];
    // assume nothing is suspect
    $suspect = false;
    // create a pattern to locate suspect phrases
    $pattern = '/Content-Type:|Bcc:|Cc:/i';

    // check the $_POST array and any subarrays for suspect content
    isSuspect($_POST, $pattern, $suspect);

    if (!$suspect) {
        foreach ($_POST as $key => $value) {
            // assign to temporary variable and strip whitespace if not an array
            $temp = is_array($value) ? $value : trim($value);
            // if empty and required, add to $missing array
            if (empty($temp) && in_array($key, $required)) {
                $missing[] = $key;
                ${$key} = '';
            } elseif (in_array($key, $expected)) {
                // otherwise, assign to a variable of the same name as $key
                ${$key} = $temp;
            }
        }
        foreach ($required as $key => $value) {
            //if required variable does not exist
            if (!isset(${$value})) {
                $missing[] = $value;
            }
        }
    }
    if (!$suspect && !$missing && !$errors) {//Validated
        $validLogin = true;
    }
}
if (isset($_POST['reviewImage'])) { //Login
    $expected = ['nafn', 'texti', 'flokkur', 'visibility'];
    // set required fields
    $required = ['nafn'];
    // assume nothing is suspect
    $suspect = false;
    // create a pattern to locate suspect phrases
    $pattern = '/Content-Type:|Bcc:|Cc:/i';

    // check the $_POST array and any subarrays for suspect content
    isSuspect($_POST, $pattern, $suspect);

    if (!$suspect) {
        foreach ($_POST as $key => $value) {
            // assign to temporary variable and strip whitespace if not an array
            $temp = is_array($value) ? $value : trim($value);
            // if empty and required, add to $missing array
            if (is_array($temp)) {
                foreach ($temp as $otherKey => $otherValue) {
                    if (empty($otherValue) && in_array($key, $required)) {
                    $missing[] = $key;
                    }
                }
            }
            if (empty($temp) && in_array($key, $required)) {
                $missing[] = $key;
                ${$key} = '';
            } elseif (in_array($key, $expected)) {
                // otherwise, assign to a variable of the same name as $key
                ${$key} = $temp;
            }
        }
        foreach ($required as $key => $value) {
            //if required variable does not exist
            if (!isset(${$value})) {
                $missing[] = $value;
            }
        }
    }
    if (!$suspect && !$missing && !$errors) {//Validated
        $validReview = true;
    }
}
