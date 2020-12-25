<?php

namespace App\Domain\Contract\Entity;

interface User extends Basic
{
	public function getId(): int;
	public function getName(): string;
	public function getSurname(): string;
	public function getEmail(): string;
}