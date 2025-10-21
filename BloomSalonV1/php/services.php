
<?php
include 'config.php';


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $date = $_POST['date'] ?? null;
  $time = $_POST['time'] ?? null;

   

   $sql = "INSERT INTO appointment (appointment_date,appointment_time) 
                VALUES (:date, :time,)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
          ':date' => $date,
          ':time' => $time,


        ]);

    }

    include ('C:\xampp\htdocs\BLOOMSALONV1\pages\book.html');

  

?>
  









include 'config.php';

// 1. Insert into TICKET table first
//$sql = "INSERT INTO ticket (employee_id, lab_room, status, priority) 
  //      VALUES ('7', 'ITS 201', 'Pending', 'normal')";
//$connection->query($sql);
//$ticket_id = $connection->insert_id; // Get the new ticket ID

// 2. Insert into REQUEST table for each selected concern
if (isset($_POST['submit'])) {
    foreach ($_POST['submit'] as $services_id) {
        $sql = "INSERT INTO appointment (appointment_id) 
                VALUES ( '$services_id')";
        $connection->query($sql);
     } 
  
    include ('C:\xampp\htdocs\PROJECT\book2.html');
}