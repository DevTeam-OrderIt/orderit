<!DOCTYPE html>
<html>
<body>

<form action="<?= base_url() ?>home/upload" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="file" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>