<?php declare(strict_types=1);

namespace coro\Fio;

use coro\Fio\Exceptions\InvalidState;

if (Utils\Strings::is32bitOS()) {
	throw new InvalidState('This library does not support 32bit OS.');
}

class Fio
{

	/** @var string url Fio REST API */
	public const REST_URL = 'https://www.fio.cz/ib_api/rest/';

	/**
	 * @todo INKASO does not work
	 * @var string
	 */
	const FIO_API_VERSION = '1.5.1';

	/** @var Request\IQueue */
	protected $queue;

	/** @var Account\FioAccount */
	protected $account;


	public function __construct(Request\IQueue $queue, Account\FioAccount $account)
	{
		$this->queue = $queue;
		$this->account = $account;
	}


	public function getAccount(): Account\FioAccount
	{
		return $this->account;
	}

}
