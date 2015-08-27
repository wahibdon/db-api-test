<?
require_once('lib/Dropbox/autoload.php');
use \Dropbox as dbx;
$appInfo = dbx\AppInfo::loadFromJsonFile("app-info.json");
$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");