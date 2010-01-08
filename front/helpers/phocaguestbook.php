<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Guestbook
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

class PhocaguestbookHelper
{
	function setTinyMCEJS()
	{
		$js = "\t<script type=\"text/javascript\" src=\"".JURI::root()."plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js\"></script>\n";
		return $js;
	}
	
	function setCaptchaReloadJS()
	{
	/*	$js = "\t". '<script type="text/javascript">function reloadCaptcha() {    var capObj = document.getElementById(\'phocacaptcha\');    if (capObj) {        capObj.src = capObj.src +            (capObj.src.indexOf(\'?\') > -1 ? \'&\' : \'?\') + Math.random();    }} </script>' . "\n";
		*/
		$js  = "\t". '<script type="text/javascript">'."\n".'var pcid = 0;'."\n"
		     . 'function reloadCaptcha() {' . "\n"
			 . 'now = new Date();' . "\n"
			 . 'var capObj = document.getElementById(\'phocacaptcha\');' . "\n"
			 . 'if (capObj) {' . "\n"
			 . 'capObj.src = capObj.src + (capObj.src.indexOf(\'?\') > -1 ? \'&amp;pcid[\'+ pcid +\']=\' : \'?pcid[\'+ pcid +\']=\') + Math.ceil(Math.random()*(now.getTime()));' . "\n"
			 . 'pcid++;' . "\n"
			 . ' }' . "\n"
			 . '}'. "\n"
			 . '</script>' . "\n";
			
			return $js;
	}
	
	
	function displaySimpleTinyMCEJS()
	{		
		$js =	'<script type="text/javascript">' . "\n";
		$js .= 	 'tinyMCE.init({'. "\n"
					.'mode : "textareas",'. "\n"
					.'theme : "advanced",'. "\n"
					.'language : "en",'. "\n"
					.'plugins : "emotions",'. "\n"
					.'editor_selector : "mceEditor",'. "\n"					
					.'theme_advanced_buttons1 : "bold, italic, underline, separator, strikethrough, justifyleft, justifycenter, justifyright, justifyfull, bullist, numlist, undo, redo, link, unlink, separator, emotions",'. "\n"
					.'theme_advanced_buttons2 : "",'. "\n"
					.'theme_advanced_buttons3 : "",'. "\n"
					.'theme_advanced_toolbar_location : "top",'. "\n"
					.'theme_advanced_toolbar_align : "left",'. "\n"
					.'theme_advanced_path_location : "bottom",'. "\n"
					.'extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});' . "\n";
		$js .=	'</script>';
		return $js;

	}
	
	function displayTextArea($name='content',$content='', $width=50, $height=50, $col=10, $row=10, $buttons = false)
	{
		if (is_numeric( $width )) {
			$width .= 'px';
		}
		if (is_numeric( $height )) {
			$height .= 'px';
		}
		$editor  = "<textarea id=\"$name\" name=\"$name\" cols=\"$col\" rows=\"$row\" style=\"width:{$width}; height:{$height};\" class=\"mceEditor\">$content</textarea>\n" . $buttons;

		return $editor;
	}
	
	function setP($new) {
		if ($new == 1) {
			$new = '<'.'d'.'i'.'v'.' '.'s'.'t'.'y'.'l'.'e'.'='.'"'.'m'.'a'.'r'.'g'.'i'.'n'.':'.'1'.'0'.'p'.'x'.';'.'t'.'e'.'x'.'t'.'-'.'a'.'l'.'i'.'g'.'n'.':'.'r'.'i'.'g'.'h'.'t'.'"'.'>'.'<'.'a'.' h'.'r'.'e'.'f'.'='.'"'.'h'.'t'.'t'.'p'.':'.'/'.'/'.'w'.'w'.'w'.'.'.'p'.'h'.'o'.'c'.'a'.'.'.'c'.'z'.'/'.'p'.'h'.'o'.'c'.'a'.'g'.'u'.'e'.'s'.'t'.'b'.'o'.'o'.'k'.''.'"'.' '.'t'.'a'.'r'.'g'.'e'.'t'.'='.'"'.'_'.'b'.'l'.'a'.'n'.'k'.'"'.'>'.'P'.'h'.'o'.'c'.'a'.' '.'G'.'u'.'e'.'s'.'t'.'b'.'o'.'o'.'k'.'<'.'/'.'a'.'>'.'<'.'/'.'d'.'i'.'v'.'>';
		} else {
			$new = '';
		}
		return $new;
	}
	
	function wordDelete($string,$length,$end)
	{
		if (JString::strlen($string) < $length || JString::strlen($string) == $length)
		{
			return $string;
		}
		else
		{
			return JString::substr($string, 0, $length) . $end;
		}
	}
}
?>