
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


header("Content-Type:application/json");

// Connect to database
$conn = mysqli_connect('localhost','student','root','student');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$data = json_decode(file_get_contents("php://input"));


if ( $_SERVER['REQUEST_METHOD'] == 'GET')
	{
		global $conn;
		$ssn = mysqli_real_escape_string($conn, $_REQUEST['ssn']);
		$query="SELECT ssn FROM user_account where ssn='$ssn'" ;
		$result= mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		
		if($data[0] > 1)
		{
			$sdate = mysqli_real_escape_string($conn, $_REQUEST['sdate']);
			$edate = mysqli_real_escape_string($conn, $_REQUEST['edate']);
			$query="SELECT sum(amount) FROM send_transaction where ssn='$ssn' and date BETWEEN '$sdate' and '$edate' " ;
		    $result= mysqli_query($conn, $query);
			$data = mysqli_fetch_array($result, MYSQLI_NUM);
			$a=$data[0];
			$query="SELECT sum(amount) FROM request_transaction where ssn='$ssn' and date BETWEEN '$sdate' and '$edate' " ;
		    $result= mysqli_query($conn, $query);
			$data = mysqli_fetch_array($result, MYSQLI_NUM);
			$b=$data[0];
			 if( $a==NULL)
			{
				
                   $a=0.00;
			}		   if( $b==NULL)
			{
				
                  $b=0.00;
			}
			
			deliver_response(200,"Total Transactions ",$a,$b);
			
		
	        
		}
		else
		{
			deliver_response(400,"SSN Not found ",NULL,NULL);
	     	
		}
		
	}	

	   function deliver_response($status,$status_message,$data,$data1)
{
	header("HTTP/1.1 $status $status_message");
	
	$responses ['status']=$status;
	$responses ['status_message']=$status_message;
	$responses ['totalAmountSent']=$data;
	$responses ['totalAmountReceived']=$data1;
	
	
	
	$jason_response=json_encode($responses);
	echo $jason_response;
	
}
	
mysqli_close($conn);	   

?>