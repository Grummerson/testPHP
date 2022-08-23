<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        table, th, td {border: 2px solid black;}
    </style>
</head>
<body>
<form action="" method="GET">
    <input type="text" name="insert" />
    <input type="submit" name="submit" value="Search" />
</form>
<?php
require_once 'db.php';
try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Нет подключения. " . $e->getMessage());
}

if(isset($_GET['insert'])) {
    $insert = $_GET['insert'];
    if(strlen($insert) >= 3){
        $query = $pdo -> prepare("SELECT p.title, c.text 
                                            FROM post p 
                                            INNER JOIN comment c ON c.postid = p.id 
                                            WHERE c.text LIKE ?");
        $insert = "%" . $insert . "%";
        $query -> bindParam(1, $insert, PDO::PARAM_STR);
        $query -> execute();
        $arr = $query -> fetchAll();
    }
    else {
        echo "Min search length is 3 characters"; }

    if (isset($arr)){
        if (count($arr) > 0){
            echo "<h2>Search Results</h2>";
            echo "<table style=\"width:100%\">
                      <tr>
                        <th>Post</th>
                        <th>Comment</th>
                    </tr>";
            foreach ($arr as $value) {
                echo("<tr><td>{$value['title']}</td><td>{$value['text']}</td></tr>"); }
        }
        else {
            echo "No results found";}
        echo "</table>";
    }
}
?>
</body>
</html>