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
          <form id='newpost' action='add_new_post.php' method='post' name='newpost' enctype="multipart/form-data">
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
              </table>

              <input type='file' name='image' id='image'><br>

              <input type='submit' name='insert' id='insert' value="Submit"><br>


          </form>
      </div>
   </div><br>
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--       $('#insert').click(function () {-->
<!--           var image_name = $('#image').val();-->
<!--           if (image_name == '') {-->
<!--                alert("Please select image!");-->
<!--                return false;-->
<!--            } else {-->
<!--                var extension = $('#image').val().split('.').pop().toLowerCase();-->
<!--                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)-->
<!--                {-->
<!--                    alert('Invalid image file!');-->
<!--                    $('#image').val('');-->
<!--                    return false;-->
<!--                }-->
<!--            }-->
<!--        })-->
<!--    })-->
<!--</script>-->
<?php
session_start();
$mysqli = new mysqli( "localhost", "root", "", "forum");
$mysqli->query("SET NAMES utf8");
$result2 =$mysqli->query( "SELECT
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



echo "<table border='1'>";
echo "<th>Topics</th>";
echo "<th>Posted by</th>";
echo "<th>Date</th>";
while ($row = $result2 -> fetch_object()) {
    echo "<tr>";
    echo "<td><a href='topic.php?id=".$row->id."'>".$row->topicsubject."</a></td>";
    echo "<td><a href='topic.php?id=".$row->user_id."'>".$row->username."</a></td>";
    echo "<td>".$row->topicdate."</td>";

    echo "</tr>";
}
echo "</table>";
    $result2->close();
?>
</body>

</html>