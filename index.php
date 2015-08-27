<?
require_once('lib/Dropbox/autoload.php');
use \Dropbox as dbx;
$appInfo = dbx\AppInfo::loadFromJsonFile("app-info.json");
$accessToken = "PR7lZnGybKkAAAAAAAAXYa_wAj7RAns-RD6uHMTbsRP4BmKsgNtjeSUqrgc8BHJ6";

$f = fopen("app-info.json", "rb");
$result = $dbxClient->uploadFile("/working-draft.txt", dbx\WriteMode::add(), $f);
fclose($f);
print_r($result);