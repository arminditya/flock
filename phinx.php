<?php
$url = parse_url(getenv("DATABASE_URL"));

return [
    "paths" => [
        "migrations" => "db/migrations",
        "seeds" => "db/seeds"
    ],
    "environments" => [
        "default_migration_table" => "migrations",
        "default_database" => "default",

        "default" => [
            "adapter" => "pgsql",
            "host" => $url["host"],
            "name" => substr($url["path"], 1),
            "user" => $url["user"],
            "pass" => $url["pass"],
            "port" => $url["port"],
            "charset" => "utf8",
            "collation" => "utf8_unicode_ci"
        ],

        "local" => [
            "adapter" => "pgsql",
            "host" => "localhost",
            "name" => "flock",
            "user" => "postgres",
            "pass" => "",
            "port" => "5432",
            "charset" => "utf8",
            "collation" => "utf8_unicode_ci"
        ]
    ]
];
