<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <title>MyForum</title>
</head>

<body>

<div id='container'>
    <div id='new_post_container'>
        <form id='newpost' action='add_new_post.php' method='post' name='newpost'>
            <table>
                <tr>
                    <td>Topic: </td>
                    <td> <input  id='topicsubject' type='text' name='topicsubject'></td>
                </tr>
                <tr>
                    <td>Content: </td>
                    <td><textarea name='content'  id='content'></textarea></td>
                </tr>
                <tr>
                    <td>Posted by: </td>
                    <td><input id='username' type='text'  name='username'></td>
                </tr>
                <tr>
                    <td><input type='submit'></td>
                </tr>
            </table>
        </form>
    </div>
</div><br>

<?php
$mysqli = new mysqli("localhost", "root", "", "forum");
$mysqli->query("SET NAMES utf8");

$topicID=$_GET['id'];
$topicSubject = mysqli_query($mysqli, "SELECT
  topics.topicsubject
FROM topics
  WHERE id = '$topicID'");
$topicSubjectResult = $topicSubject -> fetch_object();
echo "<h1>".$topicSubjectResult->topicsubject."</h1>";
//
$posts = mysqli_query($mysqli, "SELECT
  posts.image,
  posts.content,
  posts.postdate,
  users.username
FROM posts
  INNER JOIN users
    ON posts.user_id = users.id
  WHERE posts.topic_id = $topicID");

echo "<table border='1'>";
echo "<th>Image</th>";
echo "<th>Content</th>";
echo "<th>Posted by</th>";
echo "<th>Date</th>";
while ($row = $posts->fetch_object()) {
        echo "<tr>";
        echo "<td><img src='".$row->image."'/></td>";
        echo "<td>".$row->content."</td>";
        echo "<td>".$row->username."</td>";
        echo "<td>".$row->postdate."</td>";
        echo "</tr>";

    }
echo "</table>";

$posts->close();
?>