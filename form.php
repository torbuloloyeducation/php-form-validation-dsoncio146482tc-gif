<?php

$name = $email = $gender = $website = $phone = "";
$password = $confirm_password = "";
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$phoneErr = $passwordErr = $confirmPasswordErr = $termsErr = "";
$attempt = 0;


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if (isset($_POST['attempt'])) {
        $attempt = $_POST['attempt'] + 1;
    }

    
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

  
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
    }

  
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }

    
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }

    
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm your password";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

   
    if (!isset($_POST['terms'])) {
        $termsErr = "You must agree to the terms";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .error { color: red; }
    </style>
</head>
<body>

<h2>PHP Form Validation</h2>

<p>Submission attempt: <?php echo $attempt; ?></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <input type="hidden" name="attempt" value="<?php echo $attempt; ?>">

    Name: <input type="text" name="name" value="<?php echo $name; ?>">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>

    Email: <input type="text" name="email" value="<?php echo $email; ?>">
    <span class="error">* <?php echo $emailErr; ?></span>
    <br><br>

    Website: <input type="text" name="website" value="<?php echo $website; ?>">
    <span class="error"><?php echo $websiteErr; ?></span>
    <br><br>

    Phone: <input type="text" name="phone" value="<?php echo $phone; ?>">
    <span class="error">* <?php echo $phoneErr; ?></span>
    <br><br>

    Gender:
    <input type="radio" name="gender" value="female" <?php if ($gender=="female") echo "checked"; ?>> Female
    <input type="radio" name="gender" value="male" <?php if ($gender=="male") echo "checked"; ?>> Male
    <span class="error">* <?php echo $genderErr; ?></span>
    <br><br>

    Password: <input type="password" name="password">
    <span class="error">* <?php echo $passwordErr; ?></span>
    <br><br>

    Confirm Password: <input type="password" name="confirm_password">
    <span class="error">* <?php echo $confirmPasswordErr; ?></span>
    <br><br>

    <input type="checkbox" name="terms" <?php if(isset($_POST['terms'])) echo "checked"; ?>>
    I agree to the terms
    <span class="error">* <?php echo $termsErr; ?></span>
    <br><br>

    <input type="submit" name="submit" value="Submit">

</form>

<?php
// Display output (except password)
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    empty($nameErr) && empty($emailErr) && empty($genderErr) &&
    empty($phoneErr) && empty($passwordErr) &&
    empty($confirmPasswordErr) && empty($termsErr) && empty($websiteErr)) {

    echo "<h3>Your Input:</h3>";
    echo "Name: $name <br>";
    echo "Email: $email <br>";
    echo "Website: $website <br>";
    echo "Phone: $phone <br>";
    echo "Gender: $gender <br>";
}
?>

</body>
</html>