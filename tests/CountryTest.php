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
use Tobento\Service\Country\Country;
use Tobento\Service\Country\CountryInterface;

/**
 * CountryTest
 */
class CountryTest extends TestCase
{
    public function testThatImplementsCountryInterface()
    {
        $this->assertInstanceof(
            CountryInterface::class,
            new Country(code: 'US')
        );
    }
    
    public function testConstructorAndGetMethods()
    {
        $country = new Country(
            code: 'US',
            code3: 'USA',
            numericCode: '840',
            currencyKey: 'USD',
            locale: 'en',
            name: 'United States',
            region: 'nearby',
            continent: 'North America',
            id: 840,
            active: true,
            group: 'shipping',
            priority: 100,
        );
        
        $this->assertSame('US', $country->code());
        $this->assertSame('USA', $country->code3());
        $this->assertSame('840', $country->numericCode());
        $this->assertSame('USD', $country->currencyKey());
        $this->assertSame('en', $country->locale());
        $this->assertSame('United States', $country->name());
        $this->assertSame('nearby', $country->region());
        $this->assertSame('North America', $country->continent());
        $this->assertSame(840, $country->id());
        $this->assertSame(true, $country->active());
        $this->assertSame('shipping', $country->group());
        $this->assertSame(100, $country->priority());
        $this->assertSame('America/Adak', $country->timezones()[0]);
    }
}