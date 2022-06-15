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
 * CountryFactoryInterface
 */
interface CountryFactoryInterface
{
    /**
     * Create a new Country based on the parameters.
     *
     * @param string $code The two-letter country code.
     * @param string $code3 The three-letter country code.
     * @param string $numericCode
     * @param string $currencyKey A currency key or code.
     * @param string $locale
     * @param string $name
     * @param string $region A region the country belongs to.
     * @param string $continent
     * @param int $id
     * @param bool $active
     * @param string $group
     * @param int $priority
     * @return CountryInterface
     */
    public function createCountry(
        string $code,
        string $code3 = '',
        string $numericCode = '',
        string $currencyKey = '',
        string $locale = '',
        string $name = '',
        string $region = '',
        string $continent = '',
        int $id = 0,
        bool $active = true,
        string $group = '',
        int $priority = 0,
    ): CountryInterface;
    
    /**
     * Create a new Country based on the parameters.
     *
     * @param array<string, mixed> $country
     * @return CountryInterface
     */
    public function createCountryFromArray(array $country): CountryInterface;
}