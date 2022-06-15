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
 * CountriesFactory
 */
class CountriesFactory implements CountriesFactoryInterface
{
    /**
     * Create a new CountryRepository.
     *
     * @param null|CountryFactoryInterface $countryFactory
     */
    public function __construct(
        protected null|CountryFactoryInterface $countryFactory = null
    ) {
        $this->countryFactory = $countryFactory ?: new CountryFactory();
    }
    
    /**
     * Create a new Countries based on the parameters.
     *
     * @param CountryInterface ...$country
     * @return CountriesInterface
     */
    public function createCountries(CountryInterface ...$country): CountriesInterface
    {
        return new Countries(...$country);
    }
    
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
    ): CountriesInterface {
        
        $c = $this->createCountries();

        foreach($countries as $country)
        {
            if (is_array($country)) {
                
                $country['locale'] ??= $locale;
                
                $c->addCountry(
                    $this->countryFactory->createCountryFromArray($country)
                );
            } elseif ($country instanceof CountryInterface) {
                $c->addCountry($country);
            }
        }
        
        return $c;
    }    
}