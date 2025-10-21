<?php
require_once '../config/config.php';

// Handle AJAX actions if this is a POST request - MUST BE AT THE TOP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id']) && isset($_POST['action'])) {
    header('Content-Type: application/json');
    ob_clean();
    
    $appointment_id = filter_var($_POST['appointment_id'], FILTER_VALIDATE_INT);
    $action = $_POST['action'];
    
    if (!$appointment_id || !in_array($action, ['accept', 'reject'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
        exit;
    }
    
    try {
        $new_status = $action === 'accept' ? 'accepted' : 'rejected';
        $actual_appointment_id = $appointment_id - 100;
        
        $sql = "UPDATE appointment SET status = :status WHERE appointment_id = :appointment_id AND status = 'pending'";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':status' => $new_status,
            ':appointment_id' => $actual_appointment_id
        ]);
        
        $rowCount = $stmt->rowCount();
        
        if ($rowCount > 0) {
            echo json_encode(['success' => true, 'message' => 'Appointment updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No pending appointment found or already processed']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// Normal page load - fetch appointments
try {
    $sql = "SELECT 
                appointment_id, 
                client_name, 
                email, 
                phone_number, 
                appointment_date, 
                appointment_time,
                services_name,
                total_price,
                status 
            FROM pending_appointment_view 
            ORDER BY appointment_date, appointment_time ASC 
            LIMIT 10";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $appointments = [];
}
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Dashboard</title>
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
    <style>
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .status-accepted {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn-accept {
            background-color: #10b981;
            color: white;
        }
        
        .btn-accept:hover:not(:disabled) {
            background-color: #059669;
        }
        
        .btn-reject {
            background-color: #ef4444;
            color: white;
        }
        
        .btn-reject:hover:not(:disabled) {
            background-color: #dc2626;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        .dot-pending { background-color: #f59e0b; }
        .dot-accepted { background-color: #10b981; }
        .dot-rejected { background-color: #ef4444; }
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
              <h5 class="mb-0 font-medium">Dashboard</h5>
            </div>
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
              <li class="breadcrumb-item" aria-current="page">Dashboard</li>
            </ul>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="grid grid-cols-12 gap-x-6">
          <div class="col-span-12 xl:col-span-6 md:col-span-6">
            <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>This is Daily Sales</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <i class="feather icon-arrow-up text-success-500 text-[30px] mr-1.5"></i>$ 249.95
                  </h3>
                  <p class="mb-0">67%</p>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg">
                  <div class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar"
                    style="width: 75%"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-6 md:col-span-6">
            <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>This is Monthly Sales</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <i class="feather icon-arrow-down text-danger-500 text-[30px] mr-1.5"></i>$ 2.942.32
                  </h3>
                  <p class="mb-0">36%</p>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg">
                  <div class="bg-theme-bg-2 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar"
                    style="width: 35%"></div>
                </div>
              </div>
            </div>
          </div>
 
          <div class="col-span-12">
            <div class="card table-card">
              <div class="card-header">
                <h5>Pending Appointments</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tbody>
                        <?php if (!empty($appointments)): ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr id="appointment-<?php echo str_replace('AID', '', $appointment['appointment_id']); ?>">
                                    <td>
                                        <div class="font-weight-bold"><?php echo htmlspecialchars($appointment['client_name']); ?></div>
                                        <div class="text-primary"><?php echo htmlspecialchars($appointment['services_name']); ?></div>
                                        <div class="text-muted small">
                                            <?php echo htmlspecialchars($appointment['email']); ?><br>
                                            <?php echo htmlspecialchars($appointment['phone_number']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="status-dot dot-<?php echo $appointment['status']; ?>"></span>
                                            <span class="text-muted">
                                                <?php 
                                                $formattedDate = date('d M Y', strtotime($appointment['appointment_date']));
                                                echo $formattedDate . ' at ' . $appointment['appointment_time'];
                                                ?>
                                            </span>
                                        </div>
                                        <div class="text-muted">₱<?php echo number_format($appointment['total_price'], 2); ?></div>
                                        <span class="status-badge status-<?php echo $appointment['status']; ?>">
                                            <?php echo ucfirst($appointment['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($appointment['status'] == 'pending'): ?>
                                            <div class="action-buttons">
                                                <button class="btn btn-reject" 
                                                       onclick="handleAction(<?php echo str_replace('AID', '', $appointment['appointment_id']); ?>, 'reject')">
                                                       <i class="fas fa-times"></i> Reject
                                                </button>
                                                <button class="btn btn-accept" 
                                                       onclick="handleAction(<?php echo str_replace('AID', '', $appointment['appointment_id']); ?>, 'accept')">
                                                       <i class="fas fa-check"></i> Accept
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted small">Action taken</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <p>No pending appointments found</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>
    <!-- [ Main Content ] end -->
    <?php include '../includes/footer.php'; ?>

    <!-- Required Js -->
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/icon/custom-icon.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="../assets/js/component.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/script.js"></script>

    <script>
    // Add the missing handleAction function
    function handleAction(appointmentId, action) {
        const actionText = action === 'accept' ? 'accept' : 'reject';
        
        if (confirm(`Are you sure you want to ${actionText} this appointment?`)) {
            // Show loading state
            const buttons = document.querySelectorAll(`button[onclick*="${appointmentId}"]`);
            buttons.forEach(button => {
                button.disabled = true;
                button.innerHTML = action === 'accept' ? 
                    '<i class="fas fa-spinner fa-spin"></i> Accepting...' : 
                    '<i class="fas fa-spinner fa-spin"></i> Rejecting...';
            });

            // Create form data
            const formData = new FormData();
            formData.append('appointment_id', appointmentId);
            formData.append('action', action);
            
            // Send AJAX request
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(`Appointment ${actionText}ed successfully!`);
                    
                    // Remove the row from table
                    const row = document.getElementById(`appointment-${appointmentId}`);
                    if (row) {
                        row.style.backgroundColor = action === 'accept' ? '#f0fff4' : '#fff5f5';
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if no appointments left
                            const remainingRows = document.querySelectorAll('tbody tr');
                            if (remainingRows.length === 1) {
                                location.reload();
                            }
                        }, 1000);
                    }
                    
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
                
                // Reset buttons
                buttons.forEach(button => {
                    button.disabled = false;
                    button.innerHTML = button.onclick.toString().includes('accept') ? 
                        '<i class="fas fa-check"></i> Accept' : 
                        '<i class="fas fa-times"></i> Reject';
                });
            });
        }
    }

    // Your existing layout functions
    layout_change('false');
    layout_theme_sidebar_change('dark');
    change_box_container('false');
    layout_caption_change('true');
    layout_rtl_change('false');
    preset_change('preset-1');
    main_layout_change('vertical');
    </script>
</body>
</html>