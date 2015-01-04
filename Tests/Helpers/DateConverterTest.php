<?php
/**
 * TESTS : DateConverter pour la conversion des dates au format ICU.
 *
 *
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 * 
 */

namespace Olix\FormsExtBootstrapBundle\Tests\Helpers;

use Olix\FormsExtBootstrapBundle\Helpers\DateConverter;
use IntlDateFormatter;


class DateConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests the convertDateIcuToWdgtBootstapDatetimePicker function.
     *
     * @dataProvider providerConvertDateIcuToWdgtBootstapDatetimePicker
     */
    public function testConvertDateIcuToWdgtBootstapDatetimePicker($expected, $pattern, $type = 'date', $locale = null)
    {
        $result = DateConverter::convertDateIcuToWdgtBootstapDatetimePicker($pattern, $type, $locale);
    
        $this->assertEquals($expected, $result);
    }

    public function providerConvertDateIcuToWdgtBootstapDatetimePicker ()
    {
        $tests = array();
        
        $tests[] = array('yyyy-mm-dd', 'yyyy-MM-dd');
        $tests[] = array('dd/mm/yyyy', 'dd/MM/yyyy');
        $tests[] = array('dd/mm/yyyy', 'short', 'date', 'fr');
        $tests[] = array('dd/mm/yyyy', IntlDateFormatter::SHORT, 'date', 'fr');
        
        return $tests;
    }

}