<?php
/**
 * registeredOnly plugin
 * 
 * @original author   Antonio Durán Terrés
 *
 * @author      Charlie Lodder
 * @version     1.0.0
 * @license     GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 * Forked from  http://extensions.joomla.org/extensions/extension/access-a-security/site-access/registeredonly
 */

defined('_JEXEC') or die('Restricted access');

class plgSystemRegisteredonly extends JPlugin
{
	public function onAfterRoute() 
	{
		$app   = JFactory::getApplication('site');
		$input = $app->input;
		$user  = JFactory::getUser();

		// Do nothing if in backend or user is logged in
		if ($app->isAdmin() || !$user->guest)
		{
			return;
		}

		// Get the component, view and task
		$option = $input->get('option');
		$view   = $input->get('view');
		$task   = $input->get('task');

		// If user is logging, registering or requesting user/pass, dont redirect
		if (($option == 'com_users') && (($task == 'login') || ($task == 'register_save') || ($task = 'remindusername') || ($task == 'requestreset')))
		{
			return;
		}

		// If user is at login form, registering or recovering user/password, dont redirect
		if (($option == 'com_users') && (($view == 'login') || ($view == 'reset') || ($view == 'remind') || ($view == 'register')))
		{
			return;
		}

		$app->redirect(JUri::base() . 'index.php?option=com_users&view=login', 'You must be logged in to access this site');
	}
}
