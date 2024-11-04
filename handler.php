<?php
// Load Composer's autoloader if using packages
// require '/vendor/autoload.php';

// Set allow_url_fopen
ini_set('allow_url_fopen', 1);

// Handle routing based on the request URI
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
    case '/splash.html':
        require 'splash.html';
        break;
    case '/home':
    case '/home.php':
        require 'home.php';
        break;
    case '/login':
    case '/login.php':
        require 'pages/login.php';
        break;
    case '/signup':
    case '/signup.php':
        require 'pages/signup.php';
        break;
    case '/chat':
    case '/chat.php':
        require 'chat.php';
        break;
    case '/office':
    case '/office.php':
        require 'office.php';
        break;
    case '/office_detail':
    case '/office_detail.php':
        require 'office_detail.php';
        break;
    case '/logout':
    case '/logout.php':
        require 'logout.php';
        break;
    case '/successful':
    case '/successful.php':
        require 'successful.php';
        break;
    case '/tokens':
    case '/tokens.php':
        require 'tokens.php';
        break;
    case '/transmit':
    case '/transmit.php':
        require 'transmit.php';
        break;
    default:
        http_response_code(404);
        echo '404 Not Found: ' . htmlspecialchars(@parse_url($_SERVER['REQUEST_URI'])['path']);
        exit();
}
?>
