<?php namespace Franzl\Tardiqueue;

use Illuminate\Queue\Connectors\ConnectorInterface;

class DelayedConnector implements ConnectorInterface {

	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Queue\QueueInterface
	 */
	public function connect(array $config)
	{
		return new DelayedQueue;
	}

}