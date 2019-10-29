<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
 
<?php 
foreach($body->css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($body->js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
 

</head>
<body>
<!-- Beginning header -->
<h3>Atur User</h3>
<!-- End of header-->
    <div style='height:20px;'></div>  
    <div>
        <?php echo $body->output; ?>
    </div>
<!-- Beginning footer -->
<div></div>
<!-- End of Footer -->
</body>
</html>