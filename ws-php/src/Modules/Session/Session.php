<?php

namespace Kevinduy\Modules\Session;

class Session
{
	public static function start()
	{
		$handler = new SessionHandler('/var/session');

		session_set_save_handler($handler, true);

		session_start();
	}
}