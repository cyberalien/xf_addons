<?php

class ArtyRemoveUpgrade_Listener_LoadClassController
{
	public static function loadClassListener($class, &$extend)
	{
		if ($class == 'XenForo_ControllerAdmin_UserUpgrade')
		{
			$extend[] = 'ArtyRemoveUpgrade_ControllerAdmin_UserUpgrade';
		}
		if ($class == 'XenForo_ControllerPublic_Account')
		{
			$extend[] = 'ArtyRemoveUpgrade_ControllerPublic_Account';
		}
	}
}
