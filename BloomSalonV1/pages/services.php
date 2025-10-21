<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Services</title>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"> <!---font--->
</head>

<body>
<nav class="navbar">
  <div class="navbar-center">
    <img src="../assets/images/SALON LOGO.png" alt="logo" class="logo">
    <div class="nav-links">
		<p class="tagline">Where Beauty Blossoms</p>
      <a href="index.php"class="home">HOME</a>
      <a href="about.php"class="about">ABOUT</a>
      <a href="services.php"class="services">SERVICES</a>
      <a href="contact.php"class="contact">CONTACT</a>
      <a href="appointment.php"class="appointment">APPOINTMENT</a>
		  <a href="book.php"><button type="button"class="book_now1">BOOK NOW</button></a>
    </div>
  </div>
</nav>

<button class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">↑</button>
 <!---- END OF HEADER --->
 <main class="services_main">
   <h1 class="services_text">SERVICES</h1>
   
   <!----  REBOND --->
   <h3 class="rebond">REBOND</h3>

   <p class="text1">REBOND WITH BOTOX</p>
   <hr class="line1">
   <p class="no1">₱2000</p>

   <p class="text2">REBOND WITH  REGULAR TREATMENT </p>
   <hr class="line2">
   <p class="no2">₱1500 </p>

   <p class="text3">REBOND WITH BRAZILIAN</p>
   <hr class="line3">
   <p class="no3"> ₱2500</p>

   <p class="text4">REBOND WITH COLOR</p>
   <hr class="line4">
   <p class="no4">₱2800</p>

   <p class="text5">REBOND WITH COLOR TREATMENT</p>
   <hr class="line5">
   <p class="no5">₱3000</p>



   <!---- COLORING --->

   <h3 class="coloring">COLORING</h3>

   <p class="text6">COLOR</p>
   <hr class="line6">
   <p class="no6">₱1000</p>

   <p class="text7">COLOR TREATMENT</p>
   <hr class="line7">
   <p class="no7"> ₱1500</p>

   <p class="text8">HAIR BOTOX</p>
   <hr class="line8">
   <p class="no8"> ₱1500</p>

   <!---- HAIR TREATMENT --->

   <h3 class="hair_treatment">HAIR TREATMENT</h3>

   <p class="text9">HAIRCUT</p>
   <hr class="line9">
   <p class="no9">₱2000</p>

   <p class="text10">REGULAR TREATMENT</p>
   <hr class="line10">
   <p class="no10">₱500</p>
 
   <p class="text11">HAIR BOTOX</p>
   <hr class="line11">
   <p class="no11">₱1500</p>

   <p class="text12">HAIR BRAZILIAN</p>
   <hr class="line12">
   <p class="no12">₱1800</p>

   <p class="text13">HAIR DETOX</p>
   <hr class="line13">
   <p class="no13">₱1500</p>

<!--- OTHER SERVICES --->
    <h3 class="other_services">OTHER SERVICES</h3>


   <p class="text14">MANICURE / PEDICURE</p>
   <hr class="line14">
   <p class="no14">₱250</p>


   <p class="text15"> FOOTSPA</p>
   <hr class="line15">
   <p class="no15">₱200</p>


   <p class="text16">GEL POLISH</p>
   <hr class="line16">
   <p class="no16">₱450</p>


   <p class="text17">PARAFFIN WAX</p>
   <hr class="line17">
   <p class="no17">₱200</p>
</main>
<!--- SERVICES FOOTER --->

<footer class="services_footer">
	<img src="../assets/images/LOGO2.jpg" class="logo2">

	<p class="footer_address">183 Purok 2 Lucao District,<br> Dagupan City Pangasinan</p>

	<p class="footer_line1">_____________________________________________________________</p>

	<p class="footer_line2">_____________________________________________________________</p>

	<p class="footer_line3">|</p>    
	
	<p class="footer_email">beautyblossom@gmail.com</p>

	<p class="footer_number">+63 945 250 8060</p>

	<p class="nocopyright">Copyright © 2025 PHINMA University of Pangasinan. All rights reserved.</p>

</footer>


</body>

<style>
*{
	padding: 0;
	margin: 0;
}

html,body{
	height: 100%;
}

body{
	overflow-x: hidden;
}

body::-webkit-scrollbar {
  display: none; 
}


.navbar {
  background: white;
  width: 100%;
  height: 98px;
  color: white;
  padding: 1rem 2rem;
  display: flex;
  justify-content: center; /* Center the navbar-center container */
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

.home{
	font-family: 'Poppins', sans-serif;
	text-decoration: none;
	font-size: 13pt;
	color: black;
	position: relative;
	left: 90px;
	bottom: 15px;
	padding: 15px;
	background-color: white;
}

.home:hover{
	padding: 15px;
	background-color: #e1e4f0;
	transition: 0.3s;
}

.home::after{
	content: "";
	position: absolute;
	left: 0;
	bottom: 0;
	height: 2px;
	width: 0;
	background-color: black;
	transition: width 0.3s;
}

.home:hover::after{
	width: 100%;
}


.about{
	font-family: 'Poppins', sans-serif;
	text-decoration: none;
	font-size: 13pt;
	color: black;
	position: relative;
	left: 105px;
	bottom: 15px;
	padding: 15px;
	background-color: white;
}

.about:hover{
	padding: 15px;
	background-color:#e1e4f0;
	transition: 0.3s;
}

.about::after{
	content:"";
	position: absolute;
	left: 0;
	bottom: 0;
	height: 2px;
	width: 0;
	background-color: black;
	transition: width 0.3s;

}

.about:hover::after{
	width: 100%;
}

.services{
	font-family: 'Poppins', sans-serif;
	text-decoration: none;
	font-size: 13pt;
	color: black;
    position: relative;
	left: 120px;
	bottom: 15px;
	padding: 15px;
	background-color: white;
}

.services:hover{
	padding: 15px;
	background-color:#e1e4f0;
	transition: 0.3s;
}

.services::after{
	content:"";
	position: absolute;
	left: 0;
	bottom: 0;
	height: 2px;
	width: 0;
	background-color: black;
	transition: width 0.3s;
}

.services:hover::after{
	width: 100%;
}	

.contact{
	font-family: 'Poppins', sans-serif;
	text-decoration: none;
	font-size: 13pt;
	color: black;
    position: relative;
	left: 135px;
	bottom: 15px;
	padding: 15px;
	background-color: white;
}

.contact:hover{
	padding: 15px;
	background-color:#e1e4f0 ;
	transition: 0.3s;
    
}

.contact::after{
	content:"";
	position: absolute;
	left: 0;
	bottom: 0;
	height: 2px;
	width: 0;
	background-color: black;
	transition: width 0.3s;
}

.contact:hover::after{
	width: 100%;
}



.appointment{
	font-family: 'Poppins', sans-serif;
	text-decoration: none;
	font-size: 13pt;
	color: black;
    position: relative;
	left: 150px;
	bottom: 15px;
	padding: 15px;
	background-color: white;
}

.appointment:hover{
	padding: 15px;
	background-color:#e1e4f0 ;
	transition: 0.3s;
    
}

.appointment::after{
	content:"";
	position: absolute;
	left: 0;
	bottom: 0;
	height: 2px;
	width: 0;
	background-color: black;
	transition: width 0.3s;
}

.appointment:hover::after{
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
}

button:hover{
	background-color:#e1e4f0 ;
	color: black;
}

/***** END OF HEADER ***/

/**** SERVICES MAIN ***/

.services_main{
	background-color: #0c0039;
	width: 1200px;
	height:1200px;
	position: relative;
	left: 170px;
}

.services_text{
	font-family: 'Work Sans', sans-serif;
	font-size: 40pt;
	color: white;
	position: relative;
	left: 465px;
	top: 150px;
}

.rebond{
	font-family: 'Work Sans', sans-serif;
	color:white;
	font-size: 28pt;
	position: relative;
	left: 55px;
	top: 160px;
}
.text1{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 170px;
}

.line1{
	width: 55%;
	position: relative;
	left:390px;
	top: 155px;
}

.no1{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 141px;
}

.text2{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 150px;
}

.line2{
	width: 40.9%;
	position: relative;
	left:560px;
	top: 136px;
}

.no2{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 123px;
}

.text3{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 130px;
}

.line3{
	width: 51.7%;
	position: relative;
	left:430px;
	top: 118px;
}

.no3{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 104px;
}

.text4{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 110px;
}

.line4{
	width: 55%;
	position: relative;
	left:390px;
	top: 96px;
}

.no4{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 84px;
}

.text5{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 90px;
}

.line5{
	width: 43%;
	position: relative;
	left:535px;
	top: 75px;
}

.no5{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 62px;
}

.coloring{
	font-family: 'Work Sans', sans-serif;
	color:white;
	font-size: 28pt;
	position: relative;
	left: 55px;
	top: 80px;
}

.text6{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 90px;
}

.line6{
	width: 68.3%;
	position: relative;
	left:230px;
	top: 76px;
}

.no6{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 63px;
}

.text7{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 70px;
}

.line7{
	width: 56.7%;
	position: relative;
	left: 370px;
	top: 55px;
}

.no7{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 42px
}

.text8{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 50px;
}

.line8{
	width: 63.6%;
	position: relative;
	left: 287px;
	top: 36px;
}
.no8{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 24px;
}

.hair_treatment{
	font-family: 'Work Sans', sans-serif;
	color:white;
	font-size: 28pt;
	position: relative;
	left: 55px;
	top: 44px;
}

.text9{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 54px;
}

.line9{
	width: 66.1%;
	position: relative;
	left: 257px;
	top: 40px;
}
.no9{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 27px;
}

.text10{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 34px;
}

.line10{
	width: 55.4%;
	position: relative;
	left:385px;
	top: 20px;
}
.no10{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: 8px;
}

.text11{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: 14px;
}

.line11{
	width: 63%;
	position: relative;
	left: 294px;
	top: 0px;
}
.no11{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: -12px;
}

.text12{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: -6px;
}

.line12{
	width: 59.6%;
	position: relative;
	left: 334px;
	top: -20px;
}

.no12{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: -32px;
}

.text13{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: -26px;
}

.line13{
	width: 64%;
	position: relative;
	left:282px;
	top: -40px;
}
.no13{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: -52px;
}

.other_services{
	font-family: 'Work Sans', sans-serif;
	color:white;
	font-size: 28pt;
	position: relative;
	left: 55px;
	top: -32px;
}


.text14{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: -22px;
}

.line14{
	width: 54.2%;
	position: relative;
	left:400px;
	top: -36px;
}
.no14{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: -48px;
}

.text15{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: -42px;
}

.line15{
	width: 67%;
	position: relative;
	left:246px;
	top: -57px;
}
.no15{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: -68px;
}

.text16{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: -62px;
}

.line16{
	width: 64.8%;
	position: relative;
	left:272px;
	top: -76px;
}

.no16{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: -88px;
}

.text17{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 17pt;
	position: relative;
	left: 120px;
	top: -82px;
}

.line17{
	width: 60.8%;
	position: relative;
	left:321px;
	top: -96px;
}
.no17{
	font-family: 'Poppin', sans-serif;
	color: white;
	font-size: 18pt;
	position: relative;
	left: 90%;
	top: -108px;
}

/**** END OF SERVIEC MAIN ****/

/**** SERVICES FOOTER ****/	

.services_footer{
	background-color: #7668a3;
	width: auto;
	height: 400px;
	position: relative;
	top: 670px;
	margin-top: -700px;
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

/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 50px;
    right: 35px;
    width: 50px;
    height: 50px;
    background-color:whie;
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
}
</style>

</html>