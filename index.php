
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” 
http://www.w3.org/TR/xhtml/DTD/xhtml-strict.dtd>
<html>
<head>
<title>NYERI LAW COURTS</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
window.onload = function()
{
document.getElementByID("log").setAtribute('autocomplete','off');
</script>

</head>
<body onLoad="renderTime();" oncontextmenu="return false">

<div id="header">
THE NYERI LAW COURTS ONLINE CASE FILE MANAGEMENT SYSTEM
</div>
<div id="top">
   <div id="clockDisplay" class="clock">
   </div>
   <div id="session">
   </div>
   <div id="logout"></div>
</div>
<div id="nav">

<ul>
  <li><a class="active" href="#">Home</a></li>
<li><a href="contacts.php">Contacts</a></li>
</ul>

</div>

<div id="container">

<div id="main">
<img src="images/nyeri lc.jpg" height="99%" width="99%" border="1" alt="Nyeri Law Courts"/>
</div>

<div id="side">
<fieldset><legend>Login in to view specific registry</legend>
<form action="login.php" method="post"><table>
<tr><td>Registry:</td>  <td><select name="reg"><option value=''>--Select Registry--</option>
                  	 		<option value="CM CHILDREN">CM'S Children</option>
  							<option value="CM CIVIL">CM'S Civil</option>
  							<option value="CM CRIMINAL">CM'S Criminal</option>
  							<option value="KADHI">Kadhi</option>
							<option value="HC PROBATE">HC Probate</option>
							<option value="HC CIVIL">HC Civil</option>
							<option value="HC CRIMINAL">HC Criminal</option>
							<option value="ELRC">ELRC</option>
				</select> </td></tr>
<tr><td>Username:</td> <td><input type="text" name="username" id="log" placeholder="Enter Your Username"  required /></td></tr>
<tr><td>Password:</td> <td><input type="password" name="pass" id="log" placeholder="Enter Your Password"  required/></td></tr>
<tr> <td><input type="reset" name="submit" value="Clear" id="submit"></td> <td><input type="submit" name="submit" value="Log In" id="submit"></td>				
</tr></table></form>
</fieldset>
<img src="images/court.png" width="320" height="312"/>
</div>

</div>

<div id="footer">
&copy;Nyeri Law Courts:<?php echo date("Y") ?>

</body>
</html>
