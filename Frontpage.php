<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>MyForum</title>
</head>

<body>


<div id="container">
    <div id="page">
        <div id="banner">
            <h1>Welcome to MyForum</h1>
        </div>
        <div id='new_post_container'>
            <form id='newpost' action='add_new_post.php' method='post' name='newpost' enctype="multipart/form-data">

                <label id="lb_topic">Topic:</label>
                <input id='topicsubject' type='text' name='topicsubject'>
                <label id="lb_content">Content:</label>
                <textarea name='content' id='content'></textarea>
                <label id="lb_posted_by">Posted by:</label>
                <input id='username' type='text' name='username'>

                <input type='file' name='image' id='image'>

                <input type='submit' name='insert' id='insert' value="Submit">


            </form>
        </div>

        <div id="topics">
            <?php
            session_start();
            $mysqli = new mysqli("localhost", "root", "", "forum");
            $mysqli->query("SET NAMES utf8");
            $result2 = $mysqli->query("SELECT
topics.id,
topics.topicsubject,
topics.user_id,
users.username,
topics.topicdate
FROM posts
INNER JOIN topics
  ON posts.topic_id = topics.id
INNER JOIN users
  ON posts.user_id = users.id AND topics.user_id = users.id
  GROUP BY topics.topicsubject");

            while ($row = $result2->fetch_object()) {
                echo "<div class='topic'>";
                echo "<a class='subject' href='topic.php?id=" . $row->id . "&page=1'>" . $row->topicsubject . "</a>";
                echo "<a class='user' href='topic.php?id=" . $row->user_id . "'>" . $row->username . "</a>";
                echo "<p class='date'>" . $row->topicdate . "</p>";
                echo "</div>";
            }
            $result2->close();
            ?>
        </div>
        <div id="footer">
            MyForum © 2019
        </div>
    </div>
</div>

</body>

</html>