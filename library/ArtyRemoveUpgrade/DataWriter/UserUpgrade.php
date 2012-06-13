<?php

/**
* Data writer for user upgrades.
*/
class ArtyRemoveUpgrade_DataWriter_UserUpgrade extends XFCP_ArtyRemoveUpgrade_DataWriter_UserUpgrade
{
	/**
	* Gets the fields that are defined for the table. See parent for explanation.
	*
	* @return array
	*/
	protected function _getFields()
	{
		$fields = parent::_getFields();

		$fields['xf_user_upgrade']['can_unsubscribe'] = array('type' => self::TYPE_BOOLEAN, 'default' => 0);

		return $fields;
	}

}