<?php
$user_id = $_GET["user_id"];
$list_name = $_GET["txtAddMainListName"];
$share_lists = $_GET["txtAddMainListMember"];

//$conn = new mysqli("182.50.133.55","auxstudDB7c","auxstud7cDB1!","auxstudDB7c");
$conn = new mysqli("localhost","mysql_montv","dinoflom","projectDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


foreach($share_lists as $shareID){
    $result = $conn->query("SELECT user_id FROM 238_users WHERE user_id=$shareID");
    if($result->num_rows==0 || $shareID==$user_id){
        echo "notExists:$shareID";
        exit();
    }
}

$sql = "INSERT INTO 238_lists (user_id,list_name)
        VALUES ($user_id, '$list_name')";

if($conn->query($sql)==FALSE)
    die("error. cannot insert entity");

$new_id = $conn->insert_id;

foreach($share_lists as $shareID){
    $sql = "INSERT INTO 238_lists_shares (list_id,user_id)
            VALUES ($new_id,$shareID)";
    $conn->query($sql);
}

echo $new_id;

$conn->close();
?>