<?php 

/*
 * Advanced Topics in Web Development
 * Darren Williams - 12039763
 *
 * output.php
 *
 * Used to output representations
 * based on return value of query string
 * i.e rfda, md, jsonld or empty
 * 
 */

//define an empty data
$data = '';
//If data is set in url query string get value
if(isset($_GET['data'])){
    $data = $_GET['data'];
}
//Create connection
require_once("includes/config.php"); 
//Get functions
require_once('includes/functions.php'); 

    //Switch statements for data output type
    switch($data){
        //If Microdata
        case 'md':
            include('includes/header.php');
            echo '<h3>MicroData Table</h3>';
            echo createTable($conn,$data);
            include('includes/footer.php');
        break;
        //If RDFa
        case 'rdfa':
            include('includes/header.php');
            echo '<h3>RDFa Table</h3>';
            echo createTable($conn,$data);
            include('includes/footer.php');
        break;
        //If JSON-LD
        case 'jsonld':
            //Set header
            header('Content-Type: application/json; charset=UTF-8');
            echo createJson($conn);
        break;
        //If XML
        case 'xml':
            //Set header
            header('Content-type:text/xml');
            echo createXML($conn);
        break;
        //Default HTML markup
        default:
            include('includes/header.php');
            echo '<h3>Plain Table</h3>';
            echo createTable($conn,$data);
            include('includes/footer.php');
        break;
    }
?>	
	
