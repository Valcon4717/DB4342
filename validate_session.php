<!--
/**
 * CS 4342 Database Management
 * 
 * This file contains the validation for the session.
 * 
 * @author Jasmin Salmon, Valeria Contreras, Eric Gardea, and Fernando Sepulveda
 * @version 1.0
 */
-->

<?php

if (!isset($_SESSION['logged_in']) || empty($_SESSION['logged_in'])) { 
     //header('Location: ../index.php'); 
	 die("::Access restricted to users logged in::");
} 

?>