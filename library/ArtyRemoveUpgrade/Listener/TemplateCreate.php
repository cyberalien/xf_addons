<?php

class ArtyRemoveUpgrade_Listener_TemplateCreate
{
	public static function templateCreate($templateName, array &$params, XenForo_Template_Abstract $template)
	{
		switch ($templateName)
		{
			case 'account_upgrades':
				if (!empty($params['alternative']))
				{
					$templateName = 'account_upgrades_alternative';
					return;
				}
				foreach ($params['purchased'] as $upgrade)
				{
					if (!empty($upgrade['can_unsubscribe']))
					{
						$templateName = 'account_upgrades_alternative';
						return;
					}
				}
				return;
		}
	}
}
