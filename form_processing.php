<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $preferences = htmlspecialchars($_POST['preferences']);
    $zipCode = htmlspecialchars($_POST['zipCode']);

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Save the data to a file (optional)
    $file = fopen("submissions.txt", "a");
    if ($file) {
        fwrite($file, "Name: $name\nEmail: $email\nPreferences: $preferences\nZip Code: $zipCode\n\n");
        fclose($file);
    } else {
        echo "Unable to save your submission. Please try again later.";
        exit;
    }

    // Send an email
    $to = "duneblack11@gmail.com"; // Replace with your email address
    $subject = "New Adoption Inquiry";
    $message = "Name: $name\nEmail: $email\nPreferences: $preferences\nZip Code: $zipCode";
    $headers = "From: no-reply@yourwebsite.com"; // Replace with your website's email address

    if (mail($to, $subject, $message, $headers)) {
        // Redirect to Petfinder
        header("Location: https://www.petfinder.com/");
        exit;
    } else {
        echo "There was an error sending your submission. Please try again.";
    }
}
?>
