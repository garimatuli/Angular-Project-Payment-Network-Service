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
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$data = json_decode(file_get_contents("php://input"));
$ndata = array();
$ndata =$data; 
if ( $_SERVER['REQUEST_METHOD'] == 'POST')
	{
		global $conn;
		$ssn = $ndata->ssn;
		$query="SELECT ssn FROM user_account where ssn='$ssn'" ;
		$result= mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		if($data[0] > 1)
		{
		deliver_response(400,"SSN already exists!",$ssn);               
		}
		else
		{
			              $identifier = $ndata->identifier;
	                      $query="SELECT identifier FROM electronic_address where identifier='$identifier'" ;
	                      $result= mysqli_query($conn, $query);
		                  $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
		              if($data['identifier'] == $identifier)
		                {
		                        deliver_response(400,"Email/Phone already exists!",$ssn);
		                 }
		              else
				    {
	                             saveUser($ndata);	
				   }
		}	
	}
	
function saveUser($ndata)
	{
    global $conn;
	  $password = $ndata->password;
	  $ssn = $ndata->ssn;
	  $name = $ndata->name;
      $query="INSERT INTO user_account (SSN,Name,Password) VALUES ('$ssn','$name','$password')";
	  $result=mysqli_query($conn,$query);
      header('Content-Type: application/json');
	   		
	  saveEa($ndata);
		     
	 
    //Respond success / error messages
    }
function saveEa($ndata)
  
    {
	  global $conn;
	  
		$identifier = $ndata->identifier;
	     $ssn =$ndata->ssn;
	  
	          if(!empty($ndata->verified))
    {
		$verified = $ndata->verified;
		
              
       $email = filter_var($identifier, FILTER_SANITIZE_EMAIL);
       
	   if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
             $query="INSERT INTO electronic_address (Identifier , SSN, Type,Verified) VALUES ('$identifier','$ssn','E','$verified')";
	           $result=mysqli_query($conn, $query);
    header('Content-Type: application/json');
	deliver_response(200," Idntifier inserted ",NULL);
            }

        else {
                 $query="INSERT INTO electronic_address (Identifier , SSN, Type,Verified) VALUES ('$identifier','$ssn','P','$verified')";
                 $result=mysqli_query($conn, $query);
    header('Content-Type: application/json');
	 deliver_response(200," Idntifier inserted ",NULL);
			  }
			  
	}
		
		else
	
	{
		$email = filter_var($identifier, FILTER_SANITIZE_EMAIL);
       
	         if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
             $query="INSERT INTO electronic_address (Identifier , SSN, Type) VALUES ('$identifier','$ssn','E')";
	          $result=mysqli_query($conn, $query);
    header('Content-Type: application/json');
	 deliver_response(200," Idntifier inserted ",NULL);
			}

        else {
                 $query="INSERT INTO electronic_address (Identifier , SSN, Type) VALUES ('$identifier','$ssn','P')";
                 $result=mysqli_query($conn, $query);
    header('Content-Type: application/json');
	 deliver_response(200," Idntifier inserted ",NULL);
			  }
	
	}
	
	}
  
  function deliver_response($status,$status_message,$data1)
{
	header("HTTP/1.1 $status $status_message");
	
	$responses ['status']=$status;
	$responses ['status_message']=$status_message;
	$responses ['ssn']=$data1;
	
	$jason_response=json_encode($responses, JSON_NUMERIC_CHECK);
	echo $jason_response;
	
}
            mysqli_close($conn);	
	?>