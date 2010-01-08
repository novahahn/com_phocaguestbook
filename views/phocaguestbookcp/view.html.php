<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');

class PhocaGuestbookCpViewPhocaGuestbookcp extends JView
{
	function display($tpl = null) {
		
		JHTML::stylesheet( 'phocaguestbook.css', 'administrator/components/com_phocaguestbook/assets/' );
		
		global $mainframe;
		$uri		=& JFactory::getURI();
		$document	=& JFactory::getDocument();
		$db		    =& JFactory::getDBO();
		
		

		JToolBarHelper::title(   '&nbsp;&nbsp;' .JText::_( 'Phoca Guestbook Control Panel' ), 'phoca' );
		
		JToolBarHelper::preferences('com_phocaguestbook', '460');
		JToolBarHelper::help( 'screen.phocaguestbook', true );

		JHTML::_('behavior.tooltip');
		$version = PhocaGuestbookHelper::getPhocaVersion();
		$this->assignRef('version',	$version);
		
		parent::display($tpl);
	}
}
?>