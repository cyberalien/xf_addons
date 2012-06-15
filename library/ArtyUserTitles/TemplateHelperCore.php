<?php

class ArtyUserTitles_TemplateHelperCore extends XenForo_Template_Helper_Core
{
	/**
	 * Helper to get the user title for the specified user.
	 *
	 * @param array $user
	 * @param boolean $allowCustomTitle Allows the user title to come from the custom title
	 *
	 * @return string
	 */
	public static function helperUserTitle($user, $allowCustomTitle = true)
	{
		if (!is_array($user) || !array_key_exists('display_style_group_id', $user))
		{
			return '';
		}

		if ($allowCustomTitle && !empty($user['custom_title']))
		{
			return htmlspecialchars($user['custom_title']);
		}

		if (empty($user['user_id']))
		{
			$user['display_style_group_id'] = XenForo_Model_User::$defaultGuestGroupId;
		}

		if (isset($user['display_style_group_id']) && isset(self::$_displayStyles[$user['display_style_group_id']]))
		{
			$style = self::$_displayStyles[$user['display_style_group_id']];
			if ($style['user_title'] !== '')
			{
				return $style['user_title'];
			}
		}

		if (empty($user['user_id']) || !isset($user['message_count']))
		{
			return ''; // guest user title or nothing
		}

		foreach (self::$_userTitles AS $points => $title)
		{
			if ($user['message_count'] >= $points)
			{
				return $title;
			}
		}

		return '';
	}

}