<?php
	$host     = "localhost";
	$user     = "root";
	$password = "";
	$database = "blamel"; // LOCAL 


	$mysqli = new mysqli($host, $user, $password, $database);
    
	mysqli_set_charset($mysqli, 'utf8');

	/* check connection */
	if ($mysqli->connect_errno) {
		echo "Connect failed " . $mysqli->connect_error;
		exit();
	}
?>

<?php
	if (!function_exists("GetSQLValueString")) {
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
		{
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

			switch ($theType) {
				case "text":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;
				case "long":
				case "int":
					$theValue = ($theValue != "") ? intval($theValue) : "NULL";
					break;
				case "double":
					$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
					break;
				case "date":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;
				case "defined":
					$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
					break;
			}
			return $theValue;
		}
	}
?>


<?php
	// Quote variable to make safe
	if (!function_exists("quote_smart")) {
		function quote_smart($value)
		{
			// Stripslashes
			if (get_magic_quotes_gpc()) {
				$value = stripslashes($value);
			}
			// Quote if not integer
			if (!is_numeric($value)) {
				$value = "'" . mysql_real_escape_string($value) . "'";
			}
			return $value;
		}
	}
?>


<?php
	function aXml($consulta, $conexion)	{
		$q = mysql_query($consulta, $conexion);
		$returm = "<resultado>";
		while ($r = mysql_fetch_row($q)) {
			set_time_limit(3000);
			$returm .= "<res>";
			$i = 0;
			while ($i < mysql_num_fields($q)) {
				$returm .= "<" . mysql_field_name($q, $i) . ">" . htmlspecialchars($r[$i]) . "</" . mysql_field_name($q, $i) . ">
				";
				$i++;
			}
			$returm .= "</res>";
		}
		$returm .= "</resultado>";
		return $returm;
	}
?>
