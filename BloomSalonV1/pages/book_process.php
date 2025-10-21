<?php
ob_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $redirect_url = "appointment.php?success=1";
    
    try {
        // Get form data
        $firstname = trim($_POST['firstname'] ?? "");
        $lastname = trim($_POST['lastname'] ?? "");
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST['phone'] ?? "");
        $date = $_POST['date'] ?? "";
        $time = $_POST['time'] ?? "";
        $services = $_POST['services'] ?? [];

        // Validate required fields
        if (empty($firstname) || empty($lastname) || empty($email) || empty($date) || empty($time)) {
            throw new Exception("All required fields must be filled.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Please enter a valid email address.");
        }

        // Check if at least one service is selected
        if (empty($services)) {
            throw new Exception("Please select at least one service.");
        }

        // Check if client already exists
        $checkClientSql = "SELECT client_id FROM clients WHERE email = :email";
        $stmt = $pdo->prepare($checkClientSql);
        $stmt->execute([':email' => $email]);
        $existingClient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingClient) {
            // Use existing client ID
            $client_id = $existingClient['client_id'];
            
            // Update client information (in case phone number changed)
            $updateClientSql = "UPDATE clients SET first_name = :firstname, last_name = :lastname, phone_number = :phone WHERE client_id = :client_id";
            $stmt = $pdo->prepare($updateClientSql);
            $stmt->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':phone' => $phone,
                ':client_id' => $client_id
            ]);
        } else {
            // Insert new client data
            $clientSql = "INSERT INTO clients (first_name, last_name, email, phone_number) 
                          VALUES (:firstname, :lastname, :email, :phone)";
            $stmt = $pdo->prepare($clientSql);
            $stmt->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':phone' => $phone,
            ]);
            $client_id = $pdo->lastInsertId();
        }

        // Insert the appointment using the client_id
        $appointmentSql = "INSERT INTO appointment (appointment_date, appointment_time, client_id) 
                    VALUES (:date, :time, :client_id)";
        $stmt = $pdo->prepare($appointmentSql);
        $stmt->execute([
            ':date' => $date,
            ':time' => $time,
            ':client_id' => $client_id
        ]);

        $appointment_id = $pdo->lastInsertId();

        // Insert selected services into appointment_services table
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

        // Generate the display appointment ID (AID + appointment_id + 100)
        $appointment_id_display = "AID" . ($appointment_id + 100);
        
        // Update redirect URL to include appointment ID
        $redirect_url = "appointment.php?success=1&appointment_id=" . urlencode($appointment_id_display);

    } catch (Exception $e) {
        $redirect_url = "book.php?error=" . urlencode($e->getMessage());
    }

    // Final redirect
    ob_end_clean();
    header("Location: " . $redirect_url);
    exit();
} else {
    ob_end_clean();
    header("Location: book.php");
    exit();
}
?>