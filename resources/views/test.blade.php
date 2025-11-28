
<?php
$publicIP = file_get_contents("http://ipecho.net/plain");
echo $publicIP .': Public IP<br>';

$localIp = gethostbyname(gethostname());
echo $localIp.': Local IP<br>';

?>

<?php
echo gethostname().': Host Name<br>'; // may output e.g,: sandie

// Or, an option that also works before PHP 5.3
echo php_uname('n').': Other Data 1<br>'; // may output e.g,: sandie

echo $_SERVER['HTTP_HOST'].': Host Name'
?>

