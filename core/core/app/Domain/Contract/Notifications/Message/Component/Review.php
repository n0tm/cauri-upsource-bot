<?php

namespace App\Domain\Contract\Notifications\Message\Component;

interface Review extends Basic
{
	public function setBranch(string $branch): self;
	public function setAuthor(string $author): self;
}