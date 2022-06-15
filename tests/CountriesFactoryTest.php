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
use Tobento\Service\Country\CountriesFactory;
use Tobento\Service\Country\CountriesFactoryInterface;
use Tobento\Service\Country\Countries;
use Tobento\Service\Country\CountriesInterface;
use Tobento\Service\Country\CountryFactory;
use Tobento\Service\Country\Country;
use Tobento\Service\Country\CountryInterface;

/**
 * CountriesFactoryTest
 */
class CountriesFactoryTest extends TestCase
{
    public function testThatImplementsCountriesFactoryInterface()
    {
        $this->assertInstanceof(
            CountriesFactoryInterface::class,
            new CountriesFactory()
        );
    }
    
    public function testConstructor()
    {
        $countriesFactory = new CountriesFactory(
            countryFactory: new CountryFactory()
        );
        
        $this->assertInstanceof(
            CountriesFactoryInterface::class,
            $countriesFactory
        );        
    }
    
    public function testCreateCountriesMethod()
    {
        $countriesFactory = new CountriesFactory();
        
        $countries = $countriesFactory->createCountries();

        $this->assertInstanceof(
            CountriesInterface::class,
            $countries
        );
        
        $countries = $countriesFactory->createCountries(
            new Country(code: 'US'),
            new Country(code: 'CH'),
        );
        
        $this->assertInstanceof(
            CountriesInterface::class,
            $countries
        );        
    }
    
    public function testCreateCountriesFromArrayMethod()
    {
        $countriesFactory = new CountriesFactory();
        
        $countries = $countriesFactory->createCountriesFromArray([]);

        $this->assertInstanceof(
            CountriesInterface::class,
            $countries
        );
        
        $countries = $countriesFactory->createCountriesFromArray([
            ['code' => 'US'],
            ['code' => 'CH'],
        ]);
        
        $this->assertSame(2, count($countries->all()));
        
        $countries = $countriesFactory->createCountriesFromArray([
            ['code' => 'US'],
            new Country(code: 'CH'),
        ]);
        
        $this->assertSame(2, count($countries->all()));        
    }
    
    public function testCreateCountriesFromArrayMethodWithLocaleAssignLocaleToCountryIfNone()
    {
        $countriesFactory = new CountriesFactory();
        
        $us = ['code' => 'US', 'locale' => 'en'];
        $it = ['code' => 'IT'];
        $ch = new Country(code: 'CH');
        
        $countries = $countriesFactory->createCountriesFromArray([$us, $it, $ch], 'de');
        
        $this->assertSame(3, count($countries->all()));
        
        $this->assertSame('en', $countries->get('US')->locale());
        $this->assertSame('de', $countries->get('IT')->locale());
        $this->assertSame('', $countries->get('CH')->locale());
    }    
}