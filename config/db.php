<?php
ini_set('display_errors', 1);

require_once('../lib/adodb5/adodb.inc.php');
require_once('../lib/adodb5/adodb-active-record.inc.php');

$host = "localhost";
$username = "censusmis";
$password = "censusmis";
$dbname = "censusmis";

$db_type = 'pdo';

try {
    $db = ADOnewConnection($db_type);

    $dsnString = 'host=' . $host . ';dbname=' . $dbname . ';';
    $db->pconnect('mysql:' . $dsnString, $username, $password);
} catch (Exception $e) {
    echo $e->getMessage();
}

$db->SetFetchMode(ADODB_FETCH_ASSOC);
//$db->logSQL();

$ADODB_ASSOC_CASE = 0;
$ADODB_CACHE_DIR = 'cache';


ADOdb_Active_Record::SetDatabaseAdapter($db);

//echo '<pre>';
//print_r($db);

