<?php
/**
 * Class for manipulating EXIF and IPTC image
 *
 * PHP version 5
 *
 * @category Image
 * @package  Iptc
 * @author   Bruno Thiago Leite Agutoli <brunotla1@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/agutoli
 */

/**
 * Class for manipulating EXIF and IPTC image
 *
 * @category Image
 * @package  Iptc
 * @author   Bruno Thiago Leite Agutoli <brunotla1@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version  Release: 0.0.1
 * @link     https://github.com/agutoli
 */

class Iptc
{

    const OBJECT_NAME                     = '005';
    const EDIT_STATUS                     = '007';
    const PRIORITY                        = '010';
    const CATEGORY                        = '015';
    const SUPPLEMENTAL_CATEGORY           = '020';
    const FIXTURE_IDENTIFIER              = '022';
    const KEYWORDS                        = '025';
    const RELEASE_DATE                    = '030';
    const RELEASE_TIME                    = '035';
    const SPECIAL_INSTRUCTIONS            = '040';
    const REFERENCE_SERVICE               = '045';
    const REFERENCE_DATE                  = '047';
    const REFERENCE_NUMBER                = '050';
    const CREATED_DATE                    = '055';
    const CREATED_TIME                    = '060';
    const ORIGINATING_PROGRAM             = '065';
    const PROGRAM_VERSION                 = '070';
    const OBJECT_CYCLE                    = '075';
    const CITY                            = '090';
    const PROVINCE_STATE                  = '095';
    const COUNTRY_CODE                    = '100';
    const COUNTRY                         = '101';
    const ORIGINAL_TRANSMISSION_REFERENCE = '103';
    const HEADLINE                        = '105';
    const CREDIT                          = '110';
    const SOURCE                          = '115';
    const COPYRIGHT_STRING                = '116';
    const CAPTION                         = '120';
    const LOCAL_CAPTION                   = '121';
    const CAPTION_WRITER                  = '122';

    /**
     * variable that stores the IPTC tags
     *
     * @var array
     */
    private $_meta = array();
    
    /**
     * This variable was checks whether any tag class setada
     *
     * @var boolean 
     */
    private $_hasMeta = false;


    /**
     * allowed extensions
     *
     * @var array
     */
    private $_allowedExt = array('jpg', 'jpeg', 'pjpeg');

    /**
     * Image name ex. /home/user/image.jpg
     * 
     * @var String
     */
    private $_filename;
    
    /**
     * Constructor class
     *
     * @param string $filename - Name of file
     *
     * @throw Iptc_Exception
     * @see http://www.php.net/manual/pt_BR/book.image.php - PHP GD
     * @see iptcparse
     * @see getimagesize
     * @return void
     */ 
    public function __construct($filename) 
    {

        /**
         * Check PHP version
         * @since 2.0.1
         */
        if (version_compare(phpversion(), '5.1.0', '<') === true) {
            include 'Iptc/Exception.php';
            throw new Iptc_Exception(
                'ERROR: Your PHP version is '.phpversion() . 
                    '. Iptc class requires PHP 5.1.0 or newer.'
            );
        }

        if ( ! extension_loaded('gd') ) {
            include 'Iptc/Exception.php';
            throw new Iptc_Exception(
                'Since PHP 4.3 there is a bundled version of the GD lib.'
            );
        }
       
        if ( ! file_exists($filename) ) {
            include 'Iptc/Exception.php';
            throw new Iptc_Exception(
                'Image not found!'
            );
        }
        
        if ( ! in_array(end(explode('.', $filename)), $this->_allowedExt) ) {
            include 'Iptc/Exception.php';
            throw new Iptc_Exception(
                'Support only for the following extensions: ' . 
                    implode(',', $this->_allowedExt)
            ); 
        }

        $size           = getimagesize($filename, $imageinfo);
        $this->_hasMeta = isset($imageinfo["APP13"]);
        if ($this->_hasMeta) {
            $this->_meta = iptcparse($imageinfo["APP13"]);
        }
        $this->_filename = $filename;
    }

    /**
     * Set parameters you want to record in a particular tag "IPTC"
     *
     * @param Integer|const $tag  - Code or const of tag
     * @param array|mixed   $data - Value of tag
     * 
     * @return Iptc object
     * @access public
     */
    public function set($tag, $data) 
    {
        $this->_meta["2#$tag"] = array($data);
        $this->_hasMeta        = true;
        return $this;
    }

    /**
     * adds an item at the beginning of the array
     *
     * @param Integer|const $tag  - Code or const of tag
     * @param array|mixed   $data - Value of tag
     *
     * @return Iptc object
     * @access public
     */
    public function prepend($tag, $data)
    {
        if ( ! empty($this->_meta["2#$tag"])) {
            array_unshift($this->_meta["2#$tag"], $data);
            $data = $this->_meta["2#$tag"];
        }
        $this->_meta["2#$tag"] = array( $data );
        $this->_hasMeta        = true;
        return $this;
    }

    /**
     * adds an item at the end of the array
     *
     * @param Integer|const $tag  - Code or const of tag
     * @param array|mixed   $data - Value of tag
     * 
     * @return Iptc object
     * @access public
     */
    public function append($tag, $data)
    {
        if ( ! empty($this->_meta["2#$tag"])) {
            array_push($this->_meta["2#$tag"], $data);
            $data = $this->_meta["2#$tag"];
        }
        $this->_meta["2#$tag"] = array( $data );
        $this->_hasMeta        = true;
        return $this;
    }

    /**
     * Return fisrt IPTC tag by tag name
     *
     * @param Integer|const $tag - Name of tag
     * 
     * @example $iptc->fetch(Iptc::KEYWORDS);
     *
     * @access public
     * @return mixed|false
     */
    public function fetch($tag) 
    {
        if (isset($this->_meta["2#$tag"])) {
            return $this->_meta["2#$tag"][0];
        }
        return false;
    }

    /**
     * Return all IPTC tags by tag name
     *
     * @param Integer|const $tag - Name of tag
     * 
     * @example $iptc->fetchAll(Iptc::KEYWORDS);
     *
     * @access public
     * @return mixed|false
     */
    public function fetchAll($tag) 
    {
        if (isset($this->_meta["2#$tag"])) {
            return $this->_meta["2#$tag"];
        }
        return false;
    }

    /**
     * debug that returns all the IPTC tags already in the image
     *
     * @access public
     * @return string
     */
    public function dump() 
    {
        return print_r($this->_meta, true);
    }

    /**
     * returns a string with the binary code
     *
     * @access public
     * @return string
     */
    public function binary() 
    {
        $iptc = '';
        foreach (array_keys($this->_meta) as $key) {
            $tag   = str_replace("2#", "", $key);
            $iptc .= $this->iptcMakeTag(2, $tag, $this->_meta[$key][0]);
        }        
        return $iptc;    
    }

    /**
     * Assemble the tags "IPTC" in character "ascii"
     *
     * @param Integer $rec - Type of tag ex. 2
     * @param Integer $dat - code of tag ex. 025 or 000 etc
     * @param mixed   $val - any caracterer
     * 
     * @access public
     * @return binary source
     */
    public function iptcMakeTag($rec, $dat, $val) 
    {
    
        //beginning of the binary string
        $iptcTag = chr(0x1c).chr($rec).chr($dat);

        if (is_array($val)) {
            $src = '';
            foreach ($val as $item) {
                $len  = strlen($item);
                $src .= $iptcTag . $this->_testBitSize($len) . $item;
            }
            return $src;
        }

        $len = strlen($val);
        $src = $iptcTag . $this->_testBitSize($len) . $val;
        return $src;         
    }    

    /**
     * create the new image file already 
     * with the new "IPTC" recorded
     *
     * @access public
     * @return binary source
     */
    public function write() 
    {

        //@see http://php.net/manual/pt_BR/function.iptcembed.php 
        $content = iptcembed($this->binary(), $this->_filename, 0);    

        unlink($this->_filename);

        if ($file = fopen($this->_filename, "w")) {
            fwrite($file, $content);
            fclose($file);
            return true;
        }
        return false;
    }    
    
    /**
     * completely remove all tags "IPTC" image 
     *
     * @access public
     * @return binary source
     */
    public function removeAllTags() 
    {
        $this->_hasMeta = false;
        $this->_meta    = Array();
        $impl           = implode(file($this->_filename));
        $img            = imagecreatefromstring($impl);
        unlink($this->_filename);
        imagejpeg($img, $this->_filename, 100);
    }

    /**
     * It proper test to ensure that 
     * the size of the values are supported within the 
     *
     * @param Integer $len - size of the character
     *
     * @access public
     * @return binary source
     */
    private function _testBitSize($len) 
    {
    
        if ($len < 0x8000) {
            return
                chr($len >> 8) .
                chr($len & 0xff);
        }
        
        return
            chr(0x1c).chr(0x04) .
            chr(($len >> 24) & 0xff) .
            chr(($len >> 16) & 0xff) .
            chr(($len >> 8 ) & 0xff) .
            chr(($len ) & 0xff);
    }
}
