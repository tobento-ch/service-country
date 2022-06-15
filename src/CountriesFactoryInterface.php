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
 * CountriesFactoryInterface
 */
interface CountriesFactoryInterface
{
    /**
     * Create a new Countries based on the parameters.
     *
     * @param CountryInterface ...$country
     * @return CountriesInterface
     */
    public function createCountries(CountryInterface ...$country): CountriesInterface;
    
    /**
     * Create a new Countries from the specified array.
     *
     * @param array $countries
     * @param null|string $locale
     * @return CountriesInterface
     */
    public function createCountriesFromArray(
        array $countries,
        null|string $locale = null
    ): CountriesInterface;
}