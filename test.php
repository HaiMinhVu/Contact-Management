<?php
include ('dbconnect.php');
?>
<!DOCTYPE html>
<html>
<body>

<form action="test.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
$getimage = "SELECT * FROM test";
$imageresult = $dbconnect->query($getimage);
while ($row = $imageresult->fetch_assoc()) {
    echo "<div>";
    echo "<p>".$row['id']."</p>";
    echo "<img src = 'images/".$row['image']."'>";
    echo "</div>";
}
?>

</body>
</html>



<?php
if (isset($_POST['submit'])) {
    $filename = $_FILES['fileToUpload']['name'];


    $target = "images/".basename($filename);
    $sql = "INSERT INTO test VALUES (null, '$filename')";
    $result = $dbconnect->query($sql);

    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target)) {
        echo "uploaded";
    }
    else{
        echo "failed";
    }
}
?>