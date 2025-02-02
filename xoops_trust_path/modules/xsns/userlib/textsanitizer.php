<?php
// $Id: module.textsanitizer.php,v 1.8 2006/07/27 00:17:17 onokazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //


//require_once XOOPS_ROOT_PATH.'/class/module.textsanitizer.php';
include_once( XOOPS_ROOT_PATH . '/class/module.textsanitizer.php' ) ;

define('XSNS_URL_LENGTH_MAX', 55);


class XsnsTextSanitizer extends MyTextSanitizer
{
    public $nbsp = 0;
//	var $url_len_max = XSNS_URL_LENGTH_MAX;
	
//	public static function &sGetInstance()
//	{
//		static $instance;
//		if (!isset($instance)) {
//			$instance = new XsnsTextSanitizer();
//		}
//		return $instance;
//	}

    public static function &sGetInstance() {
        static $instance;

        if ( ! isset( $instance ) ) {
            $instance = new self();
        }

        return $instance;
    }

    public static function &getInstance() {
        $instance = &self::sGetInstance();

        return $instance;
    }
	
	function codePreConv($text, $xcode = 1)
	{
 		return $text;
	}
	
	function codeConv($text, $xcode = 1, $image = 1)
	{
            if ($xcode != 0) {
            	$patterns = "/\[code](.*)\[\/code\]/esU";
               	$replacements = "'<div class=\"xoopsCode\"><pre><code>'.'$1'.'</code></pre></div>'";
            	$text = preg_replace($patterns, $replacements, $text);
	    }
 		return $text;
	}
	
	function &xoopsCodeDecode($text, $allowimage = 1)
	{
		$patterns = array();
		$replacements = array();
		
        $patterns[] = "/\[siteurl=(['\"]?)([^\"'<>]*)\\1](.*)\[\/siteurl\]/sU";
        $replacements[] = '<a href="'.XOOPS_URL.'/\\2" target="_blank">\\3</a>';
        $patterns[] = "/\[url=(['\"]?)(http[s]?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '<a href="\\2" target="_blank">\\3</a>';
        $patterns[] = "/\[url=(['\"]?)(ftp?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '<a href="\\2" target="_blank">\\3</a>';
        $patterns[] = "/\[url=(['\"]?)([^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '<a href="http://\\2" target="_blank">\\3</a>';
        $patterns[] = "/\[email]([^;<>\*\(\)\"']*)\[\/email\]/sU";
        $replacements[] = '<a href="mailto:\\1">\\1</a>';
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
        $patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1 id=(['\"]?)([0-9]*)\\3]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img id=(['\"]?)([0-9]*)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[siteimg align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        $patterns[] = "/\[siteimg]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        if ($allowimage != 1) {
            $replacements[] = '<a href="\\3" target="_blank">\\3</a>';
            $replacements[] = '<a href="\\1" target="_blank">\\1</a>';
            $replacements[] = '<a href="'.XOOPS_URL.'/image.php?id=\\4" target="_blank">\\5</a>';
            $replacements[] = '<a href="'.XOOPS_URL.'/image.php?id=\\2" target="_blank">\\3</a>';
            $replacements[] = '<a href="' . XOOPS_URL . '/\\3" target="_blank">' . XOOPS_URL . '/\\3</a>';
            $replacements[] = '<a href="' . XOOPS_URL . '/\\1" target="_blank">' . XOOPS_URL . '/\\1</a>';
        } else {
            $replacements[] = '<img src="\\3" align="\\2" alt="" />';
            $replacements[] = '<img src="\\1" alt="" />';
            $replacements[] = '<img src="'.XOOPS_URL.'/image.php?id=\\4" align="\\2" alt="\\5" />';
            $replacements[] = '<img src="'.XOOPS_URL.'/image.php?id=\\2" alt="\\3" />';
            $replacements[] = '<img src="' . XOOPS_URL . '/\\3" align="\\2" alt="" />';
            $replacements[] = '<img src="' . XOOPS_URL . '/\\1" alt="" />';
        }
	$patterns[] = "/\[quote]/sU";
        $replacements[] = '<div class="paragraph">'._QUOTEC.'<div class="xoopsQuote"><blockquote>';
        $patterns[] = "/\[\/quote]/sU";
        $replacements[] = '</blockquote></div></div>';
        // [quote sitecite=]
        $patterns[] = "/\[quote sitecite=([^\"'<>]*)\]/sU";
        $replacements[] = '<div class="paragraph">'._QUOTEC.'<div class="xoopsQuote"><blockquote cite="'.XOOPS_URL.'/\\1">';
		
		$ret = preg_replace($patterns, $replacements, $text);
		return $ret;
	}
	
	function stripXoopsCode(&$text)
	{
		$patterns = array();
		$replacements = array();
		
        $patterns[] = "/\[siteurl=(['\"]?)([^\"'<>]*)\\1](.*)\[\/siteurl\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[url=(['\"]?)(http[s]?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[url=(['\"]?)(ftp?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[url=(['\"]?)([^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[email]([^;<>\*\(\)\"']*)\[\/email\]/sU";
        $replacements[] = '\\1';

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

        $patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1 id=(['\"]?)([0-9]*)\\3]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img id=(['\"]?)([0-9]*)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[siteimg align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        $patterns[] = "/\[siteimg]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        $replacements[] = '\\3';
        $replacements[] = '\\1';
        $replacements[] = '\\5';
        $replacements[] = '\\3';
        $replacements[] = '\\3';
        $replacements[] = '\\1';

	$patterns[] = "/\[code](.*)\[\/code\]/esU";
	$replacements[] = '\\1';
        $patterns[] = "/\[quote]/sU";
        $replacements[] = '<div class="paragraph">'._QUOTEC.'<div class="xoopsQuote"><blockquote>';
        $patterns[] = "/\[\/quote]/sU";
        $replacements[] = '</blockquote></div></div>';
        // [quote sitecite=]
        $patterns[] = "/\[quote sitecite=([^\"'<>]*)\]/sU";
        $replacements[] = '<div class="paragraph">'._QUOTEC.'<div class="xoopsQuote"><blockquote cite="'.XOOPS_URL.'/\\1">';
		
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
/*	
	function &makeClickable(&$text)
	{
		$patterns = array();
		$replacements = array();
		
		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/])([a-z]+?):\/\/([^, \r\n\"\(\)'<>]+)/i";
		$replacements[] = array(&$this, '_callback_replace_link');
//		  $replacements[] = "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>";

		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/])www\.([a-z0-9\-]+)\.([^, \r\n\"\(\)'<>]+)/i";
		$replacements[] = array(&$this, '_callback_replace_http');
//		  $replacements[] = "\\1<a href=\"http://www.\\2.\\3\" target=\"_blank\">www.\\2.\\3</a>";

		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/])ftp\.([a-z0-9\-]+)\.([^, \r\n\"\(\)'<>]+)/i";
		$replacements[] = array(&$this, '_callback_replace_ftp');
//		  $replacements[] = "\\1<a href=\"ftp://ftp.\\2.\\3\" target=\"_blank\">ftp.\\2.\\3</a>";

		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/:\.])([a-z0-9\-_\.]+?)@([^, \r\n\"\(\)'<>\[\]]+)/i";
		$replacements[] = array(&$this, '_callback_replace_mailto');
//		  $replacements[] = "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>";
		
		for($i=0; $i<count($patterns); $i++){
			$text = preg_replace_callback($patterns[$i], $replacements[$i], $text);
		}
		return $text;
	}
	
	function _callback_replace_link($matches)
	{
		$url = $matches[2]."://".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"".$url."\" target=\"_blank\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}
	
	function _callback_replace_http($matches)
	{
		$url = "www.".$matches[2].".".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"http://".$url."\" target=\"_blank\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}
	
	function _callback_replace_ftp($matches)
	{
		$url = "ftp.".$matches[2].".".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"ftp://".$url."\" target=\"_blank\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}

	function _callback_replace_mailto($matches)
	{
		$url = $matches[2]."@".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"mailto:".$url."\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}
*/
}
