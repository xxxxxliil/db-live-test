#!/usr/bin/env php
<?php


/*
  by xxxxxliil@github
  db-live-test.php released under MIT License.

*/

$longopts = array(
    "dsn:",
    "help",
    "password:",
    "user:",
    "version",
);

$optind = null;


$shortopts  = "";
$shortopts .= "d:";
$shortopts .= "h";
$shortopts .= "p:";
$shortopts .= "u:";
$shortopts .= "V";

$cmd_options = getopt($shortopts, $longopts, $optind);
$pos_args = array_slice($argv, $optind);



function check_repeated_option($option1, $option2) {
    if (isset($option1) && isset($option2)) {
        echo("You can't use long option and short option at the same time.\n");
        exit(2);
    } elseif (isset($option1)){
        return $option1;
    } elseif (isset($option2)){
        return $option2;
    } else {
        return null;
    }
}



if (isset($cmd_options["h"]) || isset($cmd_options["help"]) || count($cmd_options) == 0) {
    echo <<<EOF
db-online-test: test your database is online

usage: db-online-test [options]

 -h, --help                  display this help
 -d, --dsn                   set the Data Source Name info
 -p, --password              database password
 -u, --user                  database user
 -V, --version               display version


EOF;
    if (count($cmd_options) != 0) {
        exit(0);
    } else {
        //EX_USAGE
        exit(64);
    }
}
if (isset($cmd_options["V"]) || isset($cmd_options["version"])) {
    exit("db-live-test 0.0.1". "\n");
}


$db_options = array(
    "dsn" => check_repeated_option($cmd_options["d"] ?? null, $cmd_options["dsn"] ?? null),
    "password" => check_repeated_option($cmd_options["p"] ?? null, $cmd_options["password"] ?? null),
    "user" => check_repeated_option($cmd_options["u"] ?? null, $cmd_options["user"] ?? null),
);
if (! isset($db_options["dsn"])) {
    echo("Error: dsn is not set\n");
    exit(64);
} elseif (! isset($db_options["user"])) {
    echo("Error:user is not set\n");
    exit(64);
} elseif (! isset($db_options["password"])) {
    echo("Warning: password is not set\n");
}



try {
    $dbh = new PDO($db_options["dsn"], $db_options["user"], $db_options["password"]);
} catch (PDOException $error) {
    echo('Connection failed: ' . $error->getMessage() . "\n");
    exit(75);
}
?>
