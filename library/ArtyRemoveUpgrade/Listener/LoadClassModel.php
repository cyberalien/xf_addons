<?php

class ArtyRemoveUpgrade_Listener_LoadClassModel
{
	public static function loadClassListener($class, &$extend)
	{
		if ($class == 'XenForo_Model_UserUpgrade')
		{
			$extend[] = 'ArtyRemoveUpgrade_Model_UserUpgrade';
		}
	}
}
