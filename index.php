<?php 

//include database connection details
include('db.php');

//redirect to real link if URL is set
if (!empty($_GET['url'])) {
	$redirect = mysql_fetch_assoc(mysql_query("SELECT url_link FROM urls WHERE url_short = '".addslashes($_GET['url'])."'"));
	$redirect = "http://".str_replace("http://","",$redirect[url_link]);
	header('HTTP/1.1 301 Moved Permanently');  
	header("Location: ".$redirect);  
}
//

//insert new url
if ($_POST['url']) {

//get random string for URL and add http:// if not already there
$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);

mysql_query("INSERT INTO urls (url_link, url_short, url_ip, url_date) VALUES

	(
	'".addslashes($_POST['url'])."',
	'".$short."',
	'".$_SERVER['REMOTE_ADDR']."',
	'".time()."'
	)

");

$redirect = "?s=$short";
header('Location: '.$redirect); die;

}
//

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>johnboy's URL shrinker</title>
<style type="text/css">
<!--
body {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 25px;
	text-align: center;
}
input {
	font-size: 20px;
	padding: 10px;
}
h2 {
	font-size: 16px;
	margin: 0px;
	padding: 0px;
}
h1 {
	margin: 0px;
	padding: 0px;
	font-size: 35px;
	color: #009999;
}
form {
	margin: 0px;
	padding: 0px;
}
h3 {
	font-size: 13px;
	color: #666666;
	font-weight: normal;
}
h3 a {
	color: #006699;
	text-decoration: none;
}
table {
	font-size: 13px;
	background-color: #EBEBEB;
	border: 1px solid #CCCCCC;
}
-->
</style>
</head>

<body>


<h1> URL to shrink: </h1>
<form id="form1" name="form1" method="post" action="">
  <input name="url" type="text" id="url" value="http://" size="75" />
  <input type="submit" name="Submit" value="Go" />
</form>

<!--if form was just posted-->
<?php if (!empty($_GET['s'])) { ?>
<br />
<h2>Here's the short URL: <a href="<?php echo $server_name; ?><?php echo $_GET['s']; ?>" target="_blank"><?php echo $server_name; ?><?php echo $_GET['s']; ?></a></h2>
<?php } ?>
<!---->

<br />
<br />

</body>
</html>