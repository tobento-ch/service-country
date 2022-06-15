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

use Tobento\Service\Support\Arrayable;
use IteratorAggregate;

/**
 * CountriesInterface
 */
interface CountriesInterface extends IteratorAggregate, Arrayable
{
    /**
     * Adds a country.
     * 
     * @param CountryInterface $country
     * @return static $this
     */
    public function addCountry(CountryInterface $country): static;
    
    /**
     * Add countries.
     *
     * @param CountryInterface ...$country
     * @return static $this
     */
    public function addCountries(CountryInterface ...$country): static;
    
    /**
     * Returns a new instance with the countries sorted.
     *
     * @param null|callable $callback If null, sorts by name.
     * @return static
     */
    public function sort(null|callable $callback = null): static;
    
    /**
     * Returns a new instance with the filtered countries.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback): static;
    
    /**
     * Returns a new instance with the specified code filtered.
     *
     * @param string $code
     * @return static
     */
    public function code(string $code): static;
    
    /**
     * Returns a new instance with the specified locale filtered.
     *
     * @param string $locale
     * @return static
     */
    public function locale(string $locale): static;
    
    /**
     * Returns a new instance with the specified group filtered.
     *
     * @param string $group
     * @return static
     */
    public function group(string $group): static;
    
    /**
     * Returns a new instance with the specified region filtered.
     *
     * @param string $region
     * @return static
     */
    public function region(string $region): static;
    
    /**
     * Returns a new instance with the specified continent filtered.
     *
     * @param string $continent
     * @return static
     */
    public function continent(string $continent): static;    
    
    /**
     * Returns all countries.
     *
     * @return array<int, CountryInterface>
     */
    public function all(): array;
    
    /**
     * Get first country.
     *
     * @return null|CountryInterface
     */
    public function first(): null|CountryInterface;
        
    /**
     * Get the first country found by code and with locale.
     *
     * @param string $code
     * @param null|string $locale
     * @return null|CountryInterface
     */
    public function get(string $code, null|string $locale = null): null|CountryInterface;
    
    /**
     * Get the column of the countries.
     *
     * @param string $column The column such as 'name'.
     * @param null|string $index The index such as 'code'.
     * @return array
     */
    public function column(string $column, null|string $index = null): array;
    
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
    ): array;
    
    /**
     * Returns a new instance with countries with only the codes specified.
     *
     * @param array $codes
     * @return static
     */
    public function only(array $codes): static;
        
    /**
     * Returns a new instance with countries except the codes specified.
     *
     * @param array $codes
     * @return static
     */
    public function except(array $codes): static;
    
    /**
     * Map over each of the countries.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static;
}