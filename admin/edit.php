<?php
require_once '../config/config.php';

$success_message = '';
$error_message = '';

// Pre-fill form if client_id is provided via GET
$client_data = null;
$client_id = null;
$original_client_id = null;

if (isset($_GET['id'])) {
    $original_client_id = trim($_GET['id']);
    
    // Extract numeric part from CID format (e.g., "CID101" becomes "1")
    if (preg_match('/^CID(\d+)$/', $original_client_id, $matches)) {
        $client_id = $matches[1] - 100; // Convert back to original ID
    } else {
        $client_id = $original_client_id; // Use as-is if not in CID format
    }
    
    if (!empty($client_id) && is_numeric($client_id)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM clients WHERE client_id = ?");
            $stmt->execute([$client_id]);
            $client_data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$client_data) {
                $error_message = "No client found with ID: " . htmlspecialchars($original_client_id);
            }
        } catch (PDOException $e) {
            $error_message = "Error fetching client data: " . $e->getMessage();
        }
    } else {
        $error_message = "Invalid client ID format: " . htmlspecialchars($original_client_id);
    }
} else {
    $error_message = "No client ID provided in URL. Please access this page from the clients list.";
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change'])) {
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];

    // Basic validation
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } elseif (!preg_match('/^\d{11}$/', $phone)) {
        $error_message = "Phone number must be exactly 11 digits.";
    } else {
        try {
            // Get client_id from the original GET parameter or hidden field
            $update_client_id = null;
            
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $original_id = trim($_GET['id']);
                if (preg_match('/^CID(\d+)$/', $original_id, $matches)) {
                    $update_client_id = $matches[1] - 100;
                } else {
                    $update_client_id = $original_id;
                }
            } elseif (isset($_POST['client_id']) && !empty($_POST['client_id'])) {
                $original_id = trim($_POST['client_id']);
                if (preg_match('/^CID(\d+)$/', $original_id, $matches)) {
                    $update_client_id = $matches[1] - 100;
                } else {
                    $update_client_id = $original_id;
                }
            }
            
            if ($update_client_id && is_numeric($update_client_id)) {
                $query = "UPDATE clients 
                          SET first_name = :firstname, 
                              last_name = :lastname, 
                              email = :email, 
                              phone_number = :phone 
                          WHERE client_id = :client_id";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':client_id', $update_client_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $success_message = "Client updated successfully!";
                        // Refresh client data
                        $stmt = $pdo->prepare("SELECT * FROM clients WHERE client_id = ?");
                        $stmt->execute([$update_client_id]);
                        $client_data = $stmt->fetch(PDO::FETCH_ASSOC);
                    } else {
                        $error_message = "No changes were made to the client information.";
                    }
                } else {
                    $error_message = "Failed to update client.";
                }
            } else {
                $error_message = "Valid client ID is required for updating.";
            }

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error_message = "Email address already exists. Please use a different email.";
            } else {
                $error_message = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>

<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
  <title>Edit Client</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Edit Client Information" />
    <meta name="keywords" content="client, edit, management" />
    <meta name="author" content="Sniper 2025" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/fonts/material.css" />
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .required-field::after {
            content: " *";
            color: #ef4444;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }
        .alert-success {
            background-color: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
        }
        .alert-error {
            background-color: #fee2e2;
            border-color: #fecaca;
            color: #dc2626;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }
        .btn-warning:hover {
            background-color: #d97706;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .input-hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 0.25rem;
        }
        .client-info {
            background-color: #f8fafc;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #3b82f6;
        }
        .debug-info {
            background-color: #f3f4f6;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            display: block;
        }

        .back {
    display: inline-flex;
    align-items: center;
    position:relative;
    right: 250px;
    gap: 8px;
    padding: 8px 16px;
    background-color: #d1fae5;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    color: #374151;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.back:hover {
    background-color: #f1f5f9;
    border-color: #cbd5e1;
}

.back i {
    font-size: 25px;
}
    </style>
</head>
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
            <h5 class="mb-0 font-medium">Client Management</h5>
          </div>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="clients.php">Clients</a></li>
            <li class="breadcrumb-item" aria-current="page">Edit Client</li>
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
              <h5>Edit Client Information</h5>
            </div>
            <div class="card-body">
              <div class="form-container">
                <!-- Debug Information -->
               
      <a href="template03.php" class="back">
    <i class="feather icon-arrow-left"></i>Back</a>

                <!-- Success/Error Messages -->
                <?php if ($success_message): ?>
                  <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?>
                  </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                  <div class="alert alert-error">
                    <?php echo htmlspecialchars($error_message); ?>
                  </div>
                <?php endif; ?>

                <?php if ($client_data): ?>
                 

                  <form method="post" class="space-y-4">
                    <!-- Hidden field to preserve client_id on form submission -->
                    <input type="hidden" name="client_id" value="CID<?php echo htmlspecialchars($client_data['client_id'] + 100); ?>">
                    
                    <div class="form-group">
                      <label for="firstname" class="form-label required-field">First Name</label>
                      <input type="text" 
                             name="firstname" 
                             class="form-control" 
                             id="firstname" 
                             placeholder="Enter first name" 
                             value="<?php echo htmlspecialchars($client_data['first_name']); ?>" 
                             required />
                    </div>

                    <div class="form-group">
                      <label for="lastname" class="form-label required-field">Last Name</label>
                      <input type="text" 
                             name="lastname" 
                             class="form-control" 
                             id="lastname" 
                             placeholder="Enter last name" 
                             value="<?php echo htmlspecialchars($client_data['last_name']); ?>" 
                             required />
                    </div>

                    <div class="form-group">
                      <label for="email" class="form-label required-field">Email Address</label>
                      <input type="email" 
                             name="email" 
                             class="form-control" 
                             id="email" 
                             placeholder="Enter email address" 
                             value="<?php echo htmlspecialchars($client_data['email']); ?>" 
                             required />
                    </div>

                    <div class="form-group">
                      <label for="phone" class="form-label required-field">Phone Number</label>
                      <input type="tel" 
                             name="phone" 
                             class="form-control" 
                             id="phone" 
                             placeholder="Enter 11-digit phone number" 
                             value="<?php echo htmlspecialchars($client_data['phone_number']); ?>" 
                             pattern="\d{11}" 
                             maxlength="11" 
                             required />
                      <div class="input-hint">Must be exactly 11 digits</div>
                    </div>

                    <div class="btn-group">
                      <button type="submit" class="btn btn-primary" name="change">
                        Update Client
                      </button>
                      <a href="template03.php" class="btn btn-warning">
                        Back to Clients
                      </a>
                    </div>
                  </form>
                <?php elseif ($error_message): ?>
                  <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">Unable to load client information.</p>
                    <p class="text-sm text-red-600 mb-4"><?php echo htmlspecialchars($error_message); ?></p>
                    <a href="template03.php" class="btn btn-primary">Back to Clients</a>
                  </div>
                <?php endif; ?>
              </div>
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