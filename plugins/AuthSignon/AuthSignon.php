<?php
class AuthSignon extends ls\pluginmanager\AuthPluginBase
{
	static protected $description = 'Plugin: Signon authentication + exports';
	static protected $name = 'Signon with internal database';

	public function init() {

		/**
		 * Here you should handle subscribing to the events your plugin will handle
		 */
		$this->subscribe('beforeLogin');
		$this->subscribe('newUserSession');
	}

	public function beforeLogin()
	{
		if (! empty($_COOKIE['LS_single_signon_user']) && ! empty($_COOKIE['LS_single_signon_password'])) {
		    $this->setUsername($_COOKIE['LS_single_signon_user']);
			$this->setAuthPlugin(); // This plugin handles authentication, halt further execution of auth plugins
		}
	}

	public function newUserSession()
	{
		// Do nothing if this user is not Authdb type
		$identity = $this->getEvent()->get('identity');
		if ($identity->plugin != 'AuthSignon')
		{
			return;
		}

		$username = '';
		if (! empty($_COOKIE['LS_single_signon_user'])) {
			$username = $_COOKIE['LS_single_signon_user'];
			$_COOKIE['LS_single_signon_user'] = '';
			setcookie('LS_single_signon_user', '', time() - 60 * 100000, '/');
		}
		$password = '';
		if (! empty($_COOKIE['LS_single_signon_password'])) {
			$password = $_COOKIE['LS_single_signon_password'];
			$_COOKIE['LS_single_signon_password'] = '';
			setcookie('LS_single_signon_password', '', time() - 60 * 100000, '/');
		}

		$user = $this->api->getUserByName($username);

		if ($user !== null && $user->uid != 1 && !Permission::model()->hasGlobalPermission('auth_db','read',$user->uid))
		{
			$this->setAuthFailure(self::ERROR_AUTH_METHOD_INVALID, gT('Internal database authentication method is not allowed for this user'));
			return;
		}
		if ($user !== null and $username==$user->users_name) // Control of equality for uppercase/lowercase with mysql
		{
			if (gettype($user->password)=='resource')
			{
				$sStoredPassword=stream_get_contents($user->password,-1,0);  // Postgres delivers bytea fields as streams :-o
			}
			else
			{
				$sStoredPassword=$user->password;
			}
		}
		else
		{
			$this->setAuthFailure(self::ERROR_USERNAME_INVALID);
			return;
		}

		if ($sStoredPassword !== hash('sha256', $password))
		{
			$this->setAuthFailure(self::ERROR_PASSWORD_INVALID);
			return;
		}

		$this->setAuthSuccess($user);
	}
}