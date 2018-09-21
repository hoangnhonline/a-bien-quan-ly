<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("example.xls");
?>
<html>
<head>
<style>
table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:12px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align:bottom;
}
table.excel tbody th {
	text-align:center;
	width:20px;
}
table.excel tbody td {
	vertical-align:bottom;
}
table.excel tbody td {
    padding: 0 3px;
	border: 1px solid #EEEEEE;
}
</style>
</head>

<body>
<table>
<?php
$dong = $data->rowcount($sheet_index=0);
$cot = $data->colcount($sheet_index=0); 
//echo $data->val(9,1); //row3, col1
for ($i=1; $i <= $dong; $i++) {
	echo("<tr>");
	for ($j=1; $j<=$cot; $j++) {
		echo "<td>";
		echo $data->val($i,$j);
		echo "</td>";
	}
	echo("</tr>");
}
 ?>
</table>
</body>
</html>
