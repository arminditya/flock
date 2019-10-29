<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Refresh" content="0.1;url=<?php echo $this->config->base_url();?>index.php/Verify/success">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

    #mydiv {
  width: 200px;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<body>


<div id="mydiv">
    <h2>Mohon tunggu</h2>
    <div class="loader"></div>
</div>
</body>
</html>
