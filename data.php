<?php
	
	$con = mysql_connect('10.204.5.211', 'root', 'fengxi');
	mysql_select_db("di", $con);

	//Get the test_case_name in a specified table
	$sql_test_case = "SELECT distinct test_case_name from cubie2_int_math_bench_test";
	$result = mysql_query($sql_test_case, $con);
	$test_case = array();
	while($r = mysql_fetch_array($result))
	{
		$test_case[] = $r['test_case_name'];
	}	
	$test_case_num = count($test_case);
	#for($i=0; $i < $test_case_num; $i++){
	$result_array = array();	
	for($i=0; $i < $test_case_num; $i++){

		$sql = "SELECT changelist, min_value, avg_value from "."cubie2_int_math_bench_test "."where test_case_name="."'".$test_case[$i]."'";
		$result = mysql_query($sql, $con);
		$rows = array();
		$rows1 = array();
		$changelist = array();
		$test_case_name = array();
		$rows1['name'] = 'avg_value';
		$rows['name'] = 'min_value';
		while($r = mysql_fetch_array($result))
		{
			$rows['data'][] = intval($r['min_value']);
			$rows1['data'][] = intval($r['avg_value']);
		    $changelist['changelist'][] = $r['changelist'];
			$test_case_name['test_case_name'] = $test_case[$i];
		}
		#print_r($rows);
		$test_info = array();
		array_push($test_info, $test_case_name);
		array_push($test_info, $changelist);
		array_push($test_info, $rows);
		array_push($test_info, $rows1);
		#print json_encode($test_info);
		array_push($result_array, $test_info);
	}
	print json_encode($result_array);

	mysql_close($con);

?>
