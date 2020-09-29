<?php declare(strict_types=1);

namespace coro\Fio\Test;

use coro\Fio\Request\IQueue;
use coro\Fio\Request\Pay\XMLFile;
use coro\Fio\Request\Read\Files\Json;
use coro\Fio\Response\Read\Transaction;

class FioFactory extends \coro\Fio\Utils\FioFactory
{

	public function __construct(string $transactionClass = Transaction::class)
	{
		$accounts = [
			'foo' => [
				'account' => '123456789',
				'token' => 'abcdefgh',
			],
			'bar' => [
				'account' => '987654321',
				'token' => 'hgfedcba',
			],
		];
		parent::__construct($accounts, $transactionClass);
	}


	public function getXmlFile(): XMLFile
	{
		return $this->createXmlFile();
	}


	public function getReader(): Json
	{
		return $this->createReader();
	}


	protected function createQueue(): IQueue
	{
		return new Queue;
	}

}
