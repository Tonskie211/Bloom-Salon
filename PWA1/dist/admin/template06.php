<?php
require_once '../config/config.php';

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 1: Get and sanitize client data
    $firstname = trim($_POST['firstname'] ?? "");
    $lastname = trim($_POST['lastname'] ?? "");
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone'] ?? "");

    // Step 2: Get appointment data
    $date = $_POST['date'] ?? "";
    $time = $_POST['time'] ?? "";
    $services = $_POST['services'] ?? [];

    // Basic validation
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($date) || empty($time)) {
        $error_message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        try {
            // Step 3: Insert client data
            $clientSql = "INSERT INTO clients (first_name, last_name, email, phone_number) 
                          VALUES (:firstname, :lastname, :email, :phone)";
            $stmt = $pdo->prepare($clientSql);
            $stmt->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':phone' => $phone,
            ]);

            // Step 4: Get the last inserted client_id
            $client_id = $pdo->lastInsertId();

            // Step 5: Insert the appointment using the new client_id
            $appointmentSql = "INSERT INTO appointment (appointment_date, appointment_time, client_id) 
                        VALUES (:date, :time, :client_id)";
            $stmt = $pdo->prepare($appointmentSql);
            $stmt->execute([
                ':date' => $date,
                ':time' => $time,
                ':client_id' => $client_id
            ]);

            // Step 6: Get the last inserted appointment_id
            $appointment_id = $pdo->lastInsertId();

            // Step 7: Insert selected services into appointment_services table
            if (!empty($services)) {
                $serviceSql = "INSERT INTO appointment_services (appointment_id, service_id) VALUES (:appointment_id, :service_id)";
                $stmt = $pdo->prepare($serviceSql);
                
                foreach ($services as $service_id) {
                    if (is_numeric($service_id)) {
                        $stmt->execute([
                            ':appointment_id' => $appointment_id,
                            ':service_id' => $service_id
                        ]);
                    }
                }
            }

            $success_message = "Appointment booked successfully!";
            
        } catch (Exception $e) {
            $error_message = "Error booking appointment: " . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
  <title>template03</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="." />
    <meta name="keywords" content="." />
    <meta name="author" content="Sniper 2025" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/fonts/material.css" />
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
</head>
<style>
.book_main{
    background-color: #0c0039;
    width: 1000px;
    height: auto;
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    padding: 40px 0;
    margin: 20px 0;
    border-radius: 10px;
}

.booking_text{
    font-family: 'Work Sans', sans-serif;
    color: white;
    font-size: 40pt;
    text-align: center;
    margin-bottom: 40px;
}

.form-row {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.input-field {
    width: 320px;
    color: white;
    height: 45px;
    background-color: #0c0039;
    border: 2px solid white;
    border-radius: 5px;
    padding: 0 15px;
    font-size: 14px;
}

.input-field::placeholder {
    color: #ccc;
}

.input-field:focus {
    outline: none;
    border-color: #68689b;
}

/* Services Checkboxes Styles */
.services-section {
    width: 720px;
    margin: 30px auto;
}

.services-checkboxes {
    color: white;
    background-color: #0c0039;
    border: 2px solid white;
    padding: 20px;
    border-radius: 5px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    max-height: 300px;
    overflow-y: auto;
}

.service-option {
    display: flex;
    align-items: center;
    gap: 10px;
}

.service-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #68689b;
}

.service-label {
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 12pt;
    cursor: pointer;
}

.service-checkbox:checked + .service-label {
    color: #68689b;
    font-weight: bold;
}

.datetime-section {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 30px 0;
}

.datetime-field {
    width: 250px;
    color: white;
    height: 45px;
    background-color: #0c0039;
    border: 2px solid white;
    border-radius: 5px;
    padding: 0 15px;
    font-size: 14px;
}

.datetime-field:focus {
    outline: none;
    border-color: #68689b;
}

.submit_book{
    width: 200px;
    height: 50px;
    background-color: #68689b;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    display: block;
    margin: 40px auto;
    transition: all 0.3s ease;
}

.submit_book:hover{
    background-color: #e1e4f0;
    color: black;
    transform: translateY(-2px);
}

.preffered_date, .preffered_time {
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 15pt;
    text-align: center;
    margin: 10px 0;
}

/* Message Styles */
.message {
    padding: 15px;
    margin: 20px auto;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
    width: 80%;
}

.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Responsive Design */
@media (max-width: 768px) {
    .book_main {
        width: 95%;
        left: 2.5%;
        transform: none;
    }
    
    .form-row {
        flex-direction: column;
        align-items: center;
    }
    
    .input-field {
        width: 90%;
    }
    
    .services-section {
        width: 90%;
    }
    
    .services-checkboxes {
        grid-template-columns: 1fr;
    }
    
    .datetime-section {
        flex-direction: column;
        align-items: center;
    }
    
    .datetime-field {
        width: 90%;
    }
}

.datetime-field {
    position: relative;
    color: white;
}

.datetime-field::-webkit-datetime-edit-fields-wrapper {
    color: white;
}

.datetime-field::-webkit-datetime-edit-text {
    color: white;
    padding: 0 0.3em;
}

.datetime-field::-webkit-datetime-edit-month-field {
    color: white;
}

.datetime-field::-webkit-datetime-edit-day-field {
    color: white;
}

.datetime-field::-webkit-datetime-edit-year-field {
    color: white;
}

.datetime-field::-webkit-inner-spin-button {
    display: none;
}

.datetime-field::-webkit-calendar-picker-indicator {
    filter: invert(1);
    cursor: pointer;
}

/* For Firefox */
.datetime-field {
    color-scheme: dark;
}
</style>
<body>
  <!-- [ Pre-loader ] start -->
<div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
  <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
    <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
  <?php include '../includes/sidebar.php'; ?>
<!-- [ Sidebar Menu ] end -->
 <!-- [ Header Topbar ] start -->
  <?php include '../includes/header.php'; ?>
<!-- [ Header ] end -->

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="page-header-title">
            <h5 class="mb-0 font-medium">ADD APPOINTMENT</h5>
          </div>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Template 03</li>
          </ul>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="grid grid-cols-12 gap-x-6">
        <!-- [ sample-page ] start -->
        <div class="col-span-12">
          <div class="card">
            <div class="card-header">
              <h5>Client Appointment <span style="color: red; font-weight: bold;"></span></h5>
            </div>
            <div class="card-body">
              <!-- BOOKING FORM -->
<main class="book_main">
    <h1 class="booking_text">BOOKING</h1>

    <!-- Display Messages -->
    <?php if ($success_message): ?>
        <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <!-- Personal Information -->
        <div class="form-row">
            <input type="text" name="firstname" placeholder="First Name:" required class="input-field" 
                   value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>">
            
            <input type="text" name="lastname" placeholder="Last Name:" required class="input-field"
                   value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>">
        </div>

        <div class="form-row">
            <input type="email" name="email" placeholder="Email Address:" required class="input-field"
                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            
            <input type="tel" name="phone" placeholder="Phone Number" required class="input-field" 
                   pattern="\d{11}" maxlength="11" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
        </div>

        <!-- Services Section -->
        <div class="services-section">
            <h4 style="color: white; text-align: center; margin-bottom: 15px; font-family: 'Poppins', sans-serif;">
                Select Services:
            </h4>
            <div class="services-checkboxes">
                <div class="service-option">
                    <input type="checkbox" id="service1" name="services[]" value="1" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('1', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service1" class="service-label">REBOND WITH BOTOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service2" name="services[]" value="2" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('2', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service2" class="service-label">REBOND WITH REGULAR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service3" name="services[]" value="3" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('3', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service3" class="service-label">REBOND WITH BRAZILIAN</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service4" name="services[]" value="4" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('4', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service4" class="service-label">REBOND WITH COLOR</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service5" name="services[]" value="5" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('5', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service5" class="service-label">REBOND WITH COLOR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service6" name="services[]" value="6" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('6', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service6" class="service-label">COLORING</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service7" name="services[]" value="7" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('7', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service7" class="service-label">COLOR</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service8" name="services[]" value="8" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('8', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service8" class="service-label">COLOR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service9" name="services[]" value="9" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('9', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service9" class="service-label">HAIR BOTOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service10" name="services[]" value="10" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('10', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service10" class="service-label">HAIR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service11" name="services[]" value="11" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('11', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service11" class="service-label">HAIRCUT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service12" name="services[]" value="12" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('12', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service12" class="service-label">REGULAR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service13" name="services[]" value="13" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('13', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service13" class="service-label">HAIR BOTOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service14" name="services[]" value="14" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('14', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service14" class="service-label">HAIR BRAZILIAN</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service15" name="services[]" value="15" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('15', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service15" class="service-label">HAIR DETOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service16" name="services[]" value="16" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('16', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service16" class="service-label">MANICURE / PEDICURE</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service17" name="services[]" value="17" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('17', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service17" class="service-label">FOOTSPA</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service18" name="services[]" value="18" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('18', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service18" class="service-label">GEL POLISH</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service19" name="services[]" value="19" class="service-checkbox"
                           <?php echo (isset($_POST['services']) && in_array('19', $_POST['services'])) ? 'checked' : ''; ?>>
                    <label for="service19" class="service-label">PARAFFIN WAX</label>
                </div>
            </div>
        </div>

        <!-- Date and Time Section -->
        <div class="datetime-section">
            <div style="text-align: center;">
                <h4 class="preffered_date">Preferred Appointment Date</h4>
                <input type="date" name="date" required class="datetime-field" 
                       value="<?php echo htmlspecialchars($_POST['date'] ?? ''); ?>">
            </div>
            
            <div style="text-align: center;">
                <h4 class="preffered_time">Preferred Appointment Time</h4>
                <select class="datetime-field" name="time" required>
                    <option value="" disabled <?php echo empty($_POST['time']) ? 'selected' : ''; ?>>Time Preferred</option>
                    <option value="08:00:00" <?php echo ($_POST['time'] ?? '') === '08:00:00' ? 'selected' : ''; ?>>8:00 AM</option>
                    <option value="09:00:00" <?php echo ($_POST['time'] ?? '') === '09:00:00' ? 'selected' : ''; ?>>9:00 AM</option>
                    <option value="10:00:00" <?php echo ($_POST['time'] ?? '') === '10:00:00' ? 'selected' : ''; ?>>10:00 AM</option>
                    <option value="11:00:00" <?php echo ($_POST['time'] ?? '') === '11:00:00' ? 'selected' : ''; ?>>11:00 AM</option>
                    <option value="12:00:00" <?php echo ($_POST['time'] ?? '') === '12:00:00' ? 'selected' : ''; ?>>12:00 PM</option>
                    <option value="13:00:00" <?php echo ($_POST['time'] ?? '') === '13:00:00' ? 'selected' : ''; ?>>1:00 PM</option>
                    <option value="14:00:00" <?php echo ($_POST['time'] ?? '') === '14:00:00' ? 'selected' : ''; ?>>2:00 PM</option>
                    <option value="15:00:00" <?php echo ($_POST['time'] ?? '') === '15:00:00' ? 'selected' : ''; ?>>3:00 PM</option>
                    <option value="16:00:00" <?php echo ($_POST['time'] ?? '') === '16:00:00' ? 'selected' : ''; ?>>4:00 PM</option>
                </select>
            </div>
        </div>

        <button type="submit" name="submit" class="submit_book">BOOK</button>
    </form>
</main>
    
            </div>
          </div>

        </div>
        <!-- [ sample-page ] end -->
      </div>
      <!-- [ Main Content ] end -->
    </div>
  </div>
  <!-- [ Main Content ] end -->

 <!-- Required Js -->
<script src="../assets/js/plugins/simplebar.min.js"></script>
<script src="../assets/js/plugins/popper.min.js"></script>
<script src="../assets/js/icon/custom-icon.js"></script>
<script src="../assets/js/plugins/feather.min.js"></script>
<script src="../assets/js/component.js"></script>
<script src="../assets/js/theme.js"></script>
<script src="../assets/js/script.js"></script>

<?php include '../includes/footer.php'; ?>
</body>
</html>