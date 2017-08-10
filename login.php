<!DOCTYPE >
<html>
<head>
<style type="text/css">

body {
	color: white;
	background-color: #322419;
	font-size: 14px;
	font-family: Helvetica, Verdana, Arial, sans-serif;
}

p {

	margin: 3px;

	font-size: 16px;

	font-weight: bold;

	font-family: "Lucida Grande", Verdana, Arial, sans-serif;

}

input {
	width: 210px;
	font-size: 18px;
	margin:5px;

}

#box {
	text-align: center;
	color: white;
	border-color: #7a5124;
	border-style: solid;
	border-width: 5px;
	background-color: #912d12;;
	margin-top: -50px;
	margin-left: -125px;
	left: 50%;
	top: 50%;
	position: absolute;
	width: 250px;
}

</style>
</head>
<body>
<div id="box">
	<form method="POST" action="start.php">
	<p>Please Enter the Password</p><input type="password" name="password" id="password" /><br />
		<input type="hidden" value="http://elc.byu.edu/curriculum/" id="current_page" name="current_page" />

	<input type="submit" value="Login" /> <br />


</form>
</div>
</body>
</html>
