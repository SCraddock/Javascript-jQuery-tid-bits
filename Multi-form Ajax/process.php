<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = array();
$data = array();


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  if (isset($_POST)){
    // Checks to see if a bot has filled in the honeypot
    if(empty($_POST['bearTrap'])){


       // Sanitise Functions ====================================================
       // Cleans out strings, removing illegal characters
       function sanitiseString($dirty){
         $dirty = filter_var($dirty, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $clean = filter_var($dirty, FILTER_SANITIZE_STRING);
         return $clean;
       }
       // sanitises email address
       function sanitiseEmail($dirty){
         $clean = filter_var($dirty, FILTER_SANITIZE_EMAIL);
         return $clean;
       };
       // sanitises an interger
       function sanitiseNumber($dirty){
         $clean = filter_var($dirty, FILTER_SANITIZE_NUMBER_INT);
         return $clean;
       };


      $name =  sanitiseString(trim($_POST['name']));
      $email = sanitiseEmail(trim($_POST['email']));
      $formID = sanitiseString(trim($_POST['formID']));

      if($formID == 'General Enquiry') {
        $phone = sanitiseNumber(trim($_POST['phone']));
        $company = sanitiseString(trim($_POST['company']));
        $message = sanitiseString(trim($_POST['message']));

      } else if($formID == 'Brochure Request') {
        $address1 = sanitiseString(trim($_POST['address1']));
        $address2 = sanitiseString(trim($_POST['address2']));
        $town = sanitiseString(trim($_POST['town']));
        $postcode = sanitiseString(trim($_POST['postcode']));
      } else if($formID == 'Swatch Request') {
        $address1 = sanitiseString(trim($_POST['address1']));
        $address2 = sanitiseString(trim($_POST['address2']));
        $town = sanitiseString(trim($_POST['town']));
        $postcode = sanitiseString(trim($_POST['postcode']));
        $choices = sanitiseString(trim($_POST['choices']));
      }

      // IF EMPTY
      if (empty($name)) {
        $errors['name'] = 'Name is required';
      }
      if (empty($email)) {
        $errors['email'] = 'Email is required';
      } else if(filter_var($email, FILTER_VALIDATE_EMAIL) != true ){
        // If Email valid format
        $errors['email'] = 'Email not valid';
      }

      if($formID == 'General Enquiry') {
        if (empty($message)) {
          $errors['message'] = 'Message is required';
        }
      } else if($formID == 'Brochure Request' || $formID == 'Swatch Request') {
        if (empty($address1)) {
          $errors['address1'] = 'Address Line 1 is required';
        }
        if (empty($address2)) {
          $errors['address2'] = 'Address Line 2 is required';
        }
        if (empty($town)) {
          $errors['town'] = 'Town/City is required';
        }
        if (empty($postcode)) {
          $errors['postcode'] = 'Postcode is required';
        }

        if($formID == 'Swatch Request') {
          if (empty($choices)) {
            $errors['choices'] = 'Please choose at least one swatch';
          }
        }
      }

      // return a response ===========================================================

      // if there are any errors in our errors array, return a success boolean of false

      if ( !empty($errors)) {
        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
      } else {
          // if there are no errors process our form, then return a message
            $to      = 'vfallon@ikon-rotational.co.uk, reception@ikon-rotational.co.uk';


            $subject = 'Ikon - '. $formID;

            $emailContent = 'Name: '. $name . "\n";
            $emailContent .= 'Email: '. $email . "\n";

            if(!empty($phone)) {
              $emailContent .= 'Phone: '. $phone . "\n";
            }

            if(!empty($company)) {
              $emailContent .= 'Company: '. $company . "\n";
            }

            if(!empty($message)) {
              $emailContent .= 'Message: '. $message . "\n";
            }

            if(!empty($address1)) {
              $emailContent .= 'Address Line 1: '. $address1 . "\n";
            }

            if(!empty($address2)) {
              $emailContent .= 'Address Line 2: '. $address2 . "\n";
            }

            if(!empty($town)) {
              $emailContent .= 'Town/City: '. $town . "\n";
            }

            if(!empty($postcode)) {
              $emailContent .= 'Postcode: '. $postcode . "\n";
            }

            if(!empty($choices)) {
              $emailContent .= 'Swatches: '. $choices . "\n";
            }

            $headers = 'From: noreply@ikon-rotational.co.uk' . "\r\n" .
                'Reply-To: '. $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
             mail($to, $subject, $emailContent, $headers);


          // show a message of success and provide a true success variable
          $data['success'] = true;
          $data['message'] = 'Thanks, your message was sent';

      };

      // return all our data to an AJAX call
      echo json_encode($data);

    } else {
      die("Sorry, we like our customers to be human.");
    };

  } else {
    die("Sorry, something went wrong.");
  };

} else {
  die("Sorry, something went wrong.");
};
?>
