<?php

require('../Iptc.php');

if (isset($_POST['action'])) {

    switch ($_POST['action']) {
        case 'Caption Image' :
            $Caption = $_POST['Caption'];
            break;
        case 'Clear Caption' :
            $Caption = '';
    }

    $iptc = new Iptc('../logo_php.jpg');
    $iptc->set(Iptc::CAPTION, $Caption);
    $iptc->write();
}

//read details of logo_php.jpg file.
$iptc = new Iptc('../logo_php.jpg');
$CaptionArray = $iptc->fetchAll(Iptc::CAPTION);
$ImageCaption = $CaptionArray[0];

?>


<html>
<head>
  <title>IPTC Demo - Add Caption to Jpeg Image</title>
</head>
<body>
  <h1 >IPTC Demo - Creating Caption in Image.</h1>
  <p><a href="index.html">Other Demos</a></p>
  <form action='' method="post">
    Caption to apply to Image.<br>
    <input name='Caption' >
    <br>
    <input type=submit value="Caption Image" name="action"> <input type=submit value="Clear Caption" name="action">
  </form>
  <p>
    <Strong>Current Caption on Image</Strong>
    <img src="../logo_php.jpg">
    <br>
    <?php echo $ImageCaption ; ?>
  </p>
  <p>
    <div>
      The Caption in a JPeg will show up in various places, including under the image in picasa.
    </div>
  </p>

</body>
</html>




