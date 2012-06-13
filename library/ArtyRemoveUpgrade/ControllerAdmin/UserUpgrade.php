<?php

class ArtyRemoveUpgrade_ControllerAdmin_UserUpgrade extends XFCP_ArtyRemoveUpgrade_ControllerAdmin_UserUpgrade
{
	/**
	 * Gets the upgrade add/edit form response.
	 *
	 * @param array $upgrade
	 *
	 * @return XenForo_ControllerResponse_View
	 */
	protected function _getUpgradeAddEditResponse2(array $upgrade)
	{
		// Add new parameters
		if (isset($upgrade['can_purchase']) && !isset($upgrade['can_unsubscribe']))
		{
			$upgrade['can_unsubscribe'] = 0;
		}

		// Call parent
		return parent::_getUpgradeAddEditResponse($upgrade);
	}

	/**
	 * Inserts a new upgrade or updates an existing one.
	 *
	 * @return XenForo_ControllerResponse_Abstract
	 */
	public function actionSave()
	{
		// Change new parameters
		$this->_assertPostOnly();

		$userUpgradeId = $this->_input->filterSingle('user_upgrade_id', XenForo_Input::UINT);
		if ($userUpgradeId)
		{
			$input = $this->_input->filter(array(
				'can_unsubscribe' => XenForo_Input::UINT,
			));
	
			$dw = XenForo_DataWriter::create('XenForo_DataWriter_UserUpgrade');
			$dw->setExistingData($userUpgradeId);
			$dw->bulkSet($input);
			$dw->save();
		}

		// Call parent to change other parameters
		return parent::actionSave();
	}
}