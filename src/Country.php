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

use DateTimeZone;
use ValueError;

/**
 * Country
 */
class Country implements CountryInterface
{
    /**
     * Create a new Country.
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
     */
    public function __construct(
        protected string $code,
        protected string $code3 = '',
        protected string $numericCode = '',
        protected string $currencyKey = '',
        protected string $locale = '',
        protected string $name = '',
        protected string $region = '',
        protected string $continent = '',
        protected int $id = 0,
        protected bool $active = true,
        protected string $group = '',
        protected int $priority = 0,
    ) {}
    
    /**
     * Returns the two-letter country code.
     *
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }
    
    /**
     * Returns the three-letter country code.
     *
     * @return string
     */
    public function code3(): string
    {
        return $this->code3;
    }
    
    /**
     * Returns the numeric code.
     *
     * @return string
     */
    public function numericCode(): string
    {
        return $this->numericCode;
    }
    
    /**
     * Returns the currency key.
     *
     * @return string
     */
    public function currencyKey(): string
    {
        return $this->currencyKey;
    }
    
    /**
     * Returns a new instance with the specified currencyKey.
     *
     * @param string $currencyKey
     * @return static
     */
    public function withCurrencyKey(string $currencyKey): static
    {
        $new = clone $this;
        $new->currencyKey = $currencyKey;
        return $new;
    }
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function locale(): string
    {
        return $this->locale;
    }
    
    /**
     * Returns a new instance with the specified locale.
     *
     * @param string $locale
     * @return static
     */
    public function withLocale(string $locale): static
    {
        $new = clone $this;
        $new->locale = $locale;
        return $new;
    }
    
    /**
     * Returns the name.
     *
     * @return string
     */
    public function name(): string
    {
        return !empty($this->name) ? $this->name : $this->code();
    }
    
    /**
     * Returns a new instance with the specified name.
     *
     * @param string $name
     * @return static
     */
    public function withName(string $name): static
    {
        $new = clone $this;
        $new->name = $name;
        return $new;
    }
    
    /**
     * Returns the region.
     *
     * @return string
     */
    public function region(): string
    {
        return $this->region;
    }
    
    /**
     * Returns a new instance with the specified region.
     *
     * @param string $region
     * @return static
     */
    public function withRegion(string $region): static
    {
        $new = clone $this;
        $new->region = $region;
        return $new;
    }
    
    /**
     * Returns the continent.
     *
     * @return string
     */
    public function continent(): string
    {
        return $this->continent;
    }
    
    /**
     * Returns a new instance with the specified continent.
     *
     * @param string $continent
     * @return static
     */
    public function withContinent(string $continent): static
    {
        $new = clone $this;
        $new->continent = $continent;
        return $new;
    }
    
    /**
     * Returns the timezones.
     *
     * @return array
     */
    public function timezones(): array
    {
        try {
            return DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $this->code());
        } catch (ValueError $e) {
            return [];
        }
    } 
    
    /**
     * Returns the id.
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }
    
    /**
     * Returns a new instance with the specified id.
     *
     * @param int $id
     * @return static
     */
    public function withId(int $id): static
    {
        $new = clone $this;
        $new->id = $id;
        return $new;
    }
    
    /**
     * Returns if the country is active.
     *
     * @return bool
     */
    public function active(): bool
    {
        return $this->active;
    }
    
    /**
     * Returns a new instance with the specified active.
     *
     * @param bool $active
     * @return static
     */
    public function withActive(bool $active): static
    {
        $new = clone $this;
        $new->active = $active;
        return $new;
    }    
    
    /**
     * Returns the group.
     *
     * @return string
     */
    public function group(): string
    {
        return $this->group;
    }
    
    /**
     * Returns a new instance with the specified group.
     *
     * @param string $group
     * @return static
     */
    public function withGroup(string $group): static
    {
        $new = clone $this;
        $new->group = $group;
        return $new;
    }
    
    /**
     * Returns the priority.
     *
     * @return int
     */
    public function priority(): int
    {
        return $this->priority;
    }
    
    /**
     * Returns a new instance with the specified priority.
     *
     * @param int $priority
     * @return static
     */
    public function withPriority(int $priority): static
    {
        $new = clone $this;
        $new->priority = $priority;
        return $new;
    }
    
    /**
     * Object to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code(),
            'code3' => $this->code3(),
            'numericCode' => $this->numericCode(),
            'currencyKey' => $this->currencyKey(),
            'locale' => $this->locale(),
            'name' => $this->name(),
            'region' => $this->region(),
            'continent' => $this->continent(),
            'timezones' => $this->timezones(),
            'id' => $this->id(),
            'active' => $this->active(),
            'group' => $this->group(),
            'priority' => $this->priority(),
        ];
    }
    
    /**
     * __get For array_column object support
     */
    public function __get(string $prop)
    {
        return $this->{$prop}();
    }

    /**
     * __isset For array_column object support
     */
    public function __isset(string $prop): bool
    {
        return method_exists($this, $prop);
    }
}