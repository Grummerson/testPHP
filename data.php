<?php
require_once 'db.php';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Нет подключения. " . $e->getMessage());
}

$dataUrl='https://jsonplaceholder.typicode.com/posts';
$request=file_get_contents($dataUrl);
$data=json_decode($request,true);
$countPost=0;
foreach ($data as $value)
{
    $query = $pdo -> prepare("INSERT INTO post (userId, id, title, text) VALUES (?, ?, ?, ?)");
    $query -> bindParam(1,$value['userId'],PDO::PARAM_INT);
    $query -> bindParam(2,$value['id'],PDO::PARAM_INT);
    $query -> bindParam(3,$value['title'],PDO::PARAM_STR);
    $query -> bindParam(4,$value['body'],PDO::PARAM_STR);
    $query -> execute();
    $countPost+=1;
}

$dataUrl='https://jsonplaceholder.typicode.com/comments';
$request=file_get_contents($dataUrl);
$data=json_decode($request,true);
$countComment=0;
foreach ($data as $value)
{
    $query = $pdo -> prepare("INSERT INTO comment (postID, id, name, email,text) VALUES (?, ?, ?, ?, ?)");
    $query -> bindParam(1,$value['postId'],PDO::PARAM_INT);
    $query -> bindParam(2,$value['id'],PDO::PARAM_INT);
    $query -> bindParam(3,$value['name'],PDO::PARAM_STR);
    $query -> bindParam(4,$value['email'],PDO::PARAM_STR);
    $query -> bindParam(5,$value['body'],PDO::PARAM_STR);
    $query -> execute();
    $countComment+=1;
}
echo "Загружено $countPost записей и $countComment комментариев";
