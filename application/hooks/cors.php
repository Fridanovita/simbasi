<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cors {
    public function __construct() {
        // header('Access-Control-Allow-Origin: *'); // Allow from any origin
        header("Access-Control-Allow-Origin: http://localhost"); // Adjust this to the specific origin you want to allow
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");
    }
}
