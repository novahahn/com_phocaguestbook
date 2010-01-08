<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.folder' );

function com_uninstall()
{
//	db			=& JFactory::getDBO();
//	$db_prefix 	= $db->getPrefix();
	
//	$message  = '';				   
/*	$message .= '<p><b><span style="color:#009933">Database tables:</span><br />'
				. '- ' . $db_prefix . 'phocaguestbook_items<br />'
				. '- ' . $db_prefix . 'phocaguestbook_books<br />'
				.'<span style="color:#009933">were not deleted</span> because of possible upgrading of Phoca Guestbook component.</b> Please delete it manually, if you want.</p>';
	*/
	
/*	if (in_array(1, $error))
	{
		return false;
	}
	else
	{
		return true;
	}*/
/*	
	$message .= '<p>' . JText::_('Phoca Gallery Remove or not Remove') .'</p>';
	echo $message;
	echo '<center>';
	echo '<div style="padding:20px;border:1px solid#ff8000;background:#fff">';
	echo '<table border="0" cellpadding="20" cellspacing="20"><tr>';
	echo '<td align="center" valign="middle"><a href="index.php?option=com_phocagallery&amp;controller=phocagalleryuninstall&amp;task=remove"><img src="components/com_phocagallery/assets/images/install.png" alt="Remove" /></a></td>';
	echo '<td align="center" valign="middle"><a href="index.php?option=com_phocagallery&amp;controller=phocagalleryuninstall&amp;task=keep"><img src="components/com_phocagallery/assets/images/upgrade.png" alt="Not remove" /></a></td>';
	echo '</tr></table>';
	echo '</div></center>';
	
	echo '<p>&nbsp;</p><p>&nbsp;</p>';
	echo '<div style="padding:20px;border:1px solid#0080c0;background:#fff">';
	echo '<p><img src="components/com_phocagallery/assets/images/logo.png" alt="www.phoca.cz" /></p>';
	echo '<center><a style="text-decoration:underline" href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></center>';
	echo '</div>';*/
	
//	echo $message;
}

?>