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
use ArrayIterator;
use Traversable;

/**
 * Countries
 */
class Countries implements CountriesInterface
{
    /**
     * @var array<mixed> Holds the countries.
     */
    protected array $countries = [];
    
    /**
     * Create a new Countries.
     *
     * @param CountryInterface ...$countries
     */
    public function __construct(
        CountryInterface ...$countries
    ) {
        $this->countries = $countries;
    }

    /**
     * Adds a country.
     * 
     * @param CountryInterface $country
     * @return static $this
     */
    public function addCountry(CountryInterface $country): static
    {
        $this->countries[] = $country;
        return $this;
    }
    
    /**
     * Add countries.
     *
     * @param CountryInterface ...$country
     * @return static $this
     */
    public function addCountries(CountryInterface ...$country): static
    {
        foreach($country as $c) {
            $this->addCountry($c);
        }
        
        return $this;
    }
    
    /**
     * Returns a new instance with the countries sorted.
     *
     * @param null|callable $callback If null, sorts by name.
     * @return static
     */
    public function sort(null|callable $callback = null): static
    {
        if (is_null($callback))
        {
            $callback = fn(CountryInterface $a, CountryInterface $b): int
                => $a->name() <=> $b->name();
        }
        
        $new = clone $this;
        uasort($new->countries, $callback);
        return $new;
    }
    
    /**
     * Returns a new instance with the filtered countries.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback): static
    {
        $new = clone $this;
        $new->countries = array_filter($this->countries, $callback);
        return $new;
    }
    
    /**
     * Returns a new instance with the specified code filtered.
     *
     * @param string $code
     * @return static
     */
    public function code(string $code): static
    {
        return $this->filter(function(CountryInterface $c) use($code): bool {
            
            if (
                $c->code() === $code
                || $c->code3() === $code
                || $c->numericCode() === $code
            ) {
                return true;
            }
            
            return false;
        });
    }
    
    /**
     * Returns a new instance with the specified locale filtered.
     *
     * @param string $locale
     * @return static
     */
    public function locale(string $locale): static
    {
        return $this->filter(fn(CountryInterface $c): bool => $c->locale() === $locale);
    }
    
    /**
     * Returns a new instance with the specified group filtered.
     *
     * @param string $group
     * @return static
     */
    public function group(string $group): static
    {
        return $this->filter(fn(CountryInterface $c): bool => $c->group() === $group);
    }
    
    /**
     * Returns a new instance with the specified region filtered.
     *
     * @param string $region
     * @return static
     */
    public function region(string $region): static
    {
        return $this->filter(fn(CountryInterface $c): bool => $c->region() === $region);
    }
    
    /**
     * Returns a new instance with the specified continent filtered.
     *
     * @param string $continent
     * @return static
     */
    public function continent(string $continent): static
    {
        return $this->filter(fn(CountryInterface $c): bool => $c->continent() === $continent);
    }    
    
    /**
     * Returns all countries. 
     *
     * @return array<int, CountryInterface>
     */
    public function all(): array
    {    
        return $this->countries;        
    }
    
    /**
     * Get first country.
     *
     * @return null|CountryInterface
     */
    public function first(): null|CountryInterface
    {
        $key = array_key_first($this->countries);
        
        if (is_null($key)) {
            return null;
        }
        
        return $this->countries[$key];    
    }
        
    /**
     * Get the first country found by code and with locale.
     *
     * @param string $code
     * @param null|string $locale
     * @return null|CountryInterface
     */
    public function get(string $code, null|string $locale = null): null|CountryInterface
    {
        if (!is_null($locale)) {
            return $this->code($code)->locale($locale)->first();
        }
        
        return $this->code($code)->first();
    }
    
    /**
     * Get the column of the countries.
     *
     * @param string $column The column such as 'name'.
     * @param null|string $index The index such as 'code'.
     * @return array
     */
    public function column(string $column, null|string $index = null): array
    {
        return array_column($this->countries, $column, $index);
    }
    
    /**
     * Get the column of the countries grouped.
     *
     * @param string $group The group such as 'region'.
     * @param string $column The column such as 'name'.
     * @param null|string $index The index such as 'code'.
     * @return array
     */
    public function groupedColumn(
        string $group,
        string $column,
        null|string $index = null
    ): array {
        $index = $index ?: $column;
        $groups = [];
        
        foreach($this as $country) {
            
            if ($group === 'timezones') {
                $name = explode('/', $country->timezones()[0] ?? $country->code())[0];
            } else {
                $name = $country->$group();
            }
            
            $groups[$name][$country->$index()] = $country->$column();
        }
        
        return $groups;
    }
    
    /**
     * Returns a new instance with countries with only the codes specified.
     *
     * @param array $codes
     * @return static
     */
    public function only(array $codes): static
    {
        return $this->filter(fn(CountryInterface $c): bool => in_array($c->code(), $codes));
    }
        
    /**
     * Returns a new instance with countries except the codes specified.
     *
     * @param array $codes
     * @return static
     */
    public function except(array $codes): static
    {
        return $this->filter(fn(CountryInterface $c): bool => !in_array($c->code(), $codes));
    }
    
    /**
     * Map over each of the countries.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static
    {
        $keys = array_keys($this->all());

        $items = array_map($callback, $this->all(), $keys);

        $new = clone $this;
        $new->countries = array_combine($keys, $items);
        return $new;
    }    
    
    /**
     * Get the iterator.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {    
        return new ArrayIterator($this->all());
    }    
    
    /**
     * Object to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return (new Collection($this->all()))->toArray();
    }
}