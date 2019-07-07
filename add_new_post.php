<?php
/** @noinspection SqlResolve */
session_start();


//establish connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "", "forum");
$mysqli->query("SET NAMES utf8");

$topicSubject = $_POST['topicsubject'];
$content = $_POST['content'];
$username = $_POST['username'];

if (isset($topicSubject) &&
    isset($content) &&
    isset($username)) {


    // check if user exists
    $user = $mysqli->prepare("SELECT * FROM users WHERE 
      username = ?");
    $user->bind_param("s", $username);
    $user->execute();
    $user = $user->get_result();
    $userResult = mysqli_fetch_assoc($user);

    $number_of_users = $user->num_rows;


    //if user doesn't exists
    if ($number_of_users == 0) {
        $add_new_user = $mysqli->prepare("INSERT INTO users (username)
                                VALUES (?)");
        $add_new_user->bind_param("s", $username);
        $add_new_user->execute();

        $user = $mysqli->prepare("SELECT * FROM users 
                                WHERE username = ?");
        $user->bind_param("s", $username);
        $user->execute();
        $user = $user->get_result();
        $userResult = mysqli_fetch_assoc($user);

    }


    // if user exists get his ID
    $userId = $userResult["id"];


    //check if topic exists
    $number_of_topic = $mysqli->prepare("SELECT id FROM topics WHERE  
      topicsubject = ?");
    $number_of_topic->bind_param("s", $topicSubject);
    $number_of_topic->execute();
    $number_of_topic->store_result();


    //if topic doesn't exists
    if ($number_of_topic->num_rows == 0) {
        $add_new_topic = $mysqli->prepare("INSERT INTO topics (topicsubject, user_id)
                            VALUES (?,?)");

        $add_new_topic->bind_param("si", $topicSubject, $userId);

        $add_new_topic->execute();

    }


    // if topic exists get its ID
    $topic = $mysqli->prepare("SELECT id FROM topics 
                            WHERE  
                            topicsubject = ?");
    $topic->bind_param("s", $topicSubject);
    $topic->execute();
    $topic = $topic->get_result();
    $topicResult = mysqli_fetch_assoc($topic);
    $topicId = $topicResult["id"];

    //insert image to uploads file
    if (ISSET($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('gif', 'png', 'jpg', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);
            include_once ("image_resize.php");
            $resizedFilePath = "uploads/resized_$fileName";
            $wmax = 200;
            $hmax = 150;
            img_resize($targetFilePath, $resizedFilePath, $wmax, $hmax, $fileType);
        }
    }
    $add_new_post = $mysqli->prepare("INSERT INTO posts (content, topic_id, user_id, image)
          VALUES (?,?,?,?)");
    $add_new_post->bind_param("siis", $content, $topicId, $userId, $resizedFilePath);
    $add_new_post->execute();

}

//if ($_GET['id'] == $topicId){echo "true";}
    header("Location: topic.php?id=".$topicId."&page=1");

//}else{
//    header("Location: Frontpage.php");
//}

$mysqli->close();



