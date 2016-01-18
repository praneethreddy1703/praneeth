<html>

<head>
</head>


<body>
	<?php
	include "input.html";


		$con= mysqli_connect("localhost","praneeth","praneeth");
		if(!$con)
		{
			die("Could not connect");
		}


        $c = "CREATE DATABASE IF NOT EXISTS hello";
        $d=mysqli_query($con,$c);
		if($d)
		{
			echo " Database its created";
		}
		else echo "Error :" . mysql_error();


		
//tables
		mysqli_select_db($con,"hello");
		$s = "CREATE TABLE nottodo(
				Enterdates varchar(20),
				Enterevents varchar(40)
				)";
		mysqli_query($con,$s);
		
//entering
		if(isset($_POST['save']))
		{
			if(!empty($_POST['dates']))
			{
					$a = date_parse($_POST['dates']);
					$a1 = array_splice($a,0,3);
					//print_r($a1);
					if($a1['year']%4==0 && $a1['month']==2 &&$a1['day'] > 29)
					{
						echo "feb contains only 29 days<br />";
						$a1['day']="";
					}
					elseif($a1['year']%4 !=0 && $a1['month']==2 &&$a1['day'] > 28)
					{
						echo "feb contains only 28 days<br />";
						$a1['day']="";
					}
					if(strlen($a1['month'])==1)
					{
						$b='0'.$a1['month'];
						$a1['month']=$b;
						
					}
					



					if($a1['year'] ==""||$a1['month']== ""||$a1['day']==""||$_POST['events']=="")
					{
						echo "enter year,month,day and events  ";
					}
					else
					{
						$a2=join("-",$a1);
						$_POST['dates']=$a2;
				 		mysqli_select_db($con,"hello");
						$s2= "INSERT INTO nottodo(Enterdates,Enterevents) VALUES ('$_POST[dates]','$_POST[events]')";
						mysqli_query($con,$s2);
					}
			}
				else echo "please enter date and events";
				
			
		}
//displaying
		
    	mysqli_select_db($con,"hello");


//update

		if(isset($_POST['update']))
		{
			$updates = "UPDATE nottodo SET Enterevents='$_POST[events]' WHERE Enterdates='$_POST[hidden]'";
			mysqli_query($con,$updates);
			echo "<center>";
			echo "Successfully Updated";
			echo "</center>";

		};

//delete

		if(isset($_POST['delete']))
		{
			$deletes = "DELETE FROM nottodo WHERE Enterdates='$_POST[hidden]'";
			mysqli_query($con,$deletes);
			echo "<center>";
			echo "Successfully Deleted";
			echo "</center>";

		};

		$s = "SELECT * FROM nottodo ORDER BY Enterdates ASC";
		$mydata= mysqli_query($con,$s);
		
		
		if(isset($_POST['display']))
		{
			echo "<center>";
			echo "<table border=1>
					
					<tr>
					<th>Dates</th>
					<th>Events</th>
					<th></th>
					<th>Update</th>
					<th>Delete</th>
					</tr>";
			while($record = mysqli_fetch_array($mydata))
			{
			
				echo "<form action=exp2.php method=post>";
				echo "<tr>";
				echo "<td>"."<input type=text name=dates value='$record[Enterdates]'"." < /td>";
				echo "<td>"."<input type=text name=events value='$record[Enterevents]'"." < /td>";
				echo "<td>"."<input type=hidden name=hidden value=".$record['Enterdates']." < /td>";
				echo "<td>"."<input type=submit name=update value=update"." < /td>";
				echo "<td>"."<input type=submit name=delete value=delete"." < /td>";
				echo "</tr>";
				
			}
		
		echo "</table>";
		echo "<td>"."<input type=submit name=done value=ToCloseDisplay"." < /td>";
		echo "</form>";
		echo "</center>";
		}
		if(isset($_POST['done'])){
			echo "<center>Display Is Closed</center>";
		}
	
		mysqli_close($con);

	?>
</body>
</html> 