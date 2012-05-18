<?php

require 'Iptc.php';

$iptc = new Iptc('logo_php.jpg');
$iptc->set(Iptc::KEYWORDS,array(
    'keyword1','keyword2'
));
$iptc->write();
