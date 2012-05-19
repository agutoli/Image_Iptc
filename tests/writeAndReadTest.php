<?php

//class iptc
require '../Iptc.php';

class writeAndReadTest extends PHPUnit_Framework_TestCase
{

    private $_iptc;

    public function setUp() {
        $this->_iptc = new Iptc('../logo_php.jpg');
        $this->_iptc->set(Iptc::OBJECT_NAME, 'test');
        $this->_iptc->write();
    }

    public function testWriteESP_in_TagCategory() {
        //generate category random
        $random = 'CAT_' . rand (1,3000);

        //write in image
        $this->_iptc->set(Iptc::CATEGORY, $random);
        $this->_iptc->write();
        
        //get category of image
        $categ = $this->_iptc->fetch(Iptc::CATEGORY);

        //read category of exif/iptc
        $this->assertEquals($categ, $random);
    }

    public function testRemoveAllTags() {
        $this->_iptc->removeAllTags();
        $this->assertFalse($this->_iptc->fetch(Iptc::OBJECT_NAME));
    }

    public function testSetKeyworsTags() {
        
        $this->_iptc->set(Iptc::KEYWORDS, array(
            'keyword1',
            'keyword2',
            'keyword3'
        ));
        $this->_iptc->write();

        //make tests to set array value
        $keywords = $this->_iptc->fetch(Iptc::KEYWORDS);//get values

        $this->assertEquals($keywords[0], 'keyword1');
        $this->assertEquals($keywords[1], 'keyword2');
        $this->assertEquals($keywords[2], 'keyword3');

        //otherwise set of values
        $this->_iptc->set(Iptc::KEYWORDS, 'keyword4');
        $this->assertEquals($this->_iptc->fetch(Iptc::KEYWORDS), 'keyword4');
    }
}
