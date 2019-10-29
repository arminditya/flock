<?php
$conn = pg_connect(getenv("DATABASE_URL"));
$result = pg_query($conn, "select * from users");
var_dump(pg_fetch_all($result));
?>
