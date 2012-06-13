<?php

class ArtyRemoveUpgrade_Listener_LoadClassDataWriter
{
	public static function loadClassListener($class, &$extend)
	{
		if ($class == 'XenForo_DataWriter_UserUpgrade')
		{
			$extend[] = 'ArtyRemoveUpgrade_DataWriter_UserUpgrade';
		}
	}
}
