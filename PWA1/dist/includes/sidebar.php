 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
   <div class="navbar-wrapper">
     <div class="m-header flex items-center py-4 px-6 h-header-height">
       <a href="../admin/dashboard.php" class="b-brand flex items-center gap-3">
         <img src="../assets/images/*.png" alt="logo here" /> <!-- logo images here -->
       </a>
     </div>
     <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
       <div class="shrink-0 flex items-center justify-left mb-5">&nbsp;&nbsp;&nbsp;&nbsp;
         <h5 class="text-left font-medium text-[15px] flex items-center gap-2">
           <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="w-10 rounded-full" />Administrator
         </h5>
       </div>
       <div class="grow ms-3 text-center mb-4">
       </div>
       <ul class="pc-navbar">
         <li class="pc-item pc-caption">
           <label>Navigation</label>
         </li>

         <li class="pc-item"> <!-- Dashboard menu -->
           <a href="../admin/dashboard.php" class="pc-link">
             <span class="pc-micon"><i data-feather="home"></i></span>
             <span class="pc-mtext">Dashboard</span>
           </a>
         </li>

     

  
         <!-- Menu with sub menu -->
         <li class="pc-item pc-hasmenu">
           <a href="#!" class="pc-link"><span class="pc-micon"> <i data-feather="users"></i> </span><span
               class="pc-mtext">Clients</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
           <ul class="pc-submenu">
             <li class="pc-item"><a class="pc-link" href="../admin/template03.php">Manage</a></li>
             <li class="pc-item"><a class="pc-link" href="../admin/template04.php">Visit</a></li>
           </ul>
         </li>


            <li class="pc-item pc-hasmenu"> <!--Menu 02--->
           <a href="#!" class="pc-link"><span class="pc-micon"> <i data-feather="users"></i> </span><span
             class="pc-mtext">Appointment</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
           <ul class="pc-submenu">
             <li class="pc-item"><a class="pc-link" href="../admin/template05.php">All appointment</a></li>
             <li class="pc-item"><a class="pc-link" href="../admin/template06.php">Add appointment</a></li>
              <li class="pc-item"><a class="pc-link" href="../admin/template07.php">Accepted appointment</a></li>
               <li class="pc-item"><a class="pc-link" href="../admin/template08.php">Rejected appointment</a></li>
               
           </ul>
         </li>

         <li class="pc-item"> <!-- Services Menu -->
           <a href="../admin/template09.php" class="pc-link">
             <span class="pc-micon"><i data-feather="scissors"></i></span>
             <span class="pc-mtext">Services</span>
           </a>
         </li>



   
         <!-- Menu with submenu end -->

     
         <!-- Settings -->
         <li class="pc-item pc-caption">
           <label>Settings</label><i data-feather="wrench"></i>
         </li>
         <li class="pc-item pc-hasmenu">
           <a href="#" class="pc-link" onclick="return alert('About this System\n\nSystem Name: Template\nDeveloper: (Student Name)\nContact No. (Contact No.)\nEMail: (email)\n\nCopyright © 2025 Software Solutions.\nAll rights reserved.');">
             <span class="pc-micon"><i class="ti ti-headset"></i></i></span><span class="pc-mtext">About</span>
           </a>
         </li>
         <li class="pc-item pc-hasmenu">
           <!--<a href="logout.php" class="pc-link" onclick="return confirm('Do you really want to Log-Out?')"> -->
           <a href="logout.php" class="pc-link">
             <span class="pc-micon"> <i data-feather="log-out"></i></span><span class="pc-mtext">Log-Out</span>
           </a>
         </li>

       </ul>
     </div>
   </div>
 </nav>
 <!-- [ Sidebar Menu ] end -->