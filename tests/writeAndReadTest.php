<?php

//class iptc
require '../Iptc.php';

class writeAndReadTest extends PHPUnit_Framework_TestCase
{

    private $_iptc;

    public function setUp() {
        $this->_iptc = new Iptc('../logo_php.jpg');
    }

    public function testWriteESP_in_TagCategory() {
        //generate category random
        $random = 'CAT_' . rand (1,3000);

        //write in image
        $this->_iptc->set(Iptc::CATEGORY, $random);
        $this->_iptc->write();
        
        //get category of image
        $categ = $this->_iptc->get(Iptc::CATEGORY);

        //read category of exif/iptc
        $this->assertEquals($categ, $random);
    }
}
