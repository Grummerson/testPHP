<?php
require_once 'db.php';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Нет подключения. " . $e->getMessage());
}

try{
    $sql = "DROP TABLE comment";
    $pdo->exec($sql);
    $sql = "DROP TABLE post";
    $pdo->exec($sql);
    $sql = "CREATE TABLE  post ( userID INT NOT NULL ,
                                 id INT NOT NULL UNIQUE ,
                                 title VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
                                 text VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                                 PRIMARY KEY (id))";
    $pdo->exec($sql);
    echo "Таблица post успешно создана.\n";
    $sql = "CREATE TABLE  comment ( postID INT NOT NULL ,
                                    id INT NOT NULL UNIQUE ,
                                    name VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
                                    email VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                                    text VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                                    PRIMARY KEY (id),
                                    CONSTRAINT FOREIGN KEY (postID)  REFERENCES post(id))";
    $pdo->exec($sql);
    echo "Таблица comment успешно создана.";
} catch(PDOException $e){
    die("ERROR: Не удалось выполнить $sql. " . $e->getMessage());
}
