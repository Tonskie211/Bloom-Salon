<?php
require_once '../config/config.php';

/**
 * Ensure the deleted_at column exists in the clients table
 */
function ensureSoftDeleteColumnExists() {
    global $pdo;
    
    try {
        $checkColumn = $pdo->query("SHOW COLUMNS FROM clients LIKE 'deleted_at'");
        if ($checkColumn->rowCount() === 0) {
            // Column doesn't exist, so create it
            $pdo->exec("ALTER TABLE clients ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
        }
    } catch (PDOException $e) {
        throw new Exception("Could not setup soft delete functionality: " . $e->getMessage());
    }
}

// Main execution
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle both delete and restore actions
    if (isset($_POST['client_id']) && isset($_POST['action'])) {
        $client_id = $_POST['client_id'];
        $action = $_POST['action'];

        try {
            ensureSoftDeleteColumnExists();
            
            if ($action === 'delete') {
                // Soft delete
                $query = "UPDATE clients SET deleted_at = NOW() WHERE client_id = :client_id";
                $message = "Client moved to trash successfully.";
            } elseif ($action === 'restore') {
                // Restore client
                $query = "UPDATE clients SET deleted_at = NULL WHERE client_id = :client_id";
                $message = "Client restored successfully.";
            } elseif ($action === 'permanent_delete') {
                // Permanent delete (use with caution)
                $query = "DELETE FROM clients WHERE client_id = :client_id";
                $message = "Client permanently deleted.";
            } else {
                throw new Exception("Invalid action specified.");
            }

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: clients.php?success=" . urlencode($message));
            } else {
                header("Location: clients.php?error=Failed to process request.");
            }
            exit();

        } catch (PDOException $e) {
            header("Location: clients.php?error=" . urlencode("Database error: " . $e->getMessage()));
            exit();
        } catch (Exception $e) {
            header("Location: clients.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        header("Location: clients.php?error=Invalid request parameters.");
        exit();
    }
} else {
    header("Location: clients.php?error=Invalid request method.");
    exit();
}
?>