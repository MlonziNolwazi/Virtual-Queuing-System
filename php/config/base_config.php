<?php
// Base URL Configuration
// This file generates the dynamic base URL for the application

// Get the protocol (http or https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Get the host
$host = $_SERVER['HTTP_HOST'];

// Get the directory path of the current script
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);

// Construct the base URL
$baseUrl = $protocol . '://' . $host . $scriptPath . '/';
?>
