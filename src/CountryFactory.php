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

use Tobento\Service\Collection\Collection;

/**
 * CountryFactory
 */
class CountryFactory implements CountryFactoryInterface
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
    ): CountryInterface {
        return new Country(
            code: $code,
            code3: $code3,
            numericCode: $numericCode,
            currencyKey: $currencyKey,
            locale: $locale,
            name: $name,
            region: $region,
            continent: $continent,
            id: $id,
            active: $active,
            group: $group,
            priority: $priority,
        );
    }
    
    /**
     * Create a new Country based on the parameters.
     *
     * @param array<string, mixed> $country
     * @return CountryInterface
     */
    public function createCountryFromArray(array $country): CountryInterface
    {
        // we will use the collection to ensure data.
        $country = new Collection($country);
        
        return $this->createCountry(
            code: $country->get('code', ''),
            code3: $country->get('code3', ''),
            numericCode: $country->get('numericCode', ''),
            currencyKey: $country->get('currencyKey', ''),
            locale: $country->get('locale', ''),
            name: $country->get('name', ''),
            region: $country->get('region', ''),
            continent: $country->get('continent', ''),
            id: $country->get('id', 0),
            active: $country->get('active', true),
            group: $country->get('group', ''),
            priority: $country->get('priority', 0),
        );
    }
}