<?php

require 'Iptc.php';

$iptc = new Iptc('logo_php.jpg');
print_r($iptc->fetchAll(Iptc::KEYWORDS));
