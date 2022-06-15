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

namespace Tobento\Service\Country\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryRepositoryInterface;
use Tobento\Service\Country\CountryInterface;
use Tobento\Service\Country\CountriesInterface;

/**
 * CountryRepositoryTest
 */
class CountryRepositoryTest extends TestCase
{
    public function testThatImplementsCountryRepositoryInterface()
    {
        $this->assertInstanceof(
            CountryRepositoryInterface::class,
            new CountryRepository()
        );
    }
    
    public function testFindCountryMethod()
    {
        $countryRepository = new CountryRepository();

        $country = $countryRepository->findCountry(code: 'US');

        $this->assertInstanceof(
            CountryInterface::class,
            $country
        );    
    }
    
    public function testFindCountryMethodByLocale()
    {
        $countryRepository = new CountryRepository();

        $country = $countryRepository->findCountry(code: 'US', locale: 'de');

        $this->assertInstanceof(
            CountryInterface::class,
            $country
        );
    }
    
    public function testFindCountryMethodByLocaleFallsbackToDefaultLocale()
    {
        $countryRepository = new CountryRepository(
            locale: 'de',
        );
        
        $country = $countryRepository->findCountry(code: 'US', locale: 'gb');
        
        $this->assertSame('de', $country->locale());
    }
    
    public function testFindCountryMethodByLocaleFallsbackToFallbackLocale()
    {
        $countryRepository = new CountryRepository(
            localeFallbacks: ['de-CH' => 'de'],
        );
        
        $country = $countryRepository->findCountry(code: 'US', locale: 'de-CH');
        
        $this->assertSame('de', $country->locale());
    }   
    
    public function testFindCountryMethodByLocaleUsesLocaleMapping()
    {
        $countryRepository = new CountryRepository(
            localeMapping: ['de-CH' => 'de'],
        );
        
        $country = $countryRepository->findCountry(code: 'US', locale: 'de-CH');
        
        $this->assertSame('de', $country->locale());
    }
    
    public function testFindCountriesMethod()
    {
        $countryRepository = new CountryRepository();

        $countries = $countryRepository->findCountries();

        $this->assertInstanceof(
            CountriesInterface::class,
            $countries
        );
        
        $this->assertSame('en', $countries->get(code: 'CH')->locale());
    }
    
    public function testFindCountriesMethodByLocale()
    {
        $countryRepository = new CountryRepository();

        $countries = $countryRepository->findCountries(locale: 'de');
        
        $this->assertSame('de', $countries->get(code: 'CH')->locale());
    }
    
    public function testFindCountriesMethodByLocaleFallsbackToDefaultLocale()
    {
        $countryRepository = new CountryRepository(
            locale: 'de',
        );

        $countries = $countryRepository->findCountries(locale: 'gb');
        
        $this->assertSame('de', $countries->get(code: 'CH')->locale());
    }
    
    public function testFindCountriesMethodByLocaleFallsbackToFallbackLocale()
    {
        $countryRepository = new CountryRepository(
            localeFallbacks: ['de-CH' => 'de'],
        );

        $countries = $countryRepository->findCountries(locale: 'de-CH');
        
        $this->assertSame('de', $countries->get(code: 'CH')->locale());
    }
    
    public function testFindCountriesMethodByLocaleUsesLocaleMapping()
    {
        $countryRepository = new CountryRepository(
            localeMapping: ['de-CH' => 'de'],
        );

        $countries = $countryRepository->findCountries(locale: 'de-CH');
        
        $this->assertSame('de', $countries->get(code: 'CH')->locale());
    }
    
    public function testFindCountriesMethodByGroup()
    {
        $countryRepository = new CountryRepository();

        $countries = $countryRepository->findCountries(group: 'shipping');
        
        $this->assertInstanceof(
            CountriesInterface::class,
            $countries
        );
    }
}