<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Kdyby\DateTimeProvider\Provider;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

/**
 * Helper factory to create ConstantProvider from arbitrary input.
 */
class ConstantProviderFactory
{

	use \Kdyby\StrictObjects\Scream;

	/**
	 * @param string|int|\DateTimeInterface $dateTime
	 */
	public function create($dateTime): ConstantProvider
	{
		if ($dateTime instanceof DateTimeInterface) {
			if ($dateTime instanceof DateTime) {
				$dateTime = DateTimeImmutable::createFromMutable($dateTime);
			}
			return new ConstantProvider($dateTime);

		} elseif (is_numeric($dateTime)) {
			return new ConstantProvider((new DateTimeImmutable(sprintf('@%.6f', $dateTime)))->setTimezone(new DateTimeZone(date_default_timezone_get())));

		} elseif (is_string($dateTime)) {
			throw new \Kdyby\DateTimeProvider\NotImplementedException(sprintf(
				'Cannot process datetime in given format "%s"',
				$dateTime
			));

		} else {
			throw new \Kdyby\DateTimeProvider\NotImplementedException(sprintf(
				'Cannot process datetime from given value %s',
				is_object($dateTime) ? get_class($dateTime) : gettype($dateTime)
			));
		}
	}

}