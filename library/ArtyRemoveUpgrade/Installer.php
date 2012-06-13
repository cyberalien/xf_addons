<?php

class ArtyRemoveUpgrade_Installer 
{
	public static function install($existingAddOn)
	{
		$db = XenForo_Application::get('db');

		// Add columns
		self::addColumnIfNotExist($db, 'xf_user_upgrade', 'can_unsubscribe', "int(11) NOT NULL DEFAULT '0'");
	}
	
	public static function uninstall()
	{
		$db = XenForo_Application::get('db');

		// Remove columns
		self::removeColumnIfExist($db, 'xf_user_upgrade', 'can_unsubscribe');
	}	

	/**
	 * Add column to table if it doesn't exist
	 *
	 * @param Zend_Db_Adapter $db Database connection
	 * @param string $table Table name
	 * @param string $field Name of field to add
	 * @param string $attr Field structure
	 *
	 * @return Zend_Db_Statement_Interface
	 */
	public static function addColumnIfNotExist($db, $table, $field, $attr)
	{
		if ($db->fetchRow('SHOW COLUMNS FROM ' . $table . ' WHERE Field = ?', $field))
		{
			return false;
		}

		return $db->query('ALTER TABLE ' . $table . ' ADD ' . $field . ' ' . $attr);
	}

	/**
	 * Remove column from table if it exists
	 *
	 * @param Zend_Db_Adapter $db Database connection
	 * @param string $table Table name
	 * @param string $field Name of field to drop
	 *
	 * @return Zend_Db_Statement_Interface
	 */
	public static function removeColumnIfExist($db, $table, $field)
	{
		if (!$db->fetchRow('SHOW COLUMNS FROM ' . $table . ' WHERE Field = ?', $field))
		{
			return false;
		}

		return $db->query('ALTER TABLE ' . $table . ' DROP ' . $field);
	}
}