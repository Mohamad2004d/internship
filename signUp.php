<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<?php

if(empty($_POST['name'])){
    die("Name is required");
}

if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

if(strlen($_POST["password"])<8){
    die("Password must be at least 8 characters");
}

if(!preg_match("/[a-z]/i",$_POST["password"])){
    die("Password must contain at least one letter");
}
if(!preg_match("/[0-9]/i",$_POST["password"])){
    die("Password must contain at least one number");
}

if($_POST["password"]!==$_POST["password_confirmation"]){
    die("Passwords must match");
}


$password_hash = password_hash($_POST["password"],PASSWORD_DEFAULT);
$mysqli = require __DIR__ . "/DB.php";
$sql = "INSERT INTO user(name , email, password_hash)
                            VALUES(?,?,?)";
$stmt = $mysqli->stmt_init();

//$stmt->prepare($sql);

if(! $stmt->prepare($sql)){
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",$_POST["name"],$_POST["email"],$password_hash);

if($stmt->execute()){

    header("Location: test.html");
    exit;
    if($mysqli->errno === 1062){ 
        //check error number property if equal to 1062(Duplicate email entry)
        die("email already taken ..!");
    }
    else{
            die($mysqli->error . " " . $mysqli->errno);}
}