
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
		$id =  $ndata->id;
		$identifier =  $ndata->identifier;
	    $ssn =  $ndata->ssn;
	/*	
		$data="SELECT count( * )FROM `electronic_address` WHERE  ssn='$ssn' and type='P'" ;
		$result= mysqli_query($conn, $data);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		
		if($data[0]<2)
		
		{
			deliver_response(400,"Deletion Aborted",NULL);
		}
		else
		{ */
			$data="SELECT count(*)FROM send_transaction WHERE  identifier='$identifier' " ;
			$result= mysqli_query($conn, $data);
		    $data = mysqli_fetch_array($result, MYSQLI_NUM);
			
			
			if($data[0]>0 )
			{
				deliver_response(400,"Phone number cannot be deleted! Transactions exists for this number",NULL);
			}
			else
			{
				
			$data="SELECT count(*)FROM from_transaction WHERE  identifier='$identifier' " ;
			$result= mysqli_query($conn, $data);
		    $data = mysqli_fetch_array($result, MYSQLI_NUM);
			
			
			if($data[0]>0 )
			{
				deliver_response(400,"Phone number cannot be deleted! Transactions exists for this number",NULL);
			}
			else
			{
				$query="DELETE FROM `electronic_address` WHERE ssn='$ssn' and identifier='$identifier' and id='$id'";
                $result=mysqli_query($conn, $query);
	            header('Content-Type: application/json');
		        deliver_response(200," Number  Deleted Successfully",$ssn);
				
			}
			}
			
			
		// }
		
	}
	
	 function deliver_response($status,$status_message,$data)
{
	header("HTTP/1.1 $status $status_message");
	
	$responses ['status']=$status;
	$responses ['status_message']=$status_message;
	$responses ['ssn ']=$data;
	
	
	
	$jason_response=json_encode($responses);
	echo $jason_response;
	
}
	
mysqli_close($conn);	   

?>