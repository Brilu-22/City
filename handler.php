<?php
// Make sure to include the Composer autoloader if you are using Composer
//require '/vendor/autoload.php';

// Set up routing based on the request URI
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
    case '/home':
    case '/home.php':
        require 'home.php'; // This serves your home page
        break;
    case '/splash.html':
        require 'splash.html'; // This serves your splash page
        break;
    case '../pages/login':
    case '../pages/login.php':
        require '../pages/login.php'; // Ensure this path is correct
        break;
    case '../pages/signup':
    case '../pages/signup.php':
        require '../pages/signup.php'; // Ensure this path is correct
        break;
    case '/successful':
    case '/successful.php':
        require 'successful.php'; // This serves your success page
        break;
    case '/tokens':
    case '/tokens.php':
        require 'tokens.php'; // This serves your tokens page
        break;
    case '/transmit':
    case '/transmit.php':
        require 'transmit.php'; // This serves your transmit page
        break;
    case '/office':
    case '/office.php':
        require 'office.php'; // This serves your office page
        break;
    case '/office_detail':
    case '/office_detail.php':
        require 'office_detail.php'; // This serves your office detail page
        break;
    case '/logout':
    case '/logout.php':
        require 'logout.php'; // This serves your logout page
        break;
    default:
        http_response_code(404);
        echo @parse_url($_SERVER['REQUEST_URI'])['path'] . ' Not Found';
        exit('Not Found');
}
