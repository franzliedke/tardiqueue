<?php namespace Franzl\Tardiqueue;

use Illuminate\Support\ServiceProvider;

class TardiqueueServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

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

	/**
	 * Get the events that trigger this service provider to register.
	 *
	 * @return array
	 */
	public function when()
	{
		return array('Illuminate\Queue\QueueServiceProvider');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('tardiqueue');
	}

}
