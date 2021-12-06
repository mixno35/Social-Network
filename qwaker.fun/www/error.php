<?php
   $status = $_SERVER['REDIRECT_STATUS'];
   $codes = array(
      403 => array('403', 'Forbidden', 'The server has refused to fulfill your request.'),
      404 => array('404', 'Not Found', 'The document/file requested was not found on this server.'),
      405 => array('405', 'Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
      408 => array('408', 'Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
      500 => array('500', 'Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
      502 => array('502', 'Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
      504 => array('504', 'Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
   );

   $title = $codes[$status][1];
   $message = $codes[$status][2];
   if ($title == false || strlen($status) != 3) {
        $message = 'Please supply a valid status code.';
   }
?>
<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <title><?php echo $codes[$status][0].' '.$codes[$status][1]; ?></title>
</head>
<body style="
    padding: 0;
    margin: 0;
"><h2 style="
    position: absolute;
    margin: 0;
    padding: 10px;
    width: 200px;
    text-align: center;
    background: indianred;
    color: white;
    font-weight: 700;
    font-size: 30px;
    font-family: system-ui;
    transform: rotate(-45deg);
    left: -70px;
"><?php echo $codes[$status][0]; ?></h2>
    
    <h1 style="
    width: -webkit-fill-available;
    padding: 0;
    margin: 0;
    text-align: center;
    font-weight: 700;
    font-size: 18px;
    font-family: system-ui;
    margin-top: 20px;
"><?php echo $codes[$status][1]; ?></h1>
    <p style="
    width: -webkit-fill-available;
    padding: 0;
    margin: 0;
    text-align: center;
    font-weight: 400;
    font-size: 12px;
    font-family: system-ui;
    color: gray;
    margin-top: 4px;
"><?php echo $message; ?></p>
<p style="
    width: -webkit-fill-available;
    text-align: center;
    font-size: 12px;
    font-weight: 400;
    font-family: system-ui;
    color: lightgray;
    margin-top: 100px;
">&copy; QWAKER.fun, <?php echo date('Y'); ?></p>

</body></html>