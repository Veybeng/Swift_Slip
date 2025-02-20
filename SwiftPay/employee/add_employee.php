<?php
include '../connect.php';

require '../../phpmailer/includes/PHPMailer.php';
require '../../phpmailer/includes/SMTP.php';
require '../../phpmailer/includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $hire_date = $_POST["hire_date"];
    $position_id = $_POST["position_id"];
    $department_id = $_POST["department_id"];
    $jobstatus_id = $_POST["jobstatus_id"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $deduction_ids = $_POST["deduction_id"]; // New deduction field (assuming it's an array)

    // Use implode to join multiple deduction IDs into a comma-separated string
    $deduction_id = implode(',', $deduction_ids);

    // Perform the database insert operation
    $insertEmployeeQuery = "INSERT INTO employee (first_name, last_name, hire_date, position_id, department_id, jobstatus_id, password, deduction_id, email) VALUES ('$first_name', '$last_name', '$hire_date', '$position_id', '$department_id', '$jobstatus_id', '$password', '$deduction_id', '$email')";

    if (mysqli_query($con, $insertEmployeeQuery)) {
        // Send an email to the newly added employee
       

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "imo email Von";
        $mail->Password = "Password nimo"; // Replace with your Gmail password

        $mail->Subject = "Account Created";
        $mail->setFrom("Email nimo Von");
        $mail->addAddress($email); // Send the email to the newly added employee

        $mail->isHTML(true);
        $mail->Body = "Dear $first_name $last_name,<br><br>We have successfully created your account. You can now log in using the provided credentials:<br><br>Username: $email<br>Password: $password<br><br>Thank you for joining our organization.";

        if ($mail->Send()) {
            echo "Employee added, and email sent successfully!";
        } else {
            echo "Employee added, but email not sent: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error inserting employee: " . mysqli_error($con);
    }
}
?>
