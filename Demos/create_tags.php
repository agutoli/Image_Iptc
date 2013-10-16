<?php

require('../Iptc.php');

if (isset($_POST['action'])) {

    switch ($_POST['action']) {
        case 'Tag Image' :
            $ArrayOfTags = explode("\n",$_POST['tags']);
            break;
        case 'Clear Tags' :
            $ArrayOfTags = array();
    }

    $iptc = new Iptc('../logo_php.jpg');
    $iptc->set(Iptc::KEYWORDS, $ArrayOfTags);
    $iptc->write();
}

//read details of logo_php.jpg file.
$iptc = new Iptc('../logo_php.jpg');
$AllTags = $iptc->fetchAll(Iptc::KEYWORDS);
?>


<html>
<head>
  <title>IPTC Demo - Add Tags to Jpeg Image</title>
</head>
<body>
  <h1 >IPTC Demo - Creating Tags / Keywords in Image.</h1>
  <P><a href="index.html">Other Demos</a></P>
  <form action='' method="post">
    List the Tags you would like to apply to the image, 1 Tag per line.<br>
    <textarea rows="6" cols=50 name="tags"></textarea>
    <br>
    <input type=submit value="Tag Image" name="action"> <input type=submit value="Clear Tags" name="action">
  </form>

  <p>
    <Strong>Current Tags in Image</Strong>
    <img src="../logo_php.jpg">
    <br>
    <?php
    if ($AllTags):
      echo "<ul>";
      // template tags
      foreach ($AllTags as $Tag):
        echo "<li>{$Tag}</li>\n";
      endforeach;
      echo "</ul>";
    else:
      echo "<p>[No tags on image]</p>\n";
    endif;
    ?>
  </p>

</body>
</html>




