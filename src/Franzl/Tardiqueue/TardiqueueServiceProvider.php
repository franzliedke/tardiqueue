<?php namespace Franzl\Tardiqueue;

use Illuminate\Support\ServiceProvider;

class TardiqueueServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app['queue']->addConnector('delayed', function()
		{
			return new DelayedConnector;
		});

		// If Tardiqueue is enabled, make sure all jobs will be executed upon shutdown
		if ($this->app['config']['queue.default'] == 'delayed')
		{
			$this->app->shutdown(function($app)
			{
				$app['queue']->fireAll();
			});
		}
	}

}