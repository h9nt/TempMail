<?php
header('Content-Type: application/json');
include_once('utils/base.php');

$domain = $_GET['domain'];
$name = $_GET['name'];
$token = null;
if (empty($domain) || empty($name)) {
    return false;
} else {
    try {
        $e = TempMail::getEmail($domain, $name, $token);
        TempMail::inbox($e);
    } catch (Exception $e) {
        return true;
    }
}

?>