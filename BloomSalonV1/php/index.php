<?php
include 'config.php'; // Ensure $pdo is available

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 1: Get and sanitize client data
    $firstname = $_POST['firstname'] ?? "";
    $lastname = $_POST['lastname'] ?? "";
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = $_POST['phone'] ?? "";

    // Step 2: Get appointment data
    $date = $_POST['date'] ?? "";
    $time = $_POST['time'] ?? "";

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
        $Sql = "INSERT INTO appointment (appointment_date, appointment_time, client_id) 
                    VALUES (:date, :time, :client_id)";
        $stmt = $pdo->prepare($Sql);
        $stmt->execute([
            ':date' => $date,
            ':time' => $time,
            ':client_id' => $client_id
        ]);
    //Step 6: Fetch all the Services
    $stmt = $pdo->query("SELECT service_id, service_name FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);


    } 
    catch (Exception $e) {
        echo " Error: " . $e->getMessage();
    }
}

// Include the HTML form (update the path as needed)
include('C:\xampp\htdocs\BloomSalonV1\pages\index.html');

?>





