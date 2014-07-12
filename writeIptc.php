<?php

require 'Iptc.php';

$iptc = new Iptc('logo_php.jpg');
$iptc->set(Iptc::KEYWORDS,array(
    'keyword1','This is a test with special characters ö, ä, ü'
));
$iptc->set(Iptc::CITY, "São Paulo");
$iptc->write();
