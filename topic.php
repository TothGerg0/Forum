<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="posts.css">
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


        <?php
        $mysqli = new mysqli("localhost", "root", "", "forum");
        $mysqli->query("SET NAMES utf8");


        $topicID = $_GET['id'];
        $topicSubject = mysqli_query($mysqli, "SELECT
  topics.topicsubject
FROM topics
  WHERE id = '$topicID'");
        $topicSubjectResult = $topicSubject->fetch_object();
        echo "<div id='lb_topicsubject'>";
        echo "<h1 id='subject'>" . $topicSubjectResult->topicsubject . "</h1>";
        echo "<a id='frontpage' href='Frontpage.php'>[Back to frontpage]</a>";
        echo "</div>";

        $page = $_GET['page'];

        if ($page == "" || $page == 1) {
            $page1 = 0;
        } else {
            $page1 = ($page * 5) - 5;
        }

        $posts = mysqli_query($mysqli, "SELECT
  posts.id,
  posts.image,
  posts.content,
  posts.postdate,
  users.username
FROM posts
  INNER JOIN users
    ON posts.user_id = users.id
  WHERE posts.topic_id = $topicID
  LIMIT $page1, 5"
        );


        echo "<div id=\"posts\">";
        while ($row = $posts->fetch_object()) {
            $originalImage = "uploads/" . substr($row->image, 16);
            echo "<div class='post'>";

            echo "<a class='uploadedimage' href='$originalImage'><img src='" . $row->image . "'/></a>";
            echo "<p class='content'>" . $row->content . "</p>";
            echo "<div class='name_and_date'>";
            echo "<p class='user'>Posted by: " . $row->username . "</p>";
            echo "<p class='date'>" . $row->postdate . "</p>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";

        //pagecount
        echo "<div id='pagecounter'>";
        $number_of_posts = mysqli_query($mysqli, "SELECT * FROM posts WHERE topic_id = $topicID");
        $pages = mysqli_num_rows($number_of_posts);
        $a = ceil($pages / 5);
        for ($b = 1; $b <= $a; $b++) {
            echo "<a href='topic.php?id=$topicID&page=$b' style='text-decoration: none'>" . $b . "</a>";
        }
        echo "</div>";
        $posts->close();
        ?>

        <div id="footer">
            MyForum © 2019
        </div>
    </div>
</div>
</body>

</html>
