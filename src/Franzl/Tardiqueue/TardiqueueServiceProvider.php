<?php namespace Franzl\Tardiqueue;

use Illuminate\Support\ServiceProvider;

class TardiqueueServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;
		
		$app['tardiqueue'] = $this->app->share(function()
		{
			return new Processor;
		});
		
		$app->resolving('queue', function($queue) use ($app)
		{
			$queue->addConnector('delayed', function() use ($app)
			{
				return new DelayedConnector($app['tardiqueue']);
			});
		});
		
		// If Tardiqueue is enabled, make sure all jobs will be executed upon shutdown
		$app->shutdown(function($app)
		{
			$app['tardiqueue']->process();
		});
	}

}
