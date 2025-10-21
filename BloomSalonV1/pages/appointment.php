<?php
session_start();
include 'config.php';

// Store appointment ID in session after booking (without alert)
if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_GET['appointment_id'])) {
    $_SESSION['last_appointment_id'] = $_GET['appointment_id'];
    // Removed the JavaScript alert from here
}

// Initialize variables
$appointment_details = null;
$error = '';

// Handle form submission to check appointment status
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['check_status'])) {
    $appointment_id_input = trim($_POST['appointment_id'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');

    if (empty($appointment_id_input) || empty($phone_number)) {
        $error = "Please enter both Appointment ID and Phone Number";
    } else {
        try {
            // Remove 'AID' prefix if present and convert to numeric ID
            $appointment_id_numeric = str_replace('AID', '', $appointment_id_input);
            $appointment_id_numeric = intval($appointment_id_numeric) - 100;

            // Query to get appointment details
            $sql = "SELECT aav.*, a.appointment_id as numeric_id 
                    FROM all_appointment_view aav 
                    JOIN appointment a ON aav.appointment_id = CONCAT('AID', a.appointment_id + 100)
                    WHERE a.appointment_id = :appointment_id 
                    AND aav.phone_number = :phone_number";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':appointment_id' => $appointment_id_numeric,
                ':phone_number' => $phone_number
            ]);
            
            $appointment_details = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$appointment_details) {
                $error = "No appointment found with the provided details. Please check your Appointment ID and Phone Number.";
            }

        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Status</title>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
   <div class="navbar-center">
      <img src="../assets/images/SALON LOGO.png" alt="logo" class="logo">
      <div class="nav-links">
        <p class="tagline">Where Beauty Blossoms</p>
            <a href="index.php" class="home">HOME</a>
            <a href="about.php" class="about">ABOUT</a>
            <a href="services.php" class="services">SERVICES</a>
            <a href="contact.php" class="contact">CONTACT</a>
            <a href="appointment.php" class="appointment">APPOINTMENT</a>
            <a href="book.php"><button type="button" class="book_now1">BOOK NOW</button></a>
      </div>
   </div>
</nav>

<button class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">↑</button>

<main class="appointment_main">
    <img src="../assets/images/salonpic.JPG" class="apt_logo">
    
    <div class="appointment-container">
        <!-- Success Message with Appointment ID -->
        <?php if (isset($_SESSION['last_appointment_id']) && !$appointment_details): ?>
         
              
                    <span class="id-label">Your Appointment ID:</span>
                    <span class="id-value"><?php echo htmlspecialchars($_SESSION['last_appointment_id']); ?></span>
          
            <?php unset($_SESSION['last_appointment_id']); ?>
        <?php endif; ?>

        <?php if ($appointment_details): ?>
            <!-- Display appointment details when found -->
            <div class="appointment-details">
                <h2 class="appointment_id_text">Appointment Details</h2>
                
                
                    <span class="id-label">Appointment ID:</span>
                    <span class="id-value"><?php echo htmlspecialchars($appointment_details['appointment_id']); ?></span>
                
                
                <div class="details-grid">
                    <div class="detail-row">
                        <span class="label">Client Name:</span>
                        <span class="value"><?php echo htmlspecialchars($appointment_details['client_name']); ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Email:</span>
                        <span class="value"><?php echo htmlspecialchars($appointment_details['email']); ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Phone:</span>
                        <span class="value"><?php echo htmlspecialchars($appointment_details['phone_number']); ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Date:</span>
                        <span class="value"><?php echo htmlspecialchars($appointment_details['appointment_date']); ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Time:</span>
                        <span class="value"><?php echo htmlspecialchars($appointment_details['appointment_time']); ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Services:</span>
                        <span class="value"><?php echo htmlspecialchars($appointment_details['services_name']); ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Total Price:</span>
                        <span class="value">₱<?php echo number_format($appointment_details['total_price'], 2); ?></span>
                    </div>
                </div>
                
                <div class="status-container">
                    <h1 class="status_text">STATUS: 
                        <span class="status-<?php echo strtolower($appointment_details['status']); ?>">
                            <?php echo strtoupper($appointment_details['status']); ?>
                        </span>
                    </h1>
                    
                    <?php if ($appointment_details['status'] === 'pending'): ?>
                        <p class="status-note">Your appointment is waiting for confirmation. Please check back later.</p>
                    <?php elseif ($appointment_details['status'] === 'accepted'): ?>
                        <p class="status-note">Your appointment has been confirmed! See you soon!</p>
                        
                    <?php else: ?>
                        <p class="status-note">Your appointment was rejected. Invalid contact.</p>
                    <?php endif; ?>
                </div>
                
                <form method="POST" class="check-another-form">
                    <button type="submit" name="check_another" class="apt_submit">CHECK ANOTHER APPOINTMENT</button>
                </form>
            </div>
            
        <?php else: ?>
            <!-- Display search form when no appointment details are shown -->
            <h2 class="appointment_id_text">CHECK YOUR APPOINTMENT STATUS</h2>
            <p class="appointment_note_text">Enter your Appointment ID and Phone Number to check your status</p>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" class="status-form">
                <div class="input-group">
                    <input type="text" name="appointment_id" placeholder="Appointment ID (e.g., AID100)" class="input_id" 
                           value="<?php echo isset($_POST['appointment_id']) ? htmlspecialchars($_POST['appointment_id']) : ''; ?>" required>
                   
                </div>
                
                <div class="input-group">
                    <input type="text" name="phone_number" placeholder="Phone Number (11 digits)" required class="input_number" 
                           pattern="\d{11}" maxlength="11" 
                           value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>">
                  
                </div>
                
                <button type="submit" name="check_status" class="apt_submit">ENTER</button>
            </form>
            
       
        <?php endif; ?>
    </div>
</main>

<footer class="appointment_footer">
    <img src="../assets/images/LOGO2.jpg" class="logo2">
    <p class="footer_address">183 Purok 2 Lucao District,<br> Dagupan City Pangasinan</p>
    <p class="footer_line1">_____________________________________________________________</p>
    <p class="footer_line2">_____________________________________________________________</p>
    <p class="footer_line3">|</p>    
    <p class="footer_email">beautyblossom@gmail.com</p>
    <p class="footer_number">+63 945 250 8060</p>
    <p class="nocopyright">Copyright © 2025 PHINMA University of Pangasinan. All rights reserved.</p>
</footer>

<script>
function generateReceipt() {
    alert('PDF receipt generation feature would be implemented here!');
    // You can implement PDF generation using:
    // window.location.href = 'generate_receipt.php?appointment_id=<?php echo $appointment_details['appointment_id'] ?? ''; ?>';
}

// Copy appointment ID to clipboard
function copyAppointmentId() {
    const appointmentId = '<?php echo $appointment_details['appointment_id'] ?? ''; ?>';
    navigator.clipboard.writeText(appointmentId).then(function() {
        alert('Appointment ID copied to clipboard: ' + appointmentId);
    }, function(err) {
        alert('Could not copy text: ', err);
    });
}
</script>

<style>
*{
    padding: 0;
    margin: 0;
}

body{
    overflow-x: hidden;
}

body::-webkit-scrollbar {
  display: none; 
}

html,body{
    height: 100%;
}

.navbar {
  background: white;
  width: 100%;
  height: 98px;
  color: white;
  padding: 1rem 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: opacity 0.5s ease;
  opacity: 1;
  position: fixed;
  z-index: 1000;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.navbar-center {
  display: flex;
  align-items: center;
  gap: 2rem;
}

.logo{
    width:100px ;
    height:100px;
    position:relative ;
    top: 0px;
    right: 360px;
}

.tagline{
    font-family: 'Poppins', sans-serif;
    color: black;
    font-size: 25pt;
    position: relative;
    left: -50%;
    bottom: -30px;
}

/*** NAVIGATIONS ***/

.home, .about, .services, .contact, .appointment {
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
    font-size: 13pt;
    color: black;
    position: relative;
    padding: 15px;
    background-color: white;
    transition: 0.3s;
}

.home{ left: 90px; bottom: 15px; }
.about{ left: 105px; bottom: 15px; }
.services{ left: 120px; bottom: 15px; }
.contact{ left: 135px; bottom: 15px; }
.appointment{ left: 150px; bottom: 15px; }

.home:hover, .about:hover, .services:hover, .contact:hover, .appointment:hover {
    background-color: #e1e4f0;
}

.home::after, .about::after, .services::after, .contact::after, .appointment::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    height: 2px;
    width: 0;
    background-color: black;
    transition: width 0.3s;
}

.home:hover::after, .about:hover::after, .services:hover::after, .contact:hover::after, .appointment:hover::after {
    width: 100%;
}

.book_now1{
    font-family: 'Work Sans', sans-serif;
    background-color: #000080;
    width: 150px;
    height: 60px;
    position: absolute;
    color: white;
    position: relative;
    left: 37%;
    bottom:20px;
    border: none;
    cursor: pointer;
}

button:hover{
    background-color:#e1e4f0 ;
    color: black;
}

/***** END OF HEADER ***/

/**** APPOINTMENT MAIN ***/

.appointment_main{
    background-color:#0c0039;
    width: 1200px;
    height: auto;
    min-height: 680px;
    position: relative;
    left:170px;
    top: 100px;
    padding: 40px 0;
    margin-bottom: 100px;
}

.apt_logo{
    width: 110px;
    height: 110px;
    border-radius: 20px;
    position: relative;
    top: 0px;
    left: 535px;
    margin-bottom: 20px;
}

.appointment-container {
    text-align: center;
    color: white;
    padding: 0 20px;
}

.appointment_id_text{
    font-family: 'Work Sans', sans-serif;
    color: white;
    font-size: 30pt;
    margin-bottom: 10px;
}

.appointment_note_text{
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 17pt;
    margin-bottom: 30px;
}

/* Success Message Styles */
.success-message {
    background: rgba(76, 175, 80, 0.2);
    border: 2px solid #4CAF50;
    border-radius: 15px;
    padding: 30px;
    margin: 20px auto;
    max-width: 600px;
}

.success-message h2 {
    font-family: 'Work Sans', sans-serif;
    color: #4CAF50;
    margin-bottom: 20px;
    font-size: 24px;
}

.appointment-id-display {
    background: rgba(255,255,255,0.1);
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border: 2px dashed #4CAF50;
}

.appointment-id-display.large {
    padding: 25px;
    margin: 30px 0;
}

.id-label {
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    color: #ccc;
    display: block;
    margin-bottom: 10px;
}

.id-value {
    font-family: 'Work Sans', sans-serif;
    font-size: 32px;
    color:white;
    font-weight: bold;
    letter-spacing: 2px;
}

.success-note {
    font-family: 'Poppins', sans-serif;
    color: #ccc;
    margin: 10px 0;
    font-size: 16px;
}

/* Status Form Styles */
.status-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 25px;
    margin: 30px 0;
}

.input-group {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.input_id, .input_number{
    width: 350px;
    color: white;
    height: 40px;
    background-color:#0c0039;
    border: 2px solid white;
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    border-radius: 5px;
}

.input_id::placeholder, .input_number::placeholder {
    color: #ccc;
}

.input-hint {
    font-family: 'Poppins', sans-serif;
    color: #ccc;
    font-size: 12px;
    margin-top: 5px;
}

.apt_submit, .apt_receipt{
    background-color: #68689b;
    color: white;
    width: 250px;
    height: 50px;
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    margin: 10px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.apt_submit:hover, .apt_receipt:hover {
    background-color: #7a7aaf;
    transform: translateY(-2px);
}

/* Appointment Details Styles */
.appointment-details {
    background: rgba(255,255,255,0.1);
    padding: 30px;
    border-radius: 15px;
    margin: 20px auto;
    max-width: 800px;
    text-align: left;
}

.details-grid {
    margin: 20px 0;
}

.detail-row {
    display: flex;
    margin-bottom: 15px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.detail-row .label {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    width: 150px;
    color: #ccc;
    font-size: 16px;
}

.detail-row .value {
    font-family: 'Poppins', sans-serif;
    flex: 1;
    color: white;
    font-size: 16px;
}

.status-container {
    text-align: center;
    margin: 30px 0;
    padding: 20px;
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
}

.status_text{
    font-family: 'Work Sans', sans-serif;
    color: white;
    font-size: 28pt;
    margin: 20px 0;
}

.status-pending, .status-accepted, .status-rejected {
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: bold;
    margin-left: 10px;
}

.status-pending {
    background-color:;
    color: white;
}

.status-accepted {
    background-color: #4CAF50;
    color: white;
}

.status-rejected {
    background-color: #f44336;
    color: white;
}

.status-note {
    font-family: 'Poppins', sans-serif;
    color: #ccc;
    font-size: 16px;
    margin: 15px 0;
}

.error-message {
    background-color: #f44336;
    color: white;
    padding: 15px;
    border-radius: 5px;
    margin: 20px auto;
    max-width: 400px;
    font-family: 'Poppins', sans-serif;
}

.help-section {
    background: rgba(255,255,255,0.05);
    padding: 20px;
    border-radius: 10px;
    margin: 30px auto;
    max-width: 500px;
}

.help-section h3 {
    font-family: 'Poppins', sans-serif;
    color: white;
    margin-bottom: 15px;
}

.help-section p {
    font-family: 'Poppins', sans-serif;
    color: #ccc;
    margin: 8px 0;
}

.check-another-form {
    text-align: center;
    margin-top: 30px;
}

/**** APPOINTMENT FOOTER ***/

.appointment_footer{
    background-color: #7668a3;
    width: auto;
    height: 400px;
    position: relative;
    margin-top: 100px;
}

.logo2{
    width: 120px;
    height: 120px;
    position: relative;
    left: 150px;
    top: 50px;
}

.footer_address{
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 16pt;
    position: relative;
    left: 165px;
    top: 50px;
}

.footer_line1, .footer_line2{
    color: white;
    font-size:30pt;
    position: relative;
    left: 168px;
}

.footer_line1 { top: 50px; }
.footer_line2 { top: 60px; }

.footer_email{
    font-family: 'Poppins', sans-serif;
    font-size: 15pt;
    color: white;
    position: relative;
    left: 430px;
    bottom: 5px;
}

.footer_line3{
    color: white;
    font-size: 15pt;
    position: relative;
    left: 280pt;
    top: 15pt;
}

.footer_number{
    font-family: 'Poppins', sans-serif;
    font-size: 15pt;
    color: white;
    position: relative;
    left: 180px;
    bottom:  35px;
}

.nocopyright{
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 15pt;
    position: relative;
    left: 480px;
    top: 0px;
}

/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 50px;
    right: 35px;
    width: 50px;
    height: 50px;
    background-color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: all 0.3s ease;
    z-index: 2000;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}

.back-to-top:hover {
    background-color: #68689b;
    transform: translateY(-5px);
    color: white;
}
</style>
</body>
</html>