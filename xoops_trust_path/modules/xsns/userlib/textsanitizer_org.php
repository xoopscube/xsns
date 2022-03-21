<?php
// Based on module.textsanitizer.php,v 1.8 2006/07/27 00:17:17 onokazu Exp $

include_once(XOOPS_ROOT_PATH . '/class/module.textsanitizer.php');

define('XSNS_URL_LENGTH_MAX', 55);


class XsnsTextSanitizer extends MyTextSanitizer
{
//	var $url_len_max = XSNS_URL_LENGTH_MAX;

    // TODO @gigamaster Make static
    //function &getInstance()
    static function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new XsnsTextSanitizer();
        }
        return $instance;
    }

    function codePreConv($text, $xcode = 1)
    {
        return $text;
    }

    function codeConv($text, $xcode = 1, $image = 1)
    {
        return $text;
    }

    function &xoopsCodeDecode(&$text, $allowimage = 1)
    {
        $patterns = array();
        $replacements = array();

        $patterns[] = "/\[color=(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
        $replacements[] = '<span style="color: #\\2;">\\3</span>';
        $patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
        $replacements[] = '<span style="font-size: \\2;">\\3</span>';
        $patterns[] = "/\[font=(['\"]?)([^;<>\*\(\)\"']*)\\1](.*)\[\/font\]/sU";
        $replacements[] = '<span style="font-family: \\2;">\\3</span>';
        $patterns[] = "/\[b](.*)\[\/b\]/sU";
        $replacements[] = '<b>\\1</b>';
        $patterns[] = "/\[i](.*)\[\/i\]/sU";
        $replacements[] = '<i>\\1</i>';
        $patterns[] = "/\[u](.*)\[\/u\]/sU";
        $replacements[] = '<u>\\1</u>';
        $patterns[] = "/\[d](.*)\[\/d\]/sU";
        $replacements[] = '<del>\\1</del>';

        $ret = preg_replace($patterns, $replacements, $text);
        return $ret;
    }

    function stripXoopsCode(&$text)
    {
        $patterns = array();
        $replacements = array();

        $patterns[] = "/\[color=(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[font=(['\"]?)([^;<>\*\(\)\"']*)\\1](.*)\[\/font\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[b](.*)\[\/b\]/sU";
        $replacements[] = '\\1';
        $patterns[] = "/\[i](.*)\[\/i\]/sU";
        $replacements[] = '\\1';
        $patterns[] = "/\[u](.*)\[\/u\]/sU";
        $replacements[] = '\\1';
        $patterns[] = "/\[d](.*)\[\/d\]/sU";
        $replacements[] = '\\1';

        $ret = preg_replace($patterns, $replacements, $text);
        $ret = $this->breakLongHalfString($ret);

        return $this->htmlSpecialChars($ret);
    }

    function breakLongHalfString($text)
    {
        $url_pattern = "/[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,%#]{45}/i";
        $url_replacement = "\\0\n";
        return preg_replace($url_pattern, $url_replacement, $text);
    }

}

