<?php
/**
 * PHP 代码缺陷检测系统 - 测试用例
 * 此文件包含多种常见的 PHP 代码缺陷，用于测试缺陷检测系统
 */

// ==================== 1. SQL 注入漏洞 ====================
function getUserById($id) {
    // 危险：直接拼接用户输入到 SQL 查询
    $query = "SELECT * FROM users WHERE id = " . $id;
    $result = mysql_query($query);
    return mysql_fetch_array($result);
}

function searchUsers($keyword) {
    // 危险：未使用预处理语句
    $query = "SELECT * FROM users WHERE name LIKE '%" . $_GET['keyword'] . "%'";
    return mysql_query($query);
}

// ==================== 2. XSS 跨站脚本漏洞 ====================
function displayUserInput() {
    // 危险：直接输出用户输入，未转义
    echo $_GET['name'];
    echo $_POST['comment'];
    print $_REQUEST['message'];
}

function showWelcome() {
    $username = $_GET['user'];
    // 危险：在 HTML 中直接输出
    echo "<h1>欢迎, " . $username . "</h1>";
}

// ==================== 3. 文件包含漏洞 ====================
function includeFile() {
    // 危险：直接使用用户输入作为文件路径
    $file = $_GET['page'];
    include($file . '.php');
    
    // 危险：远程文件包含
    require($_POST['template']);
}

// ==================== 4. 密码明文存储 ====================
function registerUser($username, $password) {
    // 危险：密码明文存储
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    mysql_query($sql);
}

function updatePassword($userId, $newPassword) {
    // 危险：未加密存储密码
    $query = "UPDATE users SET password = '$newPassword' WHERE id = $userId";
    mysql_query($query);
}

// ==================== 5. 未关闭数据库连接 ====================
function connectDatabase() {
    // 危险：未关闭数据库连接
    $conn = mysql_connect("localhost", "root", "password");
    $db = mysql_select_db("mydb", $conn);
    // 缺少 mysql_close($conn);
}

function queryData() {
    $mysqli = new mysqli("localhost", "user", "pass", "database");
    $result = $mysqli->query("SELECT * FROM users");
    // 危险：未关闭连接
    // 应该调用 $mysqli->close();
}

// ==================== 6. 未过滤用户输入 ====================
function processForm() {
    // 危险：未验证和过滤输入
    $email = $_POST['email'];
    $age = $_GET['age'];
    $file = $_FILES['upload']['name'];
    
    // 直接使用未过滤的输入
    $sql = "INSERT INTO data (email, age) VALUES ('$email', $age)";
    move_uploaded_file($_FILES['upload']['tmp_name'], $file);
}

// ==================== 7. 死循环风险 ====================
function infiniteLoop() {
    // 危险：没有退出条件的循环
    while(true) {
        // 没有 break 或 return
        processData();
    }
}

function recursiveFunction($n) {
    // 危险：没有终止条件的递归
    return recursiveFunction($n + 1);
}

// ==================== 8. 数组越界 ====================
function accessArray() {
    $arr = array(1, 2, 3);
    // 危险：可能越界
    $value = $arr[10];
    
    // 危险：未检查数组键是否存在
    $data = $_GET['data'];
    $result = $data['key'];
}

// ==================== 9. 空指针/空值引用 ====================
function processData() {
    // 危险：未检查变量是否为 null
    $user = getUserById($_GET['id']);
    echo $user['name']; // $user 可能为 null
    
    // 危险：未检查文件是否存在
    $content = file_get_contents($_GET['file']);
    echo $content;
}

// ==================== 10. 条件判断逻辑错误 ====================
function checkPermission($userId) {
    // 危险：逻辑错误，应该是 == 而不是 =
    if ($userId = 1) {
        return true; // 这总是返回 true
    }
    
    // 危险：错误的比较
    if ($userId == "admin") {
        // 应该使用 === 进行严格比较
    }
}

// ==================== 11. 重复数据库查询 ====================
function getUserInfo($userId) {
    // 危险：在循环中重复查询数据库
    for ($i = 0; $i < 100; $i++) {
        $user = mysql_query("SELECT * FROM users WHERE id = $userId");
        // 应该先查询一次，然后在循环中使用
    }
}

// ==================== 12. 大量循环嵌套 ====================
function nestedLoops() {
    // 危险：三层嵌套循环，性能问题
    for ($i = 0; $i < 1000; $i++) {
        for ($j = 0; $j < 1000; $j++) {
            for ($k = 0; $k < 1000; $k++) {
                // 大量计算
                $result = $i * $j * $k;
            }
        }
    }
}

// ==================== 13. 大文件一次性读取 ====================
function readLargeFile() {
    // 危险：一次性读取大文件到内存
    $content = file_get_contents('huge_file.txt'); // 可能几GB的文件
    processContent($content);
}

// ==================== 14. 未使用缓存 ====================
function getExpensiveData() {
    // 危险：每次都执行昂贵的操作
    $data = expensiveDatabaseQuery();
    return $data; // 应该使用缓存
}

// ==================== 15. 变量/函数命名不规范 ====================
// 危险：不符合 PSR 规范
function getUserData() { } // 应该使用驼峰命名
function get_user_data() { } // 应该使用驼峰命名

$userName = ""; // 应该使用 $userName
$user_name = ""; // 不符合 PSR 规范

// ==================== 16. 函数行数过长 ====================
function longFunction() {
    // 危险：函数过长，应该拆分
    $step1 = doStep1();
    $step2 = doStep2();
    $step3 = doStep3();
    $step4 = doStep4();
    $step5 = doStep5();
    $step6 = doStep6();
    $step7 = doStep7();
    $step8 = doStep8();
    $step9 = doStep9();
    $step10 = doStep10();
    $step11 = doStep11();
    $step12 = doStep12();
    $step13 = doStep13();
    $step14 = doStep14();
    $step15 = doStep15();
    $step16 = doStep16();
    $step17 = doStep17();
    $step18 = doStep18();
    $step19 = doStep19();
    $step20 = doStep20();
    // ... 更多代码
    return $result;
}

// ==================== 17. 缺少必要注释 ====================
function complexAlgorithm($data) {
    // 危险：复杂逻辑缺少注释说明
    $result = 0;
    for ($i = 0; $i < count($data); $i++) {
        $result += $data[$i] * $i * 2.5;
        if ($result > 1000) {
            $result = $result / 2;
        }
    }
    return $result;
}

// ==================== 18. 代码冗余 ====================
function redundantCode() {
    // 危险：重复的代码块
    $user = getUserById(1);
    $name = $user['name'];
    $email = $user['email'];
    
    // 重复的代码
    $user2 = getUserById(2);
    $name2 = $user2['name'];
    $email2 = $user2['email'];
    
    // 应该提取为函数
}

// ==================== 19. 语法错误示例 ====================
function syntaxError() {
    // 危险：缺少分号
    $var = "test"
    echo $var;
    
    // 危险：括号不匹配
    if ($condition {
        // 代码
    }
}

// ==================== 20. 返回值异常 ====================
function getValue($key) {
    // 危险：可能返回不同类型的值
    if ($key == 'name') {
        return "John";
    } elseif ($key == 'age') {
        return 25;
    } elseif ($key == 'active') {
        return true;
    }
    // 危险：没有默认返回值
}

// ==================== 21. CSRF 漏洞 ====================
function deleteUser($userId) {
    // 危险：没有 CSRF 保护
    $sql = "DELETE FROM users WHERE id = $userId";
    mysql_query($sql);
}

// ==================== 22. 会话固定攻击 ====================
function login() {
    // 危险：登录后未重新生成 session ID
    $_SESSION['user_id'] = $_POST['user_id'];
    // 应该调用 session_regenerate_id()
}

// ==================== 23. 硬编码敏感信息 ====================
function connectDB() {
    // 危险：硬编码密码
    $password = "mySecretPassword123";
    $conn = mysql_connect("localhost", "root", $password);
}

// ==================== 24. 错误信息泄露 ====================
function handleError() {
    // 危险：向用户显示详细错误信息
    try {
        $result = dangerousOperation();
    } catch (Exception $e) {
        echo "错误: " . $e->getMessage(); // 可能泄露敏感信息
        echo $e->getTraceAsString();
    }
}

// ==================== 25. 不安全的随机数生成 ====================
function generateToken() {
    // 危险：使用不安全的随机数生成器
    $token = rand(1000, 9999); // 应该使用 cryptographically secure random
    return $token;
}

?>
