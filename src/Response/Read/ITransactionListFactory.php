<?php declare(strict_types=1);

namespace coro\Fio\Response\Read;

interface ITransactionListFactory
{

	function createTransaction(\stdClass $data, string $dateFormat): TransactionAbstract;


	function createInfo(\stdClass $data, string $dateFormat): \stdClass;


	function createTransactionList(\stdClass $info): TransactionList;

}
