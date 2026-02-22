<?php
// SQL 注入漏洞
$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = " . $id;
mysql_query($query);

// XSS 漏洞
echo $_GET['name'];
?>
