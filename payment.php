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
$amount = 6000000;

$sql='SELECT 
districtID, districtName, max(Enrollments) FROM 
(SELECT me.districtID, me.districtName, COUNT(us.agentID) as Enrollments FROM 
(select district.districtID, district.districtName, agent.agentID, agent.agentHeadID 
from district LEFT JOIN agent ON district.districtID=agent.districtID 
GROUP BY district.districtID, agent.agentID) as me 
INNER JOIN 
(SELECT * from enrollment WHERE month(dateOfEnrollment)=month(current_date()) 
&& year(dateOfEnrollment)=year(current_date())) as us 
on me.agentID=us.agentID GROUP BY me.districtID) as us';

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
    $highest=$row['districtID'];
    echo $highest;
    echo '<br>';

    $sqlm="SELECT count(me.agentID) as num from (select * from agent where 
    districtID = ".$highest." && agentHeadID is not null) as me";
$resultm = mysqli_query($conn,$sqlm);
$rowm = mysqli_fetch_assoc($result);
    $hag=$rowm['num'];
    
$get="SELECT count(me.agentID) as num from (select * from agent where 
    agentHeadID is not null) as me";
$query = mysqli_query($conn,$get);
$roam = mysqli_fetch_assoc($query);
    $ag=$roam['num'];

$fetch="SELECT count(me.agentID) as num from (select * from agent where 
    agentHeadID is null) as me";
$queue = mysqli_query($conn,$fetch);
$rowl = mysqli_fetch_assoc($queue);
    $agh=$rowl['num'];

    $k=(1.75*($agh+1)+($ag+$hag)+0.5);
    $agent=$amount/$k;
    $agenthead=1.75*$agent;
    $admin=0.5*$agent;
    $highagent=2*$agent;
    $highagenthead=2*$agenthead;

    echo $agent; echo '<br>';
    echo $agenthead; echo '<br>';
    echo $admin; echo '<br>';
    echo $highagent; echo '<br>';
    echo $highagenthead; echo '<br>';


$hiagent="SELECT * from agent where districtID=".$highest;
$ngt = mysqli_query($conn,$hiagent);
while($me = mysqli_fetch_assoc($ngt)){
    $agentID = $me['agentID'];
    if(is_null($me['agentHeadID'])){

        $insert="INSERT INTO payment(agentID,amount,month) 
        VALUES ('$agentID','$highagenthead',CURDATE())";
        if(mysqli_query($conn,$insert)){
            echo "Success";
        }else
        echo "failed";
    }else {
        $insert="INSERT INTO payment(agentID,amount,month) 
        VALUES ('$agentID','$highagent',CURDATE())";
        if(mysqli_query($conn,$insert)){
            echo "Success";
        }else
        echo "failed";
    };
    echo '<br>';
};

$xhiagent="SELECT * from agent where districtID != ".$highest;
$xngt = mysqli_query($conn,$xhiagent);
while($xme = mysqli_fetch_assoc($xngt)){
    $xagentID=$xme['agentID'];
    if(is_null($xme['agentHeadID'])){
        $insert="INSERT INTO payment(agentID,amount,month) 
        VALUES ('$xagentID','$agenthead',CURDATE())";
        if(mysqli_query($conn,$insert)){
            echo "Success";
        }else
        echo "failed";
    }else{
        $insert="INSERT INTO payment(agentID,amount,month) 
        VALUES ('$xagentID','$agent',CURDATE())";
        if(mysqli_query($conn,$insert)){
            echo "Success";
        }else
        echo "failed";
    };
    echo '<br>';
};

$sadmin="SELECT * from admin";
$qadmin = mysqli_query($conn,$sadmin);
while($fadmin = mysqli_fetch_assoc($qadmin)){
    $aadmin=$fadmin['adminID'];
    $insert="INSERT INTO payment(adminID,amount,month)
        VALUES ('$aadmin','$admin',CURDATE())";
        if(mysqli_query($conn,$insert)){
            echo "Success";
        }else
        echo "failed";
};

?>