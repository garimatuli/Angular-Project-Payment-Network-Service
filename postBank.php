
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
		$IsPrimary =$ndata->IsPrimary;
		$query="SELECT count(*) FROM has_additional where ssn='$ssn' " ;
		$result= mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		if($data[0]>0 )
		{
			//Not first account
			$query="SELECT  * FROM has_additional where ssn='$ssn' and BankID='$BankID' and BANumber='$BANumber' " ;
		    $result= mysqli_query($conn, $query);
		    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
			if($ssn==$data['SSN'] &&  $BANumber==$data['BANumber'] && $BankID==$data['BankID'] )
		  { // If same Bank Details are Added
			  exit (deliver_response(400,"Bank Details already exists!",$ssn));
			  
		  }
		
		
		if ($IsPrimary =='Y')
			
		{  //Not first account with flag Y and Not existing details.
        	$query="INSERT INTO bank_account ( bankid,banumber ) VALUES ('$BankID','$BANumber')";
	        $result=mysqli_query($conn, $query);
			$query="UPDATE has_additional SET IsPrimary='N'  WHERE ssn='$ssn' and IsPrimary='Y'";
            $result=mysqli_query($conn, $query);
			$query="UPDATE user_account SET BankID='$BankID',BANumber='$BANumber'  WHERE ssn='$ssn'";
            $result=mysqli_query($conn, $query);
			$query="INSERT INTO has_additional ( ssn,bankid,banumber,isprimary ) VALUES ('$ssn','$BankID','$BANumber','$IsPrimary')";
	        $result=mysqli_query($conn, $query);
	        header('Content-Type: application/json');
		    deliver_response(200," Primary BANK ACCOUNT Added ",$ssn);
		  
			
		}
		else if ($IsPrimary =='N')
		{//with flag N
			
		
		  
			//Not first account with flag N and without existing details.
			$query="INSERT INTO bank_account ( bankid,banumber ) VALUES ('$BankID','$BANumber')";
	        $result=mysqli_query($conn, $query);
			$query="INSERT INTO has_additional ( ssn,bankid,banumber,isprimary ) VALUES ('$ssn','$BankID','$BANumber','$IsPrimary')";
	        $result=mysqli_query($conn, $query);
	        header('Content-Type: application/json');
		    deliver_response(200," BANK ACCOUNT Added ",$ssn);
		  
		}
		}
		else
		{
			$query="SELECT count(*) FROM user_account where ssn='$ssn' " ;
		    $result= mysqli_query($conn, $query);
			$data = mysqli_fetch_array($result, MYSQLI_NUM);
		    if($data[0]>0 )
			{//existing user account /ssn
			//First Bank Account
			if ($IsPrimary=='Y')
		{  
        	$query="INSERT INTO bank_account ( bankid,banumber ) VALUES ('$BankID','$BANumber')";
	        $result=mysqli_query($conn, $query);
			$query="UPDATE has_additional SET IsPrimary='N'  WHERE ssn='$ssn' and IsPrimary='Y'";
            $result=mysqli_query($conn, $query);
			$query="UPDATE user_account SET BankID='$BankID',BANumber='$BANumber'  WHERE ssn='$ssn'";
            $result=mysqli_query($conn, $query);
			$query="INSERT INTO has_additional ( ssn,bankid,banumber,isprimary ) VALUES ('$ssn','$BankID','$BANumber','$IsPrimary')";
	        $result=mysqli_query($conn, $query);
	        header('Content-Type: application/json');
		    deliver_response(200," First BANK ACCOUNT Added as Primary ",$ssn);
		}
		     else if ($IsPrimary =='N')
			 {
				 deliver_response(400,"First bank account has to be Primary!",$ssn);
				 
			 }
			
		}
		
		else
		  
		  {deliver_response(400,"SSN NOT FOUND  ",NULL);
		  }
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