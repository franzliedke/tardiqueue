<?php namespace Franzl\Tardiqueue;

class Processor {

	/**
	 * The array of registered queues.
	 *
	 * @var array
	 */
	protected $queues = array();

	/**
	 * Register a queue to process.
	 *
	 * @param  \Franzl\Tardiqueue\DelayedQueue  $queue
	 */
	public function register(DelayedQueue $queue)
	{
		$this->queues[] = $queue;
	}

	/**
	 * Process all registered queues.
	 *
	 * @return void
	 */
	public function process()
	{
		foreach ($this->queues as $queue)
		{
			$queue->fireAll();
		}
	}

}