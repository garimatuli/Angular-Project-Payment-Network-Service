
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
$a=array();
$b=array();
$c=array();
$d=array();
if ( $_SERVER['REQUEST_METHOD'] == 'POST')
	{
		global $conn;
		$identifier =  $ndata->identifier;
	    
		$query="SELECT ssn FROM electronic_address where identifier='$identifier'" ;
		$result= mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		if($data[0] > 1)
		{   $sidentifier =  $ndata->sidentifier;
	           if ( $sidentifier != $identifier)
			   {
	       //   if identifier is valid 
           	 $ssn =  $ndata->ssn;
		     $amount =  $ndata->amount;
			 $memo =  $ndata->memo;
			 
			 $query="SELECT Balance FROM user_account WHERE ssn='$ssn' " ;
		     $result= mysqli_query($conn, $query);
			 $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
			 $c=$data['Balance'];
			 $query="SELECT Balance,u.ssn as SSN FROM user_account u , electronic_address e where u.ssn = e.ssn and e.identifier='$identifier'" ;
		     $result= mysqli_query($conn, $query);
			 $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
			 $a=$data['Balance'];
			 $b=$data['SSN'];
			 $Rbalance = $a + $amount;
			  $Sbalance=$c - $amount;
			  
			  
			 $query="INSERT INTO send_transaction (Amount,Date,Memo,SSN,Identifier ) VALUES ('$amount',NOW(),'$memo','$ssn','$identifier')";
		     $result=mysqli_query($conn, $query);
			 if($c >= $amount)
			 {
		     $query="UPDATE user_account SET Balance='$Sbalance' WHERE ssn='$ssn'";
             $result=mysqli_query($conn, $query);
			 }
			 $query="UPDATE user_account SET Balance='$Rbalance' WHERE ssn='$b'";
             $result=mysqli_query($conn, $query);
			 $query="INSERT INTO request_transaction (Amount,Date , Memo, SSN ) VALUES ('$amount',NOW(),'$memo', '$b')";
		     $result=mysqli_query($conn, $query);
			 $query="SELECT MAX(RTid) as RTid FROM request_transaction where ssn='$b'";
		     $result=mysqli_query($conn, $query);
			 $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
			 $c=$data['RTid'];
			 $query="INSERT INTO from_transaction(RTid,Identifier ) VALUES ('$c','$sidentifier')";
		     $result=mysqli_query($conn, $query);
	          header('Content-Type: application/json');
		      deliver_response(200," Data Inserted ",$ssn);    
			   }
			   else{
                  		  deliver_response(400,"TIJN does not support transaction with self account!",NULL); 
			   }
		}
		else
		{
			deliver_response(400,"No Transaction allowed! User not registered with TIJN",NULL);
        
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