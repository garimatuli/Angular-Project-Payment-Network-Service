
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
		$query="SELECT ssn FROM user_account where ssn='$ssn' ";
		$result= mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result, MYSQLI_NUM);
		
		if($data[0] > 1)
			
		{ 		
		$identifier = mysqli_real_escape_string($conn, $_REQUEST['identifier']);
			$sdate = mysqli_real_escape_string($conn, $_REQUEST['sdate']);
			$edate = mysqli_real_escape_string($conn, $_REQUEST['edate']);
			$query="SELECT sum(amount) FROM send_transaction where ssn='$ssn' and date BETWEEN '$sdate' and '$edate' and identifier='$identifier' ";
		    $result= mysqli_query($conn, $query);
			$data = mysqli_fetch_array($result, MYSQLI_NUM);
			$a=$data[0];
			$query="SELECT sum(amount) FROM request_transaction r , from_transaction f where ssn='$ssn' and date BETWEEN '$sdate' and '$edate' and r.RTid=f.RTid and f.identifier='$identifier' ";
		    $result= mysqli_query($conn, $query);
			$data = mysqli_fetch_array($result, MYSQLI_NUM);
			$b=$data[0];
			$query="SELECT *  FROM send_transaction where ssn='$ssn' and date BETWEEN '$sdate' and '$edate' and identifier='$identifier' " ;
		    $result= mysqli_query($conn, $query);
			if ($result = mysqli_query($conn, $query)) 
			   { $sdata =array();
                   while($row = mysqli_fetch_array($result))
                 {
                 array_push($sdata, array('Transaction ID' => $row['STid'] ,'Amount' => $row['Amount'] ,'Date' => $row['Date'],'Memo' => $row['Memo'],'Memo' => $row['Memo'],"Status"=>"Sent"));
                 }
               
                                   
			   }
			   $query="SELECT r.RTid as RTid , r.Amount as Amount,r.Date as Date , r.Memo as Memo FROM request_transaction r , from_transaction f where ssn='$ssn' and date BETWEEN '$sdate' and '$edate' and r.RTid=f.RTid and f.identifier='$identifier' " ;
		       $result= mysqli_query($conn, $query);
			   if ($result = mysqli_query($conn, $query)) 
			   { $rdata =array();
                   while($row = mysqli_fetch_array($result))
                 {
                 array_push($sdata, array('Transaction ID' => $row['RTid'] ,'Amount' => $row['Amount'] ,'Date' => $row['Date'],'Memo' => $row['Memo'],"Status"=>"Received"));
                 }
                      
			              
                                   
			   }
			   array_sort_by_column($sdata, 'Date');
           
                   if( $a==NULL)
			{
				
                   $a=0.00;
			}		   if( $b==NULL)
			{
				
                  $b=0.00;
			}
			
			deliver_response(200,"Transactions",$a,$b,$sdata);
			
		
	        
		}
		else
		{
			deliver_response(400,"SSN Not found ",NULL,NULL,NULL);
	     	
		}
		
	}	
	 
function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $reference_array = array();

    foreach($array as $key => $row) {
        $reference_array[$key] = $row[$column];
    }

    array_multisort($reference_array, $direction, $array);
}

	   function deliver_response($status,$status_message,$data,$data1,$data2)
{
	header("HTTP/1.1 $status $status_message");
	
	$responses ['status']=$status;
	$responses ['status_message']=$status_message;
	$responses ['totalAmountSent']=$data;
	$responses ['totalAmountReceived']=$data1;
	$responses ['transactions']=$data2;
	
	
	
	
	$jason_response=json_encode($responses);
	echo $jason_response;
	
}
	
mysqli_close($conn);	   

?>