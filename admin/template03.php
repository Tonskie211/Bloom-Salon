<?php
require_once '../config/config.php';

// Handle soft delete if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $client_id = $_POST['client_id'];
    
    // Extract numeric part from CID format
    if (preg_match('/^CID(\d+)$/', $client_id, $matches)) {
        $numeric_id = $matches[1] - 100;
        
        try {
            // Check if deleted_at column exists, if not, create it
            $checkColumn = $pdo->query("SHOW COLUMNS FROM clients LIKE 'deleted_at'");
            if ($checkColumn->rowCount() == 0) {
                $pdo->query("ALTER TABLE clients ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
            }
            
            // Soft delete by setting deleted_at timestamp
            $stmt = $pdo->prepare("UPDATE clients SET deleted_at = CURRENT_TIMESTAMP WHERE client_id = ?");
            $stmt->execute([$numeric_id]);
            
            if ($stmt->rowCount() > 0) {
                $success_message = "Client deleted successfully!";
            } else {
                $error_message = "Client not found or already deleted.";
            }
        } catch (PDOException $e) {
            $error_message = "Error deleting client: " . $e->getMessage();
        }
    } else {
        $error_message = "Invalid client ID format.";
    }
    // NO REDIRECT - stay on same page
}
?>

<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
  <title>Client Management</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Client Management System" />
    <meta name="keywords" content="client, management" />
    <meta name="author" content="Sniper 2025" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/fonts/material.css" />
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <style>
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        } 
        th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e2e8f0;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        tr:hover {
            background-color: #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }

        .edit-btn, .delete-btn {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .edit-btn {
            background-color: #10b981;
            color: white;
        }

        .edit-btn:hover {
            background-color: #059669;
        }

        .delete-btn {
            background-color: #ef4444;
            color: white;
        }

        .delete-btn:hover {
            background-color: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .client-id {
            font-weight: 600;
            color: #3b82f6;
        }

        .client-name {
            font-weight: 500;
            color: #1e293b;
        }

        .email-cell {
            word-break: break-word;
            max-width: 200px;
        }

        .phone-cell {
            font-family: 'Courier New', monospace;
            font-weight: 500;
        }

        /* Ensure actions column is properly sized */
        th:last-child,
        td:last-child {
            width: 140px;
            text-align: center;
        }

        /* Alert messages */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin: 16px;
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
            <li class="breadcrumb-item" aria-current="page">Clients</li>
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
              <h5 class="flex items-center gap-2">
                <i class="feather icon-users text-primary-500"></i>
                Salon Clients
                <span class="badge bg-primary-100 text-primary-800 text-sm px-2 py-1 rounded-full">
                  <?php
                    try {
                      // Check if deleted_at column exists
                      $checkColumn = $pdo->query("SHOW COLUMNS FROM clients LIKE 'deleted_at'");
                      $columnExists = $checkColumn->rowCount() > 0;
                      
                      if ($columnExists) {
                        // Count only non-deleted clients
                        $countStmt = $pdo->query("SELECT COUNT(*) as total FROM clients WHERE deleted_at IS NULL");
                      } else {
                        // Count all clients if no soft delete column
                        $countStmt = $pdo->query("SELECT COUNT(*) as total FROM clients");
                      }
                      $count = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
                      echo $count;
                    } catch (PDOException $e) {
                      echo "0";
                    }
                  ?>
                </span>
              </h5>
            </div>
            <div class="card-body p-0">
              <!-- Success/Error Messages -->
              <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                  <?php echo $success_message; ?>
                </div>
              <?php endif; ?>

              <?php if (isset($error_message)): ?>
                <div class="alert alert-error">
                  <?php echo $error_message; ?>
                </div>
              <?php endif; ?>

              <div class="table-container">
                <table>
                  <thead>
                    <tr>
                      <th>Client ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    try {
                      // Check if deleted_at column exists
                      $checkColumn = $pdo->query("SHOW COLUMNS FROM clients LIKE 'deleted_at'");
                      $columnExists = $checkColumn->rowCount() > 0;

                      if ($columnExists) {
                        // Query to get formatted client data with soft delete check
                        $query = "
                          SELECT 
                            CONCAT('CID', c.client_id + 100) AS client_id,
                            CONCAT(c.first_name, ' ', c.last_name) AS client_name,
                            c.email AS email,
                            c.phone_number AS phone_number
                          FROM clients c
                          WHERE c.deleted_at IS NULL
                          ORDER BY c.client_id ASC
                        ";
                        $stmt = $pdo->query($query);
                      } else {
                        // Original query if no soft delete column
                        $stmt = $pdo->query("SELECT * FROM client_view");
                      }

                      $rowCount = 0;
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $rowCount++;
                        echo "<tr>
                                <td class='client-id'>{$row['client_id']}</td>
                                <td class='client-name'>{$row['client_name']}</td>
                                <td class='email-cell'>{$row['email']}</td>
                                <td class='phone-cell'>{$row['phone_number']}</td>
                                <td>
                                  <div class='action-buttons'>
                                    <a href='edit.php?id={$row['client_id']}' class='edit-btn'>
                                      Edit
                                    </a>
                                    <form method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this client? This action can be undone.\");'>
                                      <input type='hidden' name='client_id' value='{$row['client_id']}'>
                                      <button type='submit' class='delete-btn' name='delete'>
                                        Delete
                                      </button>
                                    </form>
                                  </div>
                                </td>
                              </tr>";
                      }
                      
                      if ($rowCount === 0) {
                        echo "<tr>
                                <td colspan='5' class='empty-state'>
                                  <i class='feather icon-users'></i>
                                  <p>No clients found in the system.</p>
                                  <small class='text-muted'>Add your first client to get started.</small>
                                </td>
                              </tr>";
                      }

                    } catch (PDOException $e) {
                      echo "<tr>
                              <td colspan='5' class='empty-state'>
                                <i class='feather icon-alert-triangle text-danger-500'></i>
                                <p>Error loading clients</p>
                                <small class='text-muted'>" . htmlspecialchars($e->getMessage()) . "</small>
                              </td>
                            </tr>";
                    }
                    ?>
                  </tbody>
                </table>
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