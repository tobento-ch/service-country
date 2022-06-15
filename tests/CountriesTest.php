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
use Tobento\Service\Country\Countries;
use Tobento\Service\Country\CountriesInterface;
use Tobento\Service\Country\Country;
use Tobento\Service\Country\CountryInterface;

/**
 * CountriesTest
 */
class CountriesTest extends TestCase
{
    public function testThatImplementsCountriesInterface()
    {
        $this->assertInstanceof(
            CountriesInterface::class,
            new Countries()
        );
    }
    
    public function testConstructor()
    {
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        
        $countries = new Countries($us, $ch);
        
        $this->assertSame($us, $countries->get('US'));
        $this->assertSame($ch, $countries->get('CH'));
    }
    
    public function testAddCountryMethod()
    {
        $us = new Country(code: 'US');
        
        $countries = new Countries();
        
        $this->assertSame(null, $countries->get('US'));
        
        $countries->addCountry($us);
        
        $this->assertSame($us, $countries->get('US'));
    }
    
    public function testAddCountriesMethod()
    {
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        
        $countries = new Countries();
        
        $this->assertSame(null, $countries->get('US'));
        $this->assertSame(null, $countries->get('CH'));
        
        $countries->addCountries($us, $ch);
        
        $this->assertSame($us, $countries->get('US'));
        $this->assertSame($ch, $countries->get('CH'));
    }
    
    public function testSortMethodWithoutCallbackSortsByName()
    {
        $us = new Country(code: 'US', name: 'United States');
        $ch = new Country(code: 'CH', name: 'Switzerland');
        
        $countries = new Countries($us, $ch);
        
        $this->assertSame(
            ['United States', 'Switzerland'],
            $countries->column('name')
        );
        
        $countriesSorted = $countries->sort();
        
        $this->assertFalse($countries === $countriesSorted);
        
        $this->assertSame(
            ['Switzerland', 'United States'],
            $countriesSorted->column('name')
        );
    }
    
    public function testSortMethodCallback()
    {
        $us = new Country(code: 'US', priority: 100);
        $ch = new Country(code: 'CH', priority: 150);
        
        $countries = new Countries($us, $ch);
        
        $this->assertSame(
            ['US', 'CH'],
            $countries->column('code')
        );
        
        $countriesSorted = $countries->sort(
            fn(CountryInterface $a, CountryInterface $b): int
                => $b->priority() <=> $a->priority()
        );
        
        $this->assertFalse($countries === $countriesSorted);
        
        $this->assertSame(
            ['CH', 'US'],
            $countriesSorted->column('code')
        );
    }
    
    public function testFilterMethod()
    {
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        $it = new Country(code: 'IT');
        
        $countries = new Countries($us, $ch, $it);
        
        $this->assertSame(
            ['US', 'CH', 'IT'],
            $countries->column('code')
        );
        
        $countriesFiltered = $countries->filter(
            fn(CountryInterface $c): bool => in_array($c->code(), ['US', 'IT'])
        );
        
        $this->assertFalse($countries === $countriesFiltered);
        
        $this->assertSame(
            ['US', 'IT'],
            $countriesFiltered->column('code')
        );
    }
    
    public function testCodeMethod()
    {
        $usEn = new Country(code: 'US', locale: 'en', name: 'usEn');
        $usDe = new Country(code: 'US', locale: 'de', name: 'usDe');
        $chDe = new Country(code: 'CH', locale: 'de', name: 'chDe');
        
        $countries = new Countries($usEn, $usDe, $chDe);
        
        $this->assertSame(
            ['usEn', 'usDe', 'chDe'],
            $countries->column('name')
        );
        
        $countriesFiltered = $countries->code(code: 'US');
        
        $this->assertFalse($countries === $countriesFiltered);
        
        $this->assertSame(
            ['usEn', 'usDe'],
            $countriesFiltered->column('name')
        );
    }
    
    public function testLocaleMethod()
    {
        $usEn = new Country(code: 'US', locale: 'en', name: 'usEn');
        $usDe = new Country(code: 'US', locale: 'de', name: 'usDe');
        $chDe = new Country(code: 'CH', locale: 'de', name: 'chDe');
        
        $countries = new Countries($usEn, $usDe, $chDe);
        
        $this->assertSame(
            ['usEn', 'usDe', 'chDe'],
            $countries->column('name')
        );
        
        $countriesFiltered = $countries->locale('de');
        
        $this->assertFalse($countries === $countriesFiltered);
        
        $this->assertSame(
            ['usDe', 'chDe'],
            $countriesFiltered->column('name')
        );        
    }
    
    public function testGroupMethod()
    {
        $usEn = new Country(code: 'US', group: 'shipping');
        $usDe = new Country(code: 'US', group: 'payment');
        $chDe = new Country(code: 'CH', group: 'shipping');
        
        $countries = new Countries($usEn, $usDe, $chDe);
        
        $this->assertSame(
            ['US', 'US', 'CH'],
            $countries->column('code')
        );
        
        $countriesFiltered = $countries->group('shipping');
        
        $this->assertFalse($countries === $countriesFiltered);
        
        $this->assertSame(
            ['US', 'CH'],
            $countriesFiltered->column('code')
        );        
    }
    
    public function testRegionMethod()
    {
        $usEn = new Country(code: 'US');
        $usDe = new Country(code: 'US');
        $chDe = new Country(code: 'CH', region: 'nearby');
        
        $countries = new Countries($usEn, $usDe, $chDe);
        
        $this->assertSame(
            ['US', 'US', 'CH'],
            $countries->column('code')
        );
        
        $countriesFiltered = $countries->region('nearby');
        
        $this->assertFalse($countries === $countriesFiltered);
        
        $this->assertSame(
            ['CH'],
            $countriesFiltered->column('code')
        );        
    }
    
    public function testContinentMethod()
    {
        $usEn = new Country(code: 'US');
        $usDe = new Country(code: 'US');
        $chDe = new Country(code: 'CH', continent: 'Europe');
        
        $countries = new Countries($usEn, $usDe, $chDe);
        
        $this->assertSame(
            ['US', 'US', 'CH'],
            $countries->column('code')
        );
        
        $countriesFiltered = $countries->continent('Europe');
        
        $this->assertFalse($countries === $countriesFiltered);
        
        $this->assertSame(
            ['CH'],
            $countriesFiltered->column('code')
        );        
    }
    
    public function testAllMethod()
    {
        $countries = new Countries();
        
        $this->assertSame([], $countries->all());
        
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        
        $countries = new Countries($us, $ch);
        
        $this->assertSame([$us, $ch], $countries->all());
    }
    
    public function testFirstMethod()
    {
        $countries = new Countries();
        
        $this->assertSame(null, $countries->first());
        
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        
        $countries = new Countries($us, $ch);
        
        $this->assertSame($us, $countries->first());
    }
    
    public function testGetMethod()
    {        
        $us = new Country(code: 'US', code3: 'USA', numericCode: '1');
        
        $countries = new Countries($us);
        
        $this->assertSame($us, $countries->get(code: 'US'));
        $this->assertSame($us, $countries->get(code: 'USA'));
        $this->assertSame($us, $countries->get(code: '1'));
        $this->assertSame(null, $countries->get(code: 'IT'));
    }
    
    public function testGetMethodWithLocale()
    {        
        $us = new Country(code: 'US', code3: 'USA', numericCode: '1', name: 'us');
        $usDe = new Country(code: 'US', code3: 'USA', numericCode: '1', locale: 'de');
        
        $countries = new Countries($us);
        
        $this->assertSame(null, $countries->get(code: 'US', locale: 'de'));
        
        $countries = new Countries($usDe);
        
        $this->assertSame($usDe, $countries->get(code: 'US', locale: 'de'));
        $this->assertSame($usDe, $countries->get(code: 'USA', locale: 'de'));
        $this->assertSame($usDe, $countries->get(code: '1', locale: 'de'));
    }
    
    public function testColumnMethod()
    {
        $countries = new Countries();
        
        $this->assertSame([], $countries->column(column: 'code'));
        
        $us = new Country(code: 'US', numericCode: '5');
        $ch = new Country(code: 'CH', numericCode: '8');
        
        $countries = new Countries($us, $ch);
        
        $this->assertSame(['US', 'CH'], $countries->column(column: 'code'));
        
        $this->assertSame(
            ['5' => 'US', '8' => 'CH'],
            $countries->column(column: 'code', index: 'numericCode')
        );
    }
    
    public function testGroupedColumnMethod()
    {
        $countries = new Countries();
        
        $this->assertSame(
            [],
            $countries->groupedColumn(
                group: 'continent',
                column: 'name',
                index: 'code',
            )
        );
        
        $us = new Country(code: 'US', name: 'usa', continent: 'North America');
        $ch = new Country(code: 'CH', name: 'ch', continent: 'Europe');
        $it = new Country(code: 'IT', name: 'it', continent: 'Europe');
        
        $countries = new Countries($us, $ch, $it);
        
        $this->assertSame(
            [
                'North America' => ['usa' => 'usa'],
                'Europe' => ['ch' => 'ch', 'it' => 'it'],
            ],
            $countries->groupedColumn(
                group: 'continent',
                column: 'name',
                //index: 'code',
            )
        );
        
        $this->assertSame(
            [
                'North America' => ['US' => 'usa'],
                'Europe' => ['CH' => 'ch', 'IT' => 'it'],
            ],
            $countries->groupedColumn(
                group: 'continent',
                column: 'name',
                index: 'code',
            )
        );      
    }
    
    public function testGroupedColumnMethodWithTimezones()
    {
        $us = new Country(code: 'US', name: 'usa', continent: 'North America');
        $ch = new Country(code: 'CH', name: 'ch', continent: 'Europe');
        $it = new Country(code: 'IT', name: 'it', continent: 'Europe');
        
        $countries = new Countries($us, $ch, $it);
        
        $this->assertSame(
            [
                'America' => ['usa' => 'usa'],
                'Europe' => ['ch' => 'ch', 'it' => 'it'],
            ],
            $countries->groupedColumn(
                group: 'timezones',
                column: 'name',
            )
        ); 
    }
    
    public function testOnlyMethod()
    {
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        $it = new Country(code: 'IT');
        
        $countries = new Countries($us, $ch, $it);
        
        $countriesNew = $countries->only(['US', 'IT']);
        
        $this->assertFalse($countries === $countriesNew);
        
        $this->assertSame(
            ['US', 'IT'],
            $countriesNew->column('code')
        ); 
    }
    
    public function testExceptMethod()
    {
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        $it = new Country(code: 'IT');
        
        $countries = new Countries($us, $ch, $it);
        
        $countriesNew = $countries->except(['US', 'IT']);
        
        $this->assertFalse($countries === $countriesNew);
        
        $this->assertSame(
            ['CH'],
            $countriesNew->column('code')
        ); 
    }
    
    public function testMapMethod()
    {
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        $it = new Country(code: 'IT');
        
        $countries = new Countries($us, $ch, $it);
        
        $countriesNew = $countries->map(function(CountryInterface $c) {
            if (in_array($c->code(), ['CH'])) {
                return $c->withRegion('Near by')->withPriority(100);
            }
            return $c->withRegion('All Others');
        });
        
        $this->assertFalse($countries === $countriesNew);
        
        $this->assertSame('Near by', $countriesNew->get('CH')->region());
        $this->assertSame('All Others', $countriesNew->get('US')->region());
        $this->assertSame('All Others', $countriesNew->get('IT')->region());
    }    
    
    public function testIterating()
    {
        $us = new Country(code: 'US');
        $ch = new Country(code: 'CH');
        
        $countries = new Countries($us, $ch);
        
        foreach($countries as $country) {
            $this->assertInstanceof(
                CountryInterface::class,
                $country
            );
        }
    }    
}