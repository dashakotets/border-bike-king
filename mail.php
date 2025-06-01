<?php
// mail.php
// This script processes the contact form submission and sends an email with the provided details.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data, trim() removes white space at the start and end of the string
    // htmlspecialchars() converts special characters to HTML entities to prevent XSS attacks
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = trim($_POST['email']);
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation to check fields aren't empty, doubles up on any JS validation fro the form
    if (!empty($name) && !empty($email) && !empty($message)) {
        $to      = 'dashacot1@gmail.com'; // Replace with your own email address
        $subject = "New Contact Form Message from $name";
        $body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $name <$email>";

        // Start the function, passing in variables for where to send the email,
        if (mail($to, $subject, $body, $headers)) {
            // If the email is sent successfully, redirect to a thank you page
            echo("Thank you for submitting a form");
            exit;
        } else {
            header("location: contacts.html?error=mail_failed");
            /* If the mail function fails, redirect back to the contact page with an error.
               Adding in functionality to handle the error would take a lesson in itself
               but for testing purposes if you see the mail_failed error in the contact.html url
               you will know that the mail function failed. */
            exit;
        }
    } else {
        /* If any variable is empty, redirect back to the contact page
           A little redundant here if you have done JS validation,
           but it's good to have server-side validation as well. */
        header("location: contacts.html");
        exit;
    }
} else {
    // If the request method is not POST, redirect back to the contact page
    header("location: contacts.html");
    exit;
}
?>
