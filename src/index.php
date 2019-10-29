<?php

$db = parse_url(getenv("DATABASE_URL"));

try{
    $pdo = new PDO("pgsql:" . sprintf(
        "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
    ));

    $sql = "SELECT * FROM users";
    $query = $pdo->prepare($sql);
    $rows = $query->execute();

    print_r($rows->fetch());
} catch(PDOException $e) {
    print_r($e->getMessage());
}

?>
