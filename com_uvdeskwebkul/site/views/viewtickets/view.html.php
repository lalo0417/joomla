<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Uvdeskwebkul
 * @author     webkul <support@webkul.com>
 * @copyright  Copyright (C) 2010 webkul.com. All Rights Reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Uvdeskwebkul.
 *
 * @since  1.6
 */
class UvdeskwebkulViewViewtickets extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}
		$user=JFactory::getUser();
		$model=$this->getModel();
		$app=JFactory::getApplication();
		if(isset($user->email)){
			$response=$model->getApiUser($user->email);
			if(count($response->customers)){
				$this->assignRef('customerId',$response->customers[0]->id);	
			}
			else{
				$app->enqueueMessage('You Don"t Have Permission to view this resource','error');
				$app->redirect(JRoute::_('index.php?option=com_uvdeskwebkul&view=login'));
			}
		}else{
			$app->enqueueMessage('Please Login First','error');
			$app->redirect(JRoute::_('index.php?option=com_uvdeskwebkul&view=login'));
		}

		parent::display($tpl);
	}
	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */

	protected function getSortFields()
	{
		return array(
		);
	}
}
