<?php session_start();
    
    if(isset($_POST['request_login']) && isset($_POST['request_password']))
    {	
		include("base.php");
			$login=$_POST['request_login'];
			$password=$_POST['request_password'];
			$result=pg_query($link, "SELECT name FROM ".'"User"'."WHERE name = '".$login."' AND password = '".$password."'");
			$row = pg_fetch_row($result);
			if (!$row) {
				$_SESSION['error'] = 'Ошибка';
				header("location: adminin.php");
			} else {
				$result=pg_query($link, "SELECT name FROM ".'"User"'."WHERE name = '".$login."' AND password = '".$password."'");
				while ($row = pg_fetch_row($result)) {
					$_SESSION['login'] = $row['0'];
					header("location: admindo.php");
			
			}
		}
    }
?>