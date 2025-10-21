<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HomePage</title>
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
<!----ENDING OF HEADER---->

<main class="homepage_main">
   <img src="HAIR.jfif" class="upper_pic1"> <!---empty photo!!!--->
   <p class="upper_text1">PASSION • CARE • ELEGANCE</p>
   <p class="upper_text2">LET YOUR BEAUTY<br>
	BLOOM</p>
   <p class="upper_text3">More than a salon — a place for<br>
	timeless confidence.</p>
   <p class="upper_text4">CONTACT US</p>
   <hr class="upper_line">
   <p class="upper_email">beautyblossom@gmail.com</p>
   <p class="upper_number">+63 945 250 8060</p>
<a href="about.php"><button type="button" class="learn_more">LEARN MORE</button></a><br>

	

  <h1 class="lower_text1">READY TO BLOOM?</h1>
  <img src="../assets/images/pic.jfif" class="lower_pic1">

<p class="lower_text2">At Bloom Salon, we believe every client deserves to feel<br> confident, radiant, and uniquely themselves. With a<br> calming atmosphere and skilled stylists, we’re here to<br> give you morethan just a haircut, it’s a full experience<br> of self-care. Whether you’re looking for a bold<br> transformation or a simple refresh, we’ll create a style<br> that highlights your natural beauty and complements<br> your lifestyle. Your perfect look is waiting to bloom<br>—let’s find it together.
</p>
 <a href="book.php"><button type="button" class="book_now2">BOOK NOW</button></a>
	
</main>

<!--- END OF MAIN --->

<footer class="homepage_footer">
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

/****** HOMEPAGE MAIN******/

.homepage_main{
	background-color: #0c0039;
	width: auto;
	height: 770px;
}

.upper_pic1{
	width:500px ;
	height: 550px;
	position: relative;
	top: 200px;
	left: 100px;

}

.upper_text1{
	font-family: 'Poppins', sans-serif;
	color: white;
	font-size: 28pt;
	position: relative;
	left: 50%;
	bottom: 300px;
}

.upper_text2{
	font-family: 'Work Sans', sans-serif;
	color: white;
	font-size: 40pt;
	position: relative;
	left: 50%;
	bottom: 270px;
}

.upper_text3{
	font-family: 'Poppins', sans-serif;
	color: white;
	font-size: 20pt;
	position: relative;
	left: 50%;
	bottom: 260px;
}

.upper_text4{
	font-family: 'Poppins', sans-serif;
	color: white;
	font-size: 12pt;
	position: relative;
	left: 59%;
	bottom: 233px;

}

.upper_line{
	width: 13.5%;
	color: white;
	position: relative;
	left: 66%;
	bottom: 245px;
}

.upper_email{
	font-family: 'Poppins', sans-serif;
	color: white;
	font-size: 11pt;
	position:relative ;
	left: 66%;
	bottom: 270px;
}

.upper_number{
	font-family: 'Poppins', sans-serif;
	color: white;
	font-size: 11pt;
	position: relative;
	left: 66%;
	bottom: 266px;
}

.learn_more{
	font-family: 'Poppins', sans-serif;
	background-color: #68689b;
	width: 120px;
	height: 40px;
	position: absolute;
	color: white;
	position: relative;
	left: 50%;
	bottom: 310px;
}

.lower_text1{
	font-family: 'Work Sans', sans-serif;
	font-size: 35pt;
	position: relative;
	left: 8%;
	top: -80px;
}

.lower_pic1{
	width: 500px;
	height: 500px;
	position: relative;
	bottom: 0px;
	left: 65%;
}

.lower_text2{
	font-family: 'Poppins', sans-serif;
    font-size: 20pt;
	position: relative;
	left: 120px;
	bottom:520px;
}

.book_now2{
	background-color: #000080;
	width: 150px;
	height: 60px;
	position: absolute;
	color: white;
	position: relative;
	left: 7.9%;
	bottom: 460px;
}



/***** END OF MAIN ****/

/**** HOMEPAGE FOOTER ***/

.homepage_footer{
	background-color: #7668a3;
	width: auto;
	height: 400px;
	position: relative;
	top: 670px;
	margin-top: 70px;
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