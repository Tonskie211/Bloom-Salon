<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book</title>
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

<!-- BOOKING FORM -->
<main class="book_main">
    <h1 class="booking_text">BOOKING</h1>

    <form action="book_process.php" method="post">
        <!-- Personal Information Section -->
        <div class="personal-info">
            <input type="text" name="firstname" placeholder="First Name:" required class="input1">
            <input type="text" name="lastname" placeholder="Last Name:" required class="input2">
            <input type="email" name="email" placeholder="Email Address:" required class="input3">
            <input type="tel" name="phone" placeholder="Phone Number" required class="input4" pattern="\d{11}" maxlength="11">
        </div>

        <!-- Services Section -->
        <div class="services-section">
            <h3 class="services-title">SELECT SERVICES</h3>
            <div class="services-checkboxes">
                <div class="service-option">
                    <input type="checkbox" id="service1" name="services[]" value="1" class="service-checkbox">
                    <label for="service1" class="service-label">REBOND WITH BOTOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service2" name="services[]" value="2" class="service-checkbox">
                    <label for="service2" class="service-label">REBOND WITH REGULAR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service3" name="services[]" value="3" class="service-checkbox">
                    <label for="service3" class="service-label">REBOND WITH BRAZILIAN</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service4" name="services[]" value="4" class="service-checkbox">
                    <label for="service4" class="service-label">REBOND WITH COLOR</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service5" name="services[]" value="5" class="service-checkbox">
                    <label for="service5" class="service-label">REBOND WITH COLOR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service6" name="services[]" value="6" class="service-checkbox">
                    <label for="service6" class="service-label">COLORING</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service7" name="services[]" value="7" class="service-checkbox">
                    <label for="service7" class="service-label">COLOR</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service8" name="services[]" value="8" class="service-checkbox">
                    <label for="service8" class="service-label">COLOR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service9" name="services[]" value="9" class="service-checkbox">
                    <label for="service9" class="service-label">HAIR BOTOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service10" name="services[]" value="10" class="service-checkbox">
                    <label for="service10" class="service-label">HAIR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service11" name="services[]" value="11" class="service-checkbox">
                    <label for="service11" class="service-label">HAIRCUT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service12" name="services[]" value="12" class="service-checkbox">
                    <label for="service12" class="service-label">REGULAR TREATMENT</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service13" name="services[]" value="13" class="service-checkbox">
                    <label for="service13" class="service-label">HAIR BOTOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service14" name="services[]" value="14" class="service-checkbox">
                    <label for="service14" class="service-label">HAIR BRAZILIAN</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service15" name="services[]" value="15" class="service-checkbox">
                    <label for="service15" class="service-label">HAIR DETOX</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service16" name="services[]" value="16" class="service-checkbox">
                    <label for="service16" class="service-label">MANICURE / PEDICURE</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service17" name="services[]" value="17" class="service-checkbox">
                    <label for="service17" class="service-label">FOOTSPA</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service18" name="services[]" value="18" class="service-checkbox">
                    <label for="service18" class="service-label">GEL POLISH</label>
                </div>
                <div class="service-option">
                    <input type="checkbox" id="service19" name="services[]" value="19" class="service-checkbox">
                    <label for="service19" class="service-label">PARAFFIN WAX</label>
                </div>
            </div>
        </div>

        <!-- Appointment Time Section -->
        <div class="appointment-time">
            <h4 class="preffered_date">Preferred Appointment Date</h4>
            <h4 class="preffered_time">Preferred Appointment Time</h4>
            
            <input type="date" name="date" required placeholder="Preferred Appointment Date" class="input6">
            <select class="input7" name="time" required>
                <option value="" selected disabled>Time Preferred</option>
                <option value="08:00:00">8:00 AM</option>
                <option value="09:00:00">9:00 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="11:00:00">11:00 AM</option>
                <option value="12:00:00">12:00 PM</option>
                <option value="13:00:00">1:00 PM</option>
                <option value="14:00:00">2:00 PM</option>
                <option value="15:00:00">3:00 PM</option>
                <option value="16:00:00">4:00 PM</option>
            </select>
        </div>

        <button type="submit" name="submit" class="submit_book">ENTER</button>
    </form>
</main>

<footer class="book_footer">
    <img src="../assets/images/LOGO2.jpg" class="logo2">
    <p class="footer_address">183 Purok 2 Lucao District,<br> Dagupan City Pangasinan</p>
    <p class="footer_line1">_____________________________________________________________</p>
    <p class="footer_line2">_____________________________________________________________</p>
    <p class="footer_line3">|</p>    
    <p class="footer_email">beautyblossom@gmail.com</p>
    <p class="footer_number">+63 945 250 8060</p>
    <p class="nocopyright">Copyright © 2025 PHINMA University of Pangasinan. All rights reserved.</p>
</footer>

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

/**** BOOKING MAIN ***/

.book_main{
    background-color: #0c0039;
    width: 1000px;
    height: 1100px;
    position: relative;
    left: 270px;
    top: 120px;
    padding: 40px 0;
    margin-bottom: 0;
}

.booking_text{
    font-family: 'Work Sans', sans-serif;
    color: white;
    font-size: 40pt;
    text-align: center;
    margin-bottom: 40px;
}

/* Personal Information Section */
.personal-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    width: 700px;
    margin: 0 auto 30px auto;
}

.input1, .input2, .input3, .input4 {
    width: 320px;
    color: white;
    height: 40px;
    background-color: #0c0039;
    border: 2px solid white;
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
}

.input1::placeholder, .input2::placeholder, .input3::placeholder, .input4::placeholder {
    color: #ccc;
}

.input1 { justify-self: start; }
.input2 { justify-self: end; }
.input3 { justify-self: start; }
.input4 { justify-self: end; }

/* Services Section */
.services-section {
    width: 700px;
    margin: 0 auto 30px auto;
}

.services-title {
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 18pt;
    text-align: center;
    margin: 30px 0 20px 0;
}

.services-checkboxes {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 20px;
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
}

.service-option {
    display: flex;
    align-items: center;
    gap: 8px;
}

.service-checkbox {
    width: 16px;
    height: 16px;
    accent-color: #68689b;
}

.service-label {
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 10pt;
    cursor: pointer;
}

.service-checkbox:checked + .service-label {
    color: #68689b;
    font-weight: bold;
}

/* Appointment Time Section */
.appointment-time {
    width: 700px;
    margin: 30px auto 40px auto;
    position: relative;
}

.preffered_date, .preffered_time {
    font-family: 'Poppins', sans-serif;
    color: white;
    font-size: 15pt;
    margin-bottom: 10px;
}

.preffered_date {
    position: absolute;
    left: 0;
    top: 0;
}

.preffered_time {
    position: absolute;
    right: 0;
    top: 0;
}

.input6, .input7 {
    width: 320px;
    color: white;
    height: 40px;
    background-color: #0c0039;
    border: 2px solid white;
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    margin-top: 40px;
}

.input6 {
    float: left;
}

.input7 {
    float: right;
}

.submit_book{
    width: 200px;
    height: 50px;
    background-color: #68689b;
    color: white;
    border: none;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    cursor: pointer;
    display: block;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.submit_book:hover{
    background-color: #7a7aaf;
    transform: translateY(-2px);
}

/***** END OF MAIN ****/

/**** BOOKING FOOTER ***/

.book_footer{
    background-color: #7668a3;
    width: 100%;
    height: 400px;
    position: relative;
    top: 120px;
    margin-top: 0;
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

.footer_line1{
    color: white;
    font-size:30pt;
    position: relative;
    left: 168px;
    top: 50px;
}

.footer_line2{
    color: white;
    font-size:30pt;
    position: relative;
    left: 168px;
    top: 60px;
}

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

/**** END OF FOOTER ***/

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

/* Clear floats */
.appointment-time::after {
    content: "";
    display: table;
    clear: both;
}
</style>
</body>
</html>