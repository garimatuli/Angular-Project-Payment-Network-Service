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
		$BankID =  $ndata->BankID;
		$BANumber =  $ndata->BANumber;
	    $ssn =  $ndata->ssn;
		$IsPrimary=$ndata->IsPrimary;
		if ($IsPrimary=='Y')
		{  
        	deliver_response(400,"Primary Bank Account cannot be deleted!",NULL);
		                  
			
		}
		else
		{
			    $query="SELECT count(*)FROM has_additional where BankID='$BankID' and BANumber='$BANumber'";
                $result=mysqli_query($conn, $query);
				$data = mysqli_fetch_array($result, MYSQLI_NUM);
		        if($data[0]==1 )
				{//only one user associated with one bank account
			    $query="DELETE FROM has_additional WHERE ssn='$ssn' and BankID='$BankID' and BANumber='$BANumber' and IsPrimary='$IsPrimary'";
                $result=mysqli_query($conn, $query);
				$query="DELETE FROM bank_account WHERE BankID='$BankID' and BANumber='$BANumber' ";
                $result=mysqli_query($conn, $query);
				}
				else
				{//Multiple user associated with one bank account
				$query="DELETE FROM has_additional WHERE ssn='$ssn' and BankID='$BankID' and BANumber='$BANumber' and IsPrimary='$IsPrimary'";
                $result=mysqli_query($conn, $query);
				}
				 
	            header('Content-Type: application/json');
		        deliver_response(200," Non Primary Bank Account Deleted Successfully",$ssn);
		}
		  
	 
	}
		
		

	   function deliver_response($status,$status_message,$data1 )
{
	header("HTTP/1.1 $status $status_message");
	
	$responses ['status']=$status;
	$responses ['status_message']=$status_message;
	$responses ['ssn']=$data1;
	
	$jason_response=json_encode($responses);
	echo $jason_response;
	
}
	
mysqli_close($conn);	   

?>