<?php
/**
 * 快速测试用例 - 包含最常见的缺陷
 * 适合快速测试系统功能
 */

// 1. SQL 注入漏洞（高危）
$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = " . $id;
mysql_query($query);

// 2. XSS 跨站脚本（高危）
echo $_GET['name'];
echo "<h1>欢迎, " . $_POST['user'] . "</h1>";

// 3. 密码明文存储（高危）
$password = $_POST['password'];
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
mysql_query($sql);

// 4. 未关闭数据库连接（中危）
$conn = mysql_connect("localhost", "user", "pass");
$result = mysql_query("SELECT * FROM users");
// 缺少 mysql_close($conn);

// 5. 死循环风险（中危）
while(true) {
    processData();
    // 没有退出条件
}

// 6. 数组越界（中危）
$arr = array(1, 2, 3);
$value = $arr[10];

// 7. 未过滤用户输入（高危）
$file = $_GET['file'];
include($file . '.php');

// 8. 条件判断错误（中危）
if ($userId = 1) { // 应该是 ==
    return true;
}

?>
