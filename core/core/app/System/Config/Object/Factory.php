<?php

namespace App\System\Config\Object;

class Factory
{
	public function upsource(): Upsource
	{
		return new Upsource();
	}

	public function youtrack(): Youtrack
	{
		return new Youtrack();
	}
}