<?php
$host = "localhost";
$dbname = "blog_article";
$username = "";
$password = "";

try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
};
?>