<?php
/**
 * Test script sending email
 *
 * @use `php email.php` or `php email.php your@cool.mail`
 *
 * @author demmonico@gmail.com
 */

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

$from = 'dep.soft@mail.ru';
$headers = "From: $from";

$to = isset($argv[1]) && filter_var($argv[1], FILTER_VALIDATE_EMAIL) ? $argv[1] : 'demmonico@gmail.com';
$subject = 'PHP Mail Test script';
$message = 'This is a test to check the PHP Mail functionality';

mail($to,$subject,$message, $headers);

echo "Test email was sent. Check mailbox, pls\n";
