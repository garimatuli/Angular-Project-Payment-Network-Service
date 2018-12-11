
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
$ndata = array();
$ndata =$data; 


if ( $_SERVER['REQUEST_METHOD'] == 'POST')
	{
		global $conn;
		$ssn =  $ndata->ssn;
		$query="SELECT ssn FROM user_account where ssn='$ssn'" ;
		$result= mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		
		if($data[0] > 1)
		{
		
		$password =  $ndata->password;
	
	   $ssn =  $ndata->ssn;
	   $name = $ndata->name;
   
	    $query="UPDATE user_account SET name='$name' , password='$password' WHERE ssn='$ssn'";
	     $result=mysqli_query($conn, $query);
	      header('Content-Type: application/json');
		  deliver_response(200," Detailes Modified to ",$name,$password);
		  
	 
		}
		else
		{
			deliver_response(400,"Invalid SSN ",NULL,NULL);
	     	
		}
		
		}

	   function deliver_response($status,$status_message,$data1 ,$data2)
{
	header("HTTP/1.1 $status $status_message");
	
	$responses ['status']=$status;
	$responses ['status_message']=$status_message;
	$responses ['name']=$data1;
	$responses ['password']=$data2;
	
	$jason_response=json_encode($responses);
	echo $jason_response;
	
}
	
mysqli_close($conn);	   

?>