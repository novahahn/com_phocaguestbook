<?php // no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.utilities.date');
jimport('joomla.html.pane');
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'phocaguestbook.php' );
?><script language="javascript" type="text/javascript">
<!--
		function submitbutton() {
			var novalues='';
			var form = document.saveForm;
			var text = tinyMCE.getContent();
			if (novalues!=''){}
			<?php
			if ($this->require['title']== 1) {?>
			else if ( form.title.value == "" ) {
				alert("<?php echo JText::_( 'Phoca Guestbook No Title', true); ?>");return false;} <?php }
			if ($this->require['username']== 1){?>
			else if( form.pgusername.value == "" ) {
				alert("<?php echo JText::_( 'Phoca Guestbook No Username', true); ?>");return false;}<?php }
			if ($this->require['email']== 1){?>
			else if( form.email.value == "" ) {
				alert("<?php echo JText::_( 'Phoca Guestbook No Email', true); ?>");return false;}<?php }
			if ($this->require['content']== 1){?>
			else if( text == "" ) {
				alert("<?php echo JText::_( 'Phoca Guestbook No Content', true); ?>");return false;}<?php } ?>
		}
		--></script><?php
		
if ( $this->params->get( 'show_page_title' ) ) : 
	?><h1 class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo $this->params->get( 'page_title' );?>
	</h1><?php
endif;

?><div class="contentpane<?php echo $this->params->get( 'pageclass_sfx' ); ?>"><?php

if ( @$this->image || @$this->guestbooks->description ) :
	?><div class="contentdescription<?php echo $this->params->get( 'pageclass_sfx' ); ?>"><?php
		if ( isset($this->image) ) :  echo $this->image; endif;
		echo $this->guestbooks->description;
	?></div><?php
	endif; 

?></div><div id="phocaguestbook"><?php // <div style="clear:both"></div>


//Form 2
$form2 = '<p>&nbsp;</p><div><form action="'.$this->action.'" method="post" name="adminForm" id="pgbadminForm">';
if (count($this->items)) {
	$form2 .='<center>';
	if ($this->params->get('show_pagination_limit')) {
		
		$form2 .= '<span style="margin:0 10px 0 10px">'.JText::_('Display Num') .'&nbsp;'.$this->pagination->getLimitBox().'</span>';
	}
	
	if ($this->params->get('show_pagination')) {
	
		$form2 .= '<span style="margin:0 10px 0 10px" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" >'.$this->pagination->getPagesLinks().'</span><span style="margin:0 10px 0 10px" class="pagecounter">'.$this->pagination->getPagesCounter().'</span>';
	}
	$form2 .='</center>';
}
$form2 .= '</form></div>'.$this->tmpl['pf'];

// Create and correct Messages (Posts, Items)--------------------------------------------------------------------------
$msgpg = '';//Messages (Posts, Items)

foreach ($this->items as $key => $values) {
	
	//Maximum of links in the message
	$rand 				= '%phoca' . mt_rand(0,1000) * time() . 'phoca%';
	$ahref_replace 		= "<a ".$rand."=";
	$ahref_search		= "/<a ".$rand."=/";
	$values->content	= preg_replace ("/<a href=/", $ahref_replace, $values->content, $this->config['maxurl']);
	$values->content	= preg_replace ("/<a href=.*?>(.*?)<\/a>/",	"$1", $values->content);
	$values->content	= preg_replace ($ahref_search, "<a href=", $values->content);
	
	//Forbidden Word Filter
	foreach ($this->fwfa as $key2 => $values2) {
		if (function_exists('str_ireplace')) {
			$values->username 	= str_ireplace (trim($values2), '***', $values->username);
			$values->title		= str_ireplace (trim($values2), '***', $values->title);
			$values->content	= str_ireplace (trim($values2), '***', $values->content);
			$values->email		= str_ireplace (trim($values2), '***', $values->email);
		} else {		
			$values->username 	= str_replace (trim($values2), '***', $values->username);
			$values->title		= str_replace (trim($values2), '***', $values->title);
			$values->content	= str_replace (trim($values2), '***', $values->content);
			$values->email		= str_replace (trim($values2), '***', $values->email);
		}
	}
	
	//Forbidden Whole Word Filter
	foreach ($this->fwwfa as $key3 => $values3) {
		if ($values3 !='') {
			//$values3			= "/([\. ])".$values3."([\. ])/";
			$values3			= "/(^|[^a-zA-Z0-9_]){1}(".preg_quote(($values3),"/").")($|[^a-zA-Z0-9_]){1}/i";
			$values->username 	= preg_replace ($values3, "\\1***\\3", $values->username);// \\2
			$values->title		= preg_replace ($values3, "\\1***\\3", $values->title);
			$values->content	= preg_replace ($values3, "\\1***\\3", $values->content);
			$values->email		= preg_replace ($values3, "\\1***\\3", $values->email);
		}
	}
	
	//Hack, because Joomla add some bad code to src and href
	if (function_exists('str_ireplace')) {
			$values->content	= str_ireplace ('../plugins/editors/tinymce/', 'plugins/editors/tinymce/', $values->content);
		} else {		
			$values->content	= str_replace ('../plugins/editors/tinymce/', 'plugins/editors/tinymce/', $values->content);
		}
		
	
	$msgpg .= '<div style="border:1px solid '.$this->css['bordercolor'].';color:'.$this->css['fontcolor'].';margin:10px 0px;">';
	$msgpg .= '<h4 style="background:'.$this->css['backgroundcolor'].';color:'.$this->css['fontcolor'].';padding:8px;margin:2px;">';
	
	//!!! username saved in database can be username or name
	$sep = 0;
	if ($this->display['username'] != 0) {
		if ($values->username != '') {
			$msgpg .= PhocaguestbookHelper::wordDelete($values->username,25,'...');
			$sep = 1;
		}
	}
	
	if ($this->display['email'] != 0) {
		if ($values->email != '') {
			if ($sep == 1) {
				$msgpg .= ' ';
				$msgpg .= '( '. JHTML::_( 'email.cloak', PhocaguestbookHelper::wordDelete($values->email,35,'...') ).' )';
				$sep = 1;
			} else {
				$msgpg .= JHTML::_( 'email.cloak', PhocaguestbookHelper::wordDelete($values->email,35,'...') );
				$sep = 1;
			}
		}
	}
	
	if ($values->title != '') {
		if ($values->title != '') {
			if ($sep == 1) {$msgpg .= ': ';}
			$msgpg .= PhocaguestbookHelper::wordDelete($values->title,40,'...');
		}
	}

	// SECURITY
	// Open a tag protection
	$a_count 		= substr_count(strtolower($values->content), "<a");
	$a_end_count 	= substr_count(strtolower($values->content), "</a>");
	$quote_count	= substr_count(strtolower($values->content), "\"");
	
	if ($quote_count%2!=0) {
		$end_quote = "\""; // close the " if it is open
	} else {
		$end_quote = "";
	}
	
	if ($a_count > $a_end_count) {
		$end_a = "></a>"; // close the a tag if there is a open a tag
						  // in case <a href> ... <a href ></a>
						  // in case <a ... <a href >></a>
	} else {
		$end_a = "";
	}
	
	
	$msgpg .= '</h4>';
	$msgpg .= '<div style="overflow:auto; border-left:5px solid '.$this->css['backgroundcolor'].'; padding-left:5px;margin:10px;">' . $values->content . $end_quote .$end_a. '</div>';
	$msgpg .= '<p align="right" style="padding-right:10px;"><small style="color:'.$this->css['secondfontcolor'].'">' . JHTML::_('date',  $values->date, JText::_( $this->tmpl['date_format'] ) ) . '</small>';
	

	if ($this->administrator != 0) {
		$msgpg.='<a href="'.JRoute::_('index.php?option=com_phocaguestbook&view=phocaguestbook&id='.$this->id.'&Itemid='.$this->itemid.'&controller=phocaguestbook&task=delete&mid='.$values->id.'&limitstart='.$this->pagination->limitstart).'" onclick="return confirm(\''.JText::_( 'Delete Message' ).'\');">'.JHTML::_('image', 'components/com_phocaguestbook/assets/images/icon-trash.gif', JText::_( 'Delete' )).'</a>';
		
		$msgpg.='<a href="'.JRoute::_('index.php?option=com_phocaguestbook&view=phocaguestbook&id='.$this->id.'&Itemid='.$this->itemid.'&controller=phocaguestbook&task=unpublish&mid='.$values->id.'&limitstart='.$this->pagination->limitstart).'">'.JHTML::_('image', 'components/com_phocaguestbook/assets/images/icon-unpublish.gif', JText::_( 'Unpublish' )).'</a>';
	}
	$msgpg.='</p></div>';	
}

//--Messages (Posts, Items) --------------------------------------------------------------------------------

// Form 1
// Display Messages (Posts, Items) -------------------------------------------------------------------------
// Forms (If position = 1 --> Form is bottom, Messages top, if position = 0 --> Form is top, Messages bottom
if ($this->config['position'] == 1) {
	echo $msgpg;
}

// Display or not to display the form - only for registered user, IP Ban------------------------------------
$show_form = 1;// Display it

if ($this->ipa == 0) 	{$show_form = 0;$ipa_msg = JText::_('Phoca Guestbook IP Ban No Access');}
else 					{$ipa_msg = '';} 
if ($this->reguser == 0){$show_form = 0;$reguser_msg = JText::_('Phoca Guestbook Reg User Only No Access');}
else 					{$reguser_msg = '';} 

if ($show_form == 1) {

	// Display Pane or not
	if ($this->tmpl['displayform'] == 0 ) {
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane("phocaguestbook-pane");
		
		// if user posted a message and get some error warning (captcha, ...) the form should be open	
		if ($this->error_msg_captcha == '' && $this->error_msg_top == '') {
			echo '<div style="display:none">';//because of IE
			echo $pane->startPanel( '', 'phocaguestbook-jpane-none' );
			echo $pane->endPanel();
			echo '</div>';
		}
		echo $pane->startPanel( JText::_('Post message'), 'phocaguestbook-jpane-toggler-down' );
	}

	?><form action="<?php echo $this->action; ?>" method="post" name="saveForm" id="pgbSaveForm" onsubmit="return submitbutton();">

	<?php
		if ($this->error_msg_top !='') {
			//-- Server side checking 
			echo $this->error_msg_top;
			//-- Server side checking
		}
		
		if ($this->display['formusername']){
			?><div class="pginputdiv">
				<label for="pgusername"><?php echo Jtext::_('Name'); ?></label>
				<input type="text" name="pgusername" id="pgusername" value="<?php echo $this->formdata->username ?>" size="32" maxlength="100" />
				</div>
				<?php
		}
		
		if ($this->display['formemail']) {
			?><div class="pginputdiv">
				<label for="email"><?php echo JText::_('Email'); ?></label>
				<input type="text" name="email" id="pgbemail" value="<?php echo $this->formdata->email ?>" size="32" maxlength="100" />
			</div>
			<?php
		}?>
			<div class="pginputdiv">
			<label for="pgbcontent"><?php echo JText::_('Content'); ?></label>
			<?php echo $this->editor;?>
			</div>
		<?php		
		if ($this->enablecaptcha > 0) {
                        
			// Server side checking CAPTCHA 
			echo $this->error_msg_captcha;
			//-- Server side checking CAPTCHA
			
			// Set fix height because of pane slider
			$imageHeight = 'style="height:105px"';
                        if ($this->recaptchakey == '') { //TODO: Refactor to CSS layout first
			?><tr>
                                <td width="5"><b><?php echo JText::_('Image Verification'); ?>: </b></td>		
				<td width="5" align="left" valign="middle" <?php echo $imageHeight ?>><?php
				

				if ($this->tmpl['captchamethod'] == 1) {
				
					?>
					<img src="<?php echo JRoute::_('index.php?option=com_phocaguestbook&view=phocaguestbooki&id='.$this->id.'&Itemid='.$this->itemid.'&phocasid='. md5(uniqid(time()))) ; ?>" alt="<?php JText::_('Captcha Image'); ?>" id="phocacaptcha" /><?php
				} else {
					echo JHTML::_( 'image.site','index.php?option=com_phocaguestbook&amp;view=phocaguestbooki&amp;id='.$this->id.'&amp;Itemid='.$this->itemid.'&amp;phocasid='. md5(uniqid(time())), '', '','',JText::_('Captcha Image'), array('id' => 'phocacaptcha'));
				
				}
				?></td>
				
				<td width="5" align="left" valign="middle"><input type="text" id="pgbcaptcha" name="captcha" size="6" maxlength="6" style="border:1px solid #cccccc"/></td>
				
				<td align="center" width="50" valign="middle"><a <?php //Remove because of IE6 - href="javascript:void(0)" onclick="javascript:reloadCaptcha();" ?> href="javascript:reloadCaptcha();" title="<?php echo JText::_('Reload Image'); ?>" ><?php echo JHTML::_( 'image.site', 'components/com_phocaguestbook/assets/images/icon-reload.gif', '', '','',JText::_('Reload Image')); ?></a></td>

			</tr>
		
		      <?php
                        } else
                                {
					require_once( JPATH_COMPONENT.DS.'assets'.DS.'library'.DS.'recaptchalib.php');
					echo "<script>var RecaptchaOptions = {lang:'de'};</script>";
					echo recaptcha_get_html($this->recaptchakey);
                                }
                      } 		
		?>
			<div><input type="submit" name="save" value="<?php echo JText::_('Submit'); ?>" /> &nbsp;<input type="reset" name="reset" value="<?php echo JText::_('Reset'); ?>" /></div>
	<input type="hidden" name="cid" value="<?php echo $this->id ?>" />
	<input type="hidden" name="option" value="com_phocaguestbook" />
	<input type="hidden" name="view" value="phocaguestbook" />
	<input type="hidden" name="controller" value="phocaguestbook" />
	<input type="hidden" name="task" value="submit" />
	<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
	</form><div style="clear:both;">&nbsp;</div><?php
	
	// Display Pane or not
	if ($this->tmpl['displayform'] == 0 ) {
		echo $pane->endPanel();
		echo $pane->endPane();
	}
	
}//-- Display or not to display Form, Registered user only, IP Ban
else {
	// Show messages (Only registered user, IP Ban)
	if ($ipa_msg !='') 		{echo '<p>'. $ipa_msg . '</p>';}
	if ($reguser_msg !='') 	{echo '<p>'. $reguser_msg . '</p>';}
}

//---------------------------------------------------------------------------------------------------------
//Forms (If position = 1 --> Form is bottom, Messages top, if position = 0 --> Form is top, Messages bottom
if ($this->config['position'] == 0) {
	echo $msgpg;
}
//--Form 1
// Form2
echo $form2;
if (1) // TODO: put in the right place, only if selected in admin panel
{
}
?></div>
