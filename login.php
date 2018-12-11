<?php

header("Content-Tye:application/json");


if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: *");
    //If required
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");         
 
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
    exit(0);
}

header("Content-Tye:application/json");

// Connect to database
$conn = mysqli_connect('localhost','student','root','student');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$data = json_decode(file_get_contents("php://input"));

if ( $_SERVER['REQUEST_METHOD'] == 'GET')
	{
		global $conn;
		
		$identifier = mysqli_real_escape_string($conn, $_REQUEST['identifier']);
		$query="SELECT ssn FROM electronic_address where identifier='$identifier'" ;
		$result= mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		if($data[0] > 1)
		{
			$name="SELECT name FROM user_account a ,electronic_address e where a.ssn=e.ssn and identifier='$identifier'" ;
		$result= mysqli_query($conn, $name);
		$password = mysqli_real_escape_string($conn, $_REQUEST['password']);
		$query="SELECT a.ssn  FROM user_account a ,electronic_address e where a.ssn=e.ssn and identifier='$identifier' and a.password='$password'" ;
		$result1= mysqli_query($conn, $query);
		$data1 = mysqli_fetch_array($result1, MYSQLI_NUM);
		if($data1[0] > 1)
		{   $query="SELECT a.ssn  , name FROM user_account a ,electronic_address e where a.ssn=e.ssn and identifier='$identifier' and a.password='$password'" ;
               if ($result = mysqli_query($conn, $query)) 
			   {

                              /* fetch associative array */
                              while ($row = mysqli_fetch_assoc($result)) 
	                      {
       
		                         deliver_response(200,"User Name and password matched " , $row["ssn"] , $row["name"]);
                          }
                }

                                  /* free result set */
                           mysqli_free_result($result);
	   }
	
	
		 	
		
		else
		{ deliver_response(400,"Email/Phone or Password did not match!",NULL,NULL);	
		
		}
	
		}

       else
	   {
		   deliver_response(400,"Email/Phone does not exist! Please Register.",NULL,NULL);
		   
	   }
	   }
	   
	   function deliver_response($status,$status_message,$data1 ,$data2)
{
	header("HTTP/1.1 $status $status_message");
	
	$responses ['status']=$status;
	$responses ['status_message']=$status_message;
	$responses ['ssn']=$data1;
	$responses ['name']=$data2;
	
	$jason_response=json_encode($responses);
	echo $jason_response;
	
}
	
mysqli_close($conn);	   

?>