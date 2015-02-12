<?php
/*
* Advanced Topics in Web Development
* Darren Williams - 12039763
*
* config.php
* 
* Database connection
* and constants
*
*/

//Set environment - 'production' or 'development'
$environment = 'production';

//If production environment (Cems webspace)
if($environment == 'production'){

	//Cems home with isa
	define("HOME", "http://isa.cems.uwe.ac.uk/~d46-williams/atwd1/assignment/");

	// Database Constants cems
	define("DB_SERVER", "mysql5");
	define("DB_USER", "fet12039763");
	define("DB_PASS", "6r53AEN7");
	define("DB_NAME", "fet12039763"); 
	
//else if development environment (localhost)
}elseif($environment == 'development'){

	//Local home
	define("HOME", "http://localhost/uwe3/ATiWD/assignment/");

	// Database Constants local
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "atwd_assignment"); 

}

//Create a connection 
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if(mysqli_connect_errno()){ 
    echo "connection error! " . mysqli_connect_error(); 
} 
//Set charset
mysqli_set_charset($conn, "utf8");

?>
