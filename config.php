<?php
/*
  Configurations
*/

//General
define('BASE_URL', 'http://toolboxsv.com/dev/CMS/1');
define('NAME', 'Elaniin CMS');
define('SLOGAN', 'Our open-source platform');
define('P_EMAIL', 'cms@toolboxsv.com');
define('LOGO', 'http://toolboxsv.com/dev/CMS/1/img/logo.png');
define('COLOR', '#E91E63');
define('LANGUAGE', 'es');

define('TIMEZONE', 'America/El_Salvador');

define('FORCE_HTTPS', 0);

//Database Info
define('DATABASE_NAME', 'syncfont_main'); 
define('DATABASE_USER', 'syncfont_admin');
define('DATABASE_PASS', 'Fl$Sdy51Gzq!');
define('DATABASE_HOST', 'localhost'); 

//Normal Register
define('NLOGIN_ENABLE', 1);
define('REGISTER_ENABLE', 1);
define('FORGOT_ENABLE', 1);

//Google Login
//You can get it from: https://console.developers.google.com/
define('GLOGIN_ENABLE', 1);
define('GLOGIN_CLIENT_ID', '66889395-l19ctt4ujieo5l28q85lrqgt8qce7gn4.apps.googleusercontent.com');
define('GLOGIN_CLIENT_SECRET', 'OH2EV5r0O04uPVQIn9RF08H3');

//Facebook Login
//You can get it from: https://developers.facebook.com/
define('FLOGIN_ENABLE', 1);
define('FLOGIN_APP_ID', '465871913602533');
define('FLOGIN_APP_SECRET', '42e4ebdf9d71b15daf9066a9384424f9');

//Advance Settings
//If you not sure what happend here not change nothing.
define('DEFAULT_MODULE', 'general');
define('DEFAULT_PAGE', 'home');
define('DEFAULT_LEVEL', '2');

?>