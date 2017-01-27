<?php

//////sybase connection///////////////


//connect to sybase database
$server_conn = mssql_connect(
		'host',
		'username',
		'password');

if (!$server_conn)
	die('sybase connection failed');
	else
	{
		//connect to the database
		$db_conn = mssql_select_db('database', $server_conn);


		if($db_conn){
				
		 // create SQL 
		  $sql = "select * from table_name WHERE num= '10003     '";
		  // excecute SQL statement
		  $result = mssql_query($sql);
		  	
		  // die if SQL statement failed
		  if (!$result) {
		  	  die('error: ' . mssql_get_last_message());
		  
		  }else{
		  	
		  
		  	  $data_array=array();
		      while ($row = mssql_fetch_assoc($result)) {
		      	
        			foreach($row as $key=>$value){
        				
        				$data_array[$key]=$value;
        				
        			}//foreach($row as $key=>$value){
        		 		
   			 }// while ($row = mssql_fetch_assoc($query)) {
   			 
		  }//else

		}//else
	}//else

	// close mssql connection
	mssql_close($server_conn);
	
	//echo print_r($data_array,true);
///////////////////////////////////////////

/////Generate word doc ///////////////////////
$filename = "/var/www/html/cms_git/test_template.rtf";


function textreplace($needle,$haystack){
	
	
	foreach($needle as $search => $value){
		//special character « 0171  » 0187
		//database field name starts with « and ends with »
		$fieldName = "\u171\'ab".$search."\u187\'bb";
		$haystack=str_replace("$fieldName",$value,$haystack);
	
	}
	//echo  $newhaystack;
	return $haystack;

}


$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);

//assign the variables to the array

$merge=array();

//REPLACE INFO
//'TESTNO, TESTdate, TestWord are the fieldnames in the rtf template.'
//$data_array[] is the data from sybase 
$merge['TESTNo']=$data_array['num'];
$merge['TESTdate']=$data_array['date'];
$merge['TestWord']=$data_array['num'];

//get the rtf file contents
$haystack=textreplace($merge,$contents);

//generate a rtf file here.
//header("Content-Type: application/vnd.ms-excel");
//header('Content-Disposition: attachment; filename="MyMsDocFile.doc');
Header('Content-Type: application/rtf');
Header("Content-disposition: inline; filename=Filename.rtf");
echo $haystack;
