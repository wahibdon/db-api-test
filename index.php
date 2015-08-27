<?
require_once('lib/Dropbox/autoload.php');
use \Dropbox as dbx;
if ($_FILES['SelectedFile']){
	$tmp = $_FILES['SelectedFile']['tmp_name'];
	$file = $_FILES['SelectedFile']['name'];
	
	$appInfo = dbx\AppInfo::loadFromJsonFile("app-info.json");
	$accessToken = "PR7lZnGybKkAAAAAAAAXYa_wAj7RAns-RD6uHMTbsRP4BmKsgNtjeSUqrgc8BHJ6";

	$dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");

	$f = fopen($tmp, "r");
	$result = $dbxClient->uploadFile("/$file", dbx\WriteMode::add(), $f);
	fclose($f);
	print_r($result);
	$message = "A new file has been uploaded and can be viewed at https://www.dropbox.com/home/Apps/Ott%20Clients/$file .\n
	File information:\n
	Name: {$_POST['first']} {$_POST['last']}\n
	Email: {$_POST['email']}\n
	Descrption: {$_POST['description']}
	";
	mail('whibdon@ottcom.com', 'New File on Dropbox', $message);
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>file upload test</title>
<script type="text/javascript">
function upload(){
	var file=document.getElementById('file');
	if (file.files.length < 1)
		return;
	var data=new FormData();
	data.append("SelectedFile", file.files[0]);
	data.append("first", document.getElementById('first').value);
	data.append("last", document.getElementById('last').value);
	data.append("email", document.getElementById('email').value);
	data.append("description", document.getElementById('description').value);
	var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			document.getElementsByClassName('progressBox')[0].style.opacity = "0";
			var formElements = document.getElementsByClassName('form');
			for(var i=0; i<formElements.length; i++)
				formElements[i].value = "";
			document.getElementById('filename').innerHTML = "";
		}
	}
	request.upload.addEventListener('progress', function(e){
		var progress = document.getElementsByClassName('progress')[0];
		progress.innerHTML = Number(e.loaded/1048576).toFixed(2)+"MB/"+Number(e.total/1048576).toFixed(2)+"MB";
		var progressBar = document.getElementsByClassName('progressBar')[0];
		progressBar.style.width = (e.loaded/e.total)*100+"%";
		var fileName = document.getElementsByClassName('fileName')[0];
		fileName.innerHTML = file.files[0].name;
	})
	request.open('post', 'index.php');
	request.send(data);
	document.getElementsByClassName('progressBox')[0].style.opacity = "1";
}
window.addEventListener('load', function(){
	document.getElementById('submit').addEventListener('mouseup', upload);
	document.getElementById('file').addEventListener('change', function(){
		document.getElementById('filename').innerHTML = this.files[0].name;
	});
})
</script>
<style type="text/css">
* {
	position: relative;
	margin: 0; 
	padding: 0;
}
body{
	font-family: 'Arial';
	background-color: #eee;
}
#uploadBox{
	width: 400px;
	margin: 30px auto 0;
	text-align: center;
}
#syntheticButton {
	position: relative;
	overflow: hidden;
	color: #fff;
	border-radius: 5px;
	width: 144px;
	height: 46px;
	font-size: 16px;
	font-weight: 600;
	text-align: center;
	line-height: 46px;
	background-color: #3d7dda;
	background-image: linear-gradient(rgba(255, 255, 255, 0.247059) 0%, rgba(0, 0, 0, 0) 50.476190476190474%, rgba(0, 0, 0, 0.2) 100%);
	margin: 0 auto 10px;
}
input, textarea {
	box-sizing: border-box;
	border: 1px solid #999;
}
input[type=text]{
	width: 200px;
	display: block;
	float: left;
}
input[type=text]:first-child {
    width: 190px;
    margin-right: 10px;
}
input[type=email], textarea{
	width: 100%;
	display: block;
}
textarea {
	height: 50px;
}
#syntheticButton input {
	position: absolute;
	top: 0;
	right: 0;
	cursor: pointer;
	opacity: 0;
	height: 100%;
}
.progressBox{
	opacity: 0;
	width: 100%;
	border-radius: 5px;
	background-color: #ddd;
	padding: 5px;
	transition: all 1s;

}
.progress{
	color: #fff;
	text-shadow: 0px 0px 5px black;
	height: 20px;
	line-height: 20px;
	margin-top: -21px;
	border: 1px solid #999;
	box-sizing: content-box;
}
.progressBar {
	width: 0;
	height: 20px;;
	background-color: #3d7dda;
	background-image: linear-gradient(rgba(255, 255, 255, 0.247059) 0%, rgba(0, 0, 0, 0) 50.476190476190474%, rgba(0, 0, 0, 0.2) 100%);
}
footer{
	position: absolute;
	bottom:-62px;
	width: 100%;
}
</style>
</head>
<body>
	<div id="uploadBox">
		<input class="form" type="text" placeholder="First Name" id="first">
		<input class="form" type="text" placeholder="Last Name" id="last">
		<input class="form" type="email" placeholder="Email Address" id="email">
		<textarea class="form" placeholder="File Description" id="description"></textarea>
		<div id="syntheticButton">
			Select File
			<input class="form" id="file" type="file" name="file" />
		</div>
		<p id="filename"></p>
		<button id="submit">Upload File</button>
		<div class="progressBox">
			<p class="fileName">&nbsp;</p>
			<div class="progressBar"></div>
			<p class="progress"></p>
		</div>
	</div>
</body>
</html>