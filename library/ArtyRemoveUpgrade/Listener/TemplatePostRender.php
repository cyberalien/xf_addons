<?php

class ArtyRemoveUpgrade_Listener_TemplatePostRender
{
	public static function templatePostRender($templateName, &$content, array &$containerData, XenForo_Template_Abstract $template)
	{
		switch ($templateName)
		{
			case 'user_upgrade_edit':
				self::userUpgradeEdit($content, $containerData, $template);
				break;
		}
	}
	
	/**
	 * Appends new options to user_upgrade_edit template output
	 *
	 * @return boolean True if template was changed, false if not
	 */
	public static function userUpgradeEdit(&$content, array &$containerData, XenForo_Template_Abstract $template)
	{
		// Get parameters
		$params = $template->getParams();
		if (!isset($params['upgrade']) || empty($params['upgrade']['user_upgrade_id']))
		{
			return false;
		}
		
		// Add new options after can_purchase option
		$search = '<li><label for="ctrl_can_purchase_1">';
		$pos = strpos($content, $search);
		if ($pos === false)
		{
			return false;
		}
		
		$search = '</li>';
		$pos = strpos($content, $search, $pos);
		if ($pos === false)
		{
			return false;
		}
		$pos += strlen($search);

		$insert = '<li><label for="ctrl_can_unsubscribe_1"><input type="checkbox" name="can_unsubscribe" value="1" id="ctrl_can_unsubscribe_1" ' . ($params['upgrade']['can_unsubscribe'] ? 'checked="checked" ' : '') . '/> ' . new XenForo_Phrase('can_unsubscribe') . '</label></li>';

		$content = substr($content, 0, $pos) . $insert . substr($content, $pos);
		return true;
	}
}
