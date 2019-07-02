<!DOCTYPE HTML5>
<html>
    <head></head>
    <body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "politicalparty";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn){
    die("Connection failed: " .mysqli_connect());
}
echo "Connected successfully";
echo '<br>'; 
$sql='SELECT 
 member.fName,
 member.lName,
 count(enrollment.recommenderID) as total
 from
 member
 left join enrollment on member.memberID = enrollment.recommenderID
 group by member.memberID,member.fName,member.lName
 having count(enrollment.recommenderID)>0';

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $x=0;
    echo "<input type='checkbox' name='recommended' value='recommender[$x]'>";
    echo $row['fName']; 
    echo $row['lName'];
    echo $row['total'];
    echo '<br>';
    //print_r($row);

    $x++;
    
}
?>
</body>