<?php

class ArtyRemoveUpgrade_Model_UserUpgrade extends XFCP_ArtyRemoveUpgrade_Model_UserUpgrade
{
	/**
	 * Gets a list of upgrades that are applicable to the specified user.
	 *
	 * @param array|null $viewingUser
	 *
	 * @return array
	 * 		[available] -> list of upgrades that can be purchased,
	 * 		[purchased] -> list of purchased, with [record] key inside for specific info
	 *		[alternative] -> list of upgrades that could be purchased if one of other upgrades (see "blocked_by" row) is removed
	 */
	public function getUserUpgradesForPurchaseList(array $viewingUser = null)
	{
		$result = parent::getUserUpgradesForPurchaseList($viewingUser);
		
		if (!isset($result['alternative']))
		{
			$result['alternative'] = array();
		}

		$this->standardizeViewingUserReference($viewingUser);
		if (empty($result['purchased']) || !$viewingUser['user_id'] || !($upgrades = $this->getAllUserUpgrades()))
		{
			return $result;
		}

		// Find upgrades that can be canceled
		foreach ($result['purchased'] AS $upgradeId => $upgrade)
		{
			if (!empty($upgrade['can_unsubscribe']) && strlen($upgrade['disabled_upgrade_ids']))
			{
				foreach (explode(',', $upgrade['disabled_upgrade_ids']) AS $disabledId)
				{
					if (!isset($result['available'][$disabledId]) && !isset($result['purchased'][$disabledId]) && isset($upgrades[$disabledId]))
					{
						$result['alternative'][$disabledId] = $upgrades[$disabledId] + array(
								'blocked_by' => $upgrade['title']
							);
					}
				}
			}
		}

		return $result;
	}
}