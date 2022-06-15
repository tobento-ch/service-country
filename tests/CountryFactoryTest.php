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
use Tobento\Service\Country\CountryFactory;
use Tobento\Service\Country\CountryFactoryInterface;
use Tobento\Service\Country\Country;
use Tobento\Service\Country\CountryInterface;

/**
 * CountryFactoryTest
 */
class CountryFactoryTest extends TestCase
{
    public function testThatImplementsCountryFactoryInterface()
    {
        $this->assertInstanceof(
            CountryFactoryInterface::class,
            new CountryFactory()
        );
    }
    
    public function testCreateCountryMethod()
    {
        $countryFactory = new CountryFactory();
        
        $country = $countryFactory->createCountry(code: 'US');

        $this->assertInstanceof(
            CountryInterface::class,
            $country
        );    
    }
    
    public function testCreateCountryMethodWithAllParams()
    {
        $countryFactory = new CountryFactory();
        
        $country = $countryFactory->createCountry(
            code: 'US',
            code3: 'USA',
            numericCode: '840',
            currencyKey: 'USD',
            locale: 'en',
            name: 'United States',
            region: '',
            continent: 'North America',
            id: 840,
            active: true,
            group: 'shipping',
            priority: 100,
        );

        $this->assertInstanceof(
            CountryInterface::class,
            $country
        );
    }
    
    public function testCreateCountryFromArrayMethod()
    {
        $countryFactory = new CountryFactory();
        
        $country = $countryFactory->createCountryFromArray([
            'code' => 'US',
            'code3' => 'USA',
            'numericCode' => '840',
            'currencyKey' => 'USD',
            'locale' => 'en',
            'name' => 'United States',
            'region' => '',
            'continent' => 'North America',
            'id' => 840,
            'active' => true,
            'group' => 'shipping',
            'priority' => 100,
        ]);

        $this->assertInstanceof(
            CountryInterface::class,
            $country
        );
    }      
}