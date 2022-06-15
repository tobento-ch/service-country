<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Country;

/**
 * CountryRepositoryInterface
 */
interface CountryRepositoryInterface
{
    /**
     * Returns a single country by the specified parameters or null if not found.
     *
     * @param string $code
     * @param null|string $locale
     * @return null|CountryInterface
     */
    public function findCountry(string $code, null|string $locale = null): null|CountryInterface;
    
    /**
     * Returns all countries found by the specified parameters.
     *
     * @param null|string $locale
     * @param null|string $group
     * @return CountriesInterface
     */
    public function findCountries(null|string $locale = null, null|string $group = null): CountriesInterface;
}