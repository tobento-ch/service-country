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

/**
 * CountryInterface
 */
interface CountryInterface extends Arrayable
{
    /**
     * Returns the two-letter country code.
     *
     * @return string
     */
    public function code(): string;
    
    /**
     * Returns the three-letter country code.
     *
     * @return string
     */
    public function code3(): string;
    
    /**
     * Returns the numeric code.
     *
     * @return string
     */
    public function numericCode(): string;
    
    /**
     * Returns the currency key.
     *
     * @return string
     */
    public function currencyKey(): string;
    
    /**
     * Returns a new instance with the specified currencyKey.
     *
     * @param string $currencyKey
     * @return static
     */
    public function withCurrencyKey(string $currencyKey): static;    
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function locale(): string;
    
    /**
     * Returns a new instance with the specified locale.
     *
     * @param string $locale
     * @return static
     */
    public function withLocale(string $locale): static;
    
    /**
     * Returns the name.
     *
     * @return string
     */
    public function name(): string;
    
    /**
     * Returns a new instance with the specified name.
     *
     * @param string $name
     * @return static
     */
    public function withName(string $name): static;
    
    /**
     * Returns the region.
     *
     * @return string
     */
    public function region(): string;
    
    /**
     * Returns a new instance with the specified region.
     *
     * @param string $region
     * @return static
     */
    public function withRegion(string $region): static;    
    
    /**
     * Returns the continent.
     *
     * @return string
     */
    public function continent(): string;
    
    /**
     * Returns a new instance with the specified continent.
     *
     * @param string $continent
     * @return static
     */
    public function withContinent(string $continent): static;
    
    /**
     * Returns the timezones.
     *
     * @return array
     */
    public function timezones(): array;
    
    /**
     * Returns the id.
     *
     * @return int
     */
    public function id(): int;
    
    /**
     * Returns a new instance with the specified id.
     *
     * @param int $id
     * @return static
     */
    public function withId(int $id): static;
    
    /**
     * Returns if the country is active.
     *
     * @return bool
     */
    public function active(): bool;
    
    /**
     * Returns a new instance with the specified active.
     *
     * @param bool $active
     * @return static
     */
    public function withActive(bool $active): static;
    
    /**
     * Returns the group.
     *
     * @return string
     */
    public function group(): string;
    
    /**
     * Returns a new instance with the specified group.
     *
     * @param string $group
     * @return static
     */
    public function withGroup(string $group): static;
    
    /**
     * Returns the priority.
     *
     * @return int
     */
    public function priority(): int;
    
    /**
     * Returns a new instance with the specified priority.
     *
     * @param int $priority
     * @return static
     */
    public function withPriority(int $priority): static;
}