<?php

require 'Iptc.php';

$iptc = new Iptc('logo_php.jpg');
echo "\nIptc->fetchAll: ";print_r($iptc->fetchAll(Iptc::KEYWORDS)) . "\n";
echo "\nIptc->dump: "; print_r($iptc->dump()) . "\n";
