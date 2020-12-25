<?php

namespace App\Domain\Contract\Record;

/**
 * Interface User
 * @package App\Domain\Contract\Record
 */
interface User extends Basic
{
	public function getId(): int;
	public function getName(): string;
	public function getSurname(): string;
	public function getEmail(): string;
	public function getTelegram(): Telegram\User;
}