<!--AMBER HOWE-->
<!--WEB210-25F-001-->
<!--DEC 1, 2025-->
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$statusMessage = '';
$statusClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $phone = strip_tags(trim($_POST["phone"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $sessionType = isset($_POST["session_type"]) ? strip_tags($_POST["session_type"]) : '';
    $message = htmlspecialchars(trim($_POST["message"]));

    if (empty($name) || empty($email) || empty($message)) {
        $statusMessage = 'Please fill in all required fields.';
        $statusClass = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $statusMessage = 'Please enter a valid email address.';
        $statusClass = 'error';
    } else {
        $mail = new PHPMailer(true);
        try {
            
            $mail->isSMTP();
            $mail->Host = 'mail.brendanmonroytherapy.ca';
            $mail->SMTPAuth = true;
            $mail->Username = 'brendan@brendanmonroytherapy.ca';
            $mail->Password = 'FX35v=2a!'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            
            $mail->setFrom('brendan@brendanmonroytherapy.ca', 'Brendan Monroy Psychotherapy');
            $mail->addAddress('brendan@brendanmonroytherapy.ca'); 
            $mail->addReplyTo($email, $name);

            
            $mail->isHTML(false);
            $mail->Subject = "New contact form submission from $name";
            $mail->Body = "Name: $name\nPhone: $phone\nEmail: $email\nSession Type: $sessionType\n\nMessage:\n$message\n";


            $mail->send();
            $statusMessage = 'Thank you! Your message has been sent.';
            $statusClass = 'success';
        } catch (Exception $e) {
            $statusMessage = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            $statusClass = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Brendan Monroy Psychotherapy</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/mobile.css" media="screen and (max-width: 900px)">

</head>
<body>

<header>
    <div class="container">
      <img src="Images/Untitled-3.png" alt="Logo" class="logo">
      <img src="Images/Untitled-2.png" alt="Logo" class="logo">
  
      <input type="checkbox" id="menu-toggle" />
      <label for="menu-toggle" class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </label>
  
      <nav class="mobile-nav">
        <a href="index.html">Home</a>
        <a href="services.html">Services</a>
        <a href="contactForm.php">Contact</a>
        <a href="janeapp.com" target="_blank" class="bookNow">Book Now</a>
      </nav>
  
      <nav class="desktop-nav">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="contactForm.php">Contact</a></li>
          <li><a href="janeapp.com" target="_blank" class="bookNow">Book Now</a></li>
        </ul>
      </nav>
    </div>
  </header>

<section class="contact-section">
    <div class="contact-container">
        <div class="contact-image">
            <img src="Images/stone2.jpg" alt="photo1">
            <div class="contact-image-text">
            <h1>Contact Us</h1>
            </div>
        </div>
        <div class="contact-form">
            <div class="contact-form-h1">
            <h1>Contact Us</h1>
        </div>


            <form action="contactForm.php" method="POST">

                <label>Name: (required)</label><br>
                <input type="text" name="name" required><br>

                <label>Phone:</label><br>
                <input type="tel" name="phone"><br>

                <label>Email: (required)</label><br>
                <input type="email" name="email" required><br>

                <label>Session Type: (required)</label><br>
                <select name="session_type" id="session_type" class="dropdown" required>
                    <option value="" disabled selected>Select an option</option>
                    <option value="15 Minute Free Consult">15 Minute Free Consult</option>
                    <option value="50 Minute Individual Session">50 Minute Individual Session</option>
                </select><br>

                <label>Message: (required)</label><br>
                <textarea name="message" rows="5" required>Hello, I am interested in booking a consult.  </textarea><br>

                <button class="send">Send</button>
            </form>
        </div>

    </div>
</section>

<?php if (!empty($statusMessage)): ?><br><br><br>
    <div class="form-message <?php echo $statusClass; ?>">
        <?php echo $statusMessage; ?>
    </div>
<?php endif; ?>

<footer>
  <div class="container">
    <div class="footer-margin">
          
    <p>Phone: <a href="tel:2269468745"> (226) 946-8745</a><br>
       Email: brendan.monroy.rpq@gmail.com<br>
       Location: Windsor, ON<br>
       Hours of Operation: 12pm-7pm</p>
    <img src="Images/Untitled-3.png" alt="Logo" class="logo">
    <small>If you are experiencing immediate risk of suicide, please contact emergency services or the 24/7 Suicide Crisis Helpline: 9-8-8 </small>
    <small>Website designed by Amber Howe</small>
</div>
  </div>
</footer>

</body>
</html>
