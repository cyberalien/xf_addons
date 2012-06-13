<?php

class ArtyRemoveUpgrade_ControllerPublic_Account extends XFCP_ArtyRemoveUpgrade_ControllerPublic_Account
{
	/**
	 * Displays a list of available account upgrades.
	 *
	 * @return XenForo_ControllerResponse_Abstract
	 */
	public function actionUpgrades()
	{
		/* @var $upgradeModel XenForo_Model_UserUpgrade */
		$upgradeModel = $this->getModelFromCache('XenForo_Model_UserUpgrade');
		$purchaseList = $upgradeModel->getUserUpgradesForPurchaseList();

		if (!$purchaseList['available'] && !$purchaseList['purchased'])
		{
			return $this->responseMessage(new XenForo_Phrase('no_account_upgrades_can_be_purchased_at_this_time'));
		}

		$viewParams = array(
			'available' => $upgradeModel->prepareUserUpgrades($purchaseList['available']),
			'purchased' => $upgradeModel->prepareUserUpgrades($purchaseList['purchased']),
			'alternative' => $upgradeModel->prepareUserUpgrades($purchaseList['alternative']),
			//'payPalUrl' => 'https://www.sandbox.paypal.com/cgi-bin/websrc',
			'payPalUrl' => 'https://www.paypal.com/cgi-bin/websrc',
		);

		return $this->_getWrapper(
			'account', 'upgrades',
			$this->responseView('XenForo_ViewPublic_Account_Upgrades', 'account_upgrades', $viewParams)
		);
	}

	public function actionRemoveUpgrade()
	{
		$userUpgradeId = $this->_input->filterSingle('user_upgrade_id', XenForo_Input::UINT);
		if (!$userUpgradeId)
		{
			return $this->responseError(new XenForo_Phrase('invalid_argument'));
		}

		/* @var $upgradeModel XenForo_Model_UserUpgrade */
		$upgradeModel = $this->getModelFromCache('XenForo_Model_UserUpgrade');
		$purchaseList = $upgradeModel->getUserUpgradesForPurchaseList();
		
		if (!$purchaseList['purchased'] || !isset($purchaseList['purchased'][$userUpgradeId]))
		{
			return $this->responseError(new XenForo_Phrase('requested_user_upgrade_not_found'));
		}

		$userUpgrade = $purchaseList['purchased'][$userUpgradeId];
		if (!$userUpgrade['can_unsubscribe'])
		{
			return $this->responseError(new XenForo_Phrase('you_cannot_remove_this_upgrade'));
		}

		if ($this->isConfirmedPost())
		{
			$upgradeModel->downgradeUserUpgrade($userUpgrade['record']);

			return $this->responseRedirect(
				XenForo_ControllerResponse_Redirect::SUCCESS,
				XenForo_Link::buildPublicLink('account/upgrades')
			);
		}
		else
		{
			$viewParams = array(
				'upgrade' => $upgradeModel->prepareUserUpgrade($userUpgrade),
				//'payPalUrl' => 'https://www.sandbox.paypal.com/cgi-bin/websrc',
				'payPalUrl' => 'https://www.paypal.com/cgi-bin/websrc',
			);

			return $this->responseView('XenForo_ViewPublic_Account_Upgrades', 'account_upgrades_confirm_remove', $viewParams);
		}
	}
}