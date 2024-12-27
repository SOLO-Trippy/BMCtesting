<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $phone = htmlspecialchars($_POST['phone']);
    $gender = htmlspecialchars($_POST['gender']);
    $age = htmlspecialchars($_POST['age']);
    $email = htmlspecialchars($_POST['email']);
    $familySize = htmlspecialchars($_POST['familySize']);

    $to = "your-email@example.com";  // Replace with your email address
    $subject = "New Application from $firstname $lastname";
    $body = "First Name: $firstname\nLast Name: $lastname\nPhone: $phone\nGender: $gender\nAge: $age\nEmail: $email\nFamily Size: $familySize";
    $headers = "From: $email";

    // Handle file upload
    if (isset($_FILES['idProof']) && $_FILES['idProof']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['idProof']['tmp_name'];
        $file_name = $_FILES['idProof']['name'];
        $file_size = $_FILES['idProof']['size'];
        $file_type = $_FILES['idProof']['type'];
        $file_name_cmps = explode(".", $file_name);
        $file_extension = strtolower(end($file_name_cmps));

        // Sanitize file name
        $new_file_name = md5(time() . $file_name) . '.' . $file_extension;

        // Directory to save uploaded file
        $upload_file_dir = './uploaded_files/';
        $dest_path = $upload_file_dir . $new_file_name;

        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            $body .= "\n\nProof of Identification: " . $dest_path;
        } else {
            echo "Error uploading the file";
            exit;
        }
    }

    if (mail($to, $subject, $body, $headers)) {
        echo "Application sent successfully!";
    } else {
        echo "Failed to send application. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
