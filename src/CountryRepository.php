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
 * CountryRepository
 */
class CountryRepository implements CountryRepositoryInterface
{
    /**
     * @var array<string, CountriesInterface>
     */
    protected array $countries = [];
    
    /**
     * Create a new CountryRepository.
     *
     * @param string $locale The default locale.
     * @param array<string, string> $localeFallbacks ['de-CH' => 'en-US']
     * @param array $localeMapping ['de' (requested) => '1' (stored)]
     * @param null|CountriesFactoryInterface $countriesFactory
     * @param null|string $directory
     */
    public function __construct(
        protected string $locale = 'en',
        protected array $localeFallbacks = [],
        protected array $localeMapping = [],
        protected null|CountriesFactoryInterface $countriesFactory = null,
        protected null|string $directory = null,
    ) {
        $this->countriesFactory = $countriesFactory ?: new CountriesFactory();
        
        if (is_null($this->directory)) {
            $this->directory = __DIR__.'/../resources/countries/';
        } else {
            $this->directory = str_replace(['\\', '//'], '/', $this->directory);
            $this->directory = rtrim($this->directory, '/').'/';
        }
    }

    /**
     * Returns a single country by the specified parameters or null if not found.
     *
     * @param string $code
     * @param null|string $locale
     * @return null|CountryInterface
     */
    public function findCountry(string $code, null|string $locale = null): null|CountryInterface
    {
        return $this->fetchCountries($locale)->code($code)->first();
    }
    
    /**
     * Returns all countries found by the specified parameters.
     *
     * @param null|string $locale
     * @param null|string $group
     * @return CountriesInterface
     */
    public function findCountries(null|string $locale = null, null|string $group = null): CountriesInterface
    {
        $countries = $this->fetchCountries($locale);
        
        if (!is_null($group)) {
            $countries = $countries->group($group);
        }
        
        return $countries;
    }
    
    /**
     * Fetches the countries.
     *
     * @param null|string $locale
     * @return CountriesInterface
     */
    protected function fetchCountries(null|string $locale = null): CountriesInterface
    {
        // use default locale if none.
        $locale = $locale ?: $this->locale;
        $locale = $this->localeMapping[$locale] ?? $locale;
        
        if (!is_null($countries = $this->fetchCountriesFromFile($locale))) {
            return $countries;
        }
        
        // If the countries does not exist for the given locale, use the locale fallback if any.
        if ($this->getLocaleFallback($locale))
        {
            $locale = $this->getLocaleFallback($locale);
            $locale = $this->localeMapping[$locale] ?? $locale;
            
            if (!is_null($countries = $this->fetchCountriesFromFile($locale))) {
                return $countries;
            }
        }
        
        // Fallback to default locale.
        if ($locale !== $this->locale)
        {
            if (!is_null($countries = $this->fetchCountriesFromFile($this->locale))) {
                return $countries;
            } 
        }
        
        return $this->countriesFactory->createCountries();
    }
    
    /**
     * Fetches the countries from the file.
     *
     * @param null|string $locale
     * @return null|CountriesInterface
     */
    protected function fetchCountriesFromFile(null|string $locale): null|CountriesInterface
    {
        if (is_null($locale)) {
            return null;
        }
        
        // return the countries if they exist in the specific locale.
        if (isset($this->countries[$locale])) {
            return $this->countries[$locale];
        }
        
        if (!$this->isValidLocale($locale)) {
            return null;
        }
        
        $file = $this->directory.$locale.'.json';
        
        if (!file_exists($file)) {
            return null;
        }
            
        return $this->countries[$locale] = $this->countriesFactory->createCountriesFromArray(
            countries: json_decode(file_get_contents($file), true),
            locale: $locale,
        );
    }

    /**
     * Returns true if the locale is valid, otherwise null.
     *
     * @param string $locale
     * @return bool
     */    
    protected function isValidLocale(string $locale): bool
    {
        return (bool) preg_match('/^[a-zA-Z_-]{2,5}$/u', $locale);
    }
    
    /**
     * Returns the locale fallback for the specified locale or null if none.
     *
     * @param string $locale
     * @return null|string
     */    
    protected function getLocaleFallback(string $locale): null|string
    {
        return $this->localeFallbacks[$locale] ?? null;
    }
}