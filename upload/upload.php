<?php // upload.php
echo <<<_END
<html><head><title>PHP Form Upload</title></head><body>
<form method='post' action='upload.php' enctype='multipart/form-data'>
Select File: <input type='file' name='filename' size='10' />
<input type='submit' value='Upload' />
</form>
_END;
if ($_FILES)
{
$name = "events/";
$nama2 = $_FILES['filename']['name'];
$nama=$name+$nama2;
move_uploaded_file($_FILES['filename']['tmp_name'], $nama2);
echo "Uploaded image '$nama'<br /><img src='$nama2' />";
}
echo "</body></html>";
?>