# Country Service

A country interface for PHP applications.

## Table of Contents

- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Highlights](#highlights)
- [Documentation](#documentation)
    - [Country Repository](#country-repository)
    - [Country Repository Interface](#country-repository-interface)
    - [Country](#country)
        - [Create Country](#create-country)
        - [Country Factory](#country-factory)
        - [Country Interface](#country-interface)
    - [Countries](#countries)
        - [Create Countries](#create-countries)
        - [Countries Factory](#countries-factory)
        - [Countries Interface](#countries-interface)      
- [Credits](#credits)
___

# Getting started

Add the latest version of the country service project running this command.

```
composer require tobento/service-country
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design

# Documentation

## Country Repository

The country repository loads the countries from json files.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryRepositoryInterface;
use Tobento\Service\Country\CountriesFactoryInterface;

$countryRepository = new CountryRepository(
    locale: 'en', // default
    localeFallbacks: ['es' => 'fr'],
    localeMapping: ['en-GB' => 'en'],
    countriesFactory: null, // null|CountriesFactoryInterface
    directory: null, // if null it loads from the provided country files.
);

var_dump($countryRepository instanceof CountryRepositoryInterface);
// bool(true)
```

## Country Repository Interface

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryRepositoryInterface;

$countryRepository = new CountryRepository();

var_dump($countryRepository instanceof CountryRepositoryInterface);
// bool(true)
```

**findCountry**

Returns a single country by the specified parameters or null if not found.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryInterface;

$countryRepository = new CountryRepository();

$country = $countryRepository->findCountry(code: 'US');

var_dump($country instanceof CountryInterface);
// bool(true)

var_dump($country->name());
// string(13) "United States"

// find by specific locale
$country = $countryRepository->findCountry(
    code: 'US',
    locale: 'de'
);

var_dump($country->name());
string(18) "Vereinigte Staaten"
```

Check out the [Country Interface](#country-interface) to learn more about the interface.

**findCountries**

Returns all countries found by the specified parameters.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountriesInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

var_dump($countries instanceof CountriesInterface);
// bool(true)

// find by specific locale and group
$countries = $countryRepository->findCountries(
    locale: 'de',
    group: 'shipping',
);
```

Check out the [Countries Interface](#countries-interface) to learn more about the interface.

## Country

### Create Country

```php
use Tobento\Service\Country\Country;
use Tobento\Service\Country\CountryInterface;

$country = new Country(code: 'US');

var_dump($country instanceof CountryInterface);
// bool(true)
```

Check out the [Country Interface](#country-interface) to learn more about the interface.

### Country Factory

Easily create a country with the provided countryfactory:

**createCountry**

```php
use Tobento\Service\Country\CountryFactory;
use Tobento\Service\Country\CountryFactoryInterface;
use Tobento\Service\Country\CountryInterface;

$countryFactory = new CountryFactory();

var_dump($countryFactory instanceof CountryFactoryInterface);
// bool(true)

$country = $countryFactory->createCountry(code: 'CH');

var_dump($country instanceof CountryInterface);
// bool(true)
```

**Parameters:**

```php
use Tobento\Service\Country\CountryFactory;

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
```

**createCountryFromArray**

```php
use Tobento\Service\Country\CountryFactory;

$countryFactory = new CountryFactory();

$country = $countryFactory->createCountryFromArray([
    'code' => 'US',
]);
```

### Country Interface

```php
use Tobento\Service\Country\CountryInterface;
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();
$country = $countryRepository->findCountry('US');

var_dump($country instanceof CountryInterface);
// bool(true)

var_dump($country->code());
// string(2) "US"

var_dump($country->code3());
// string(3) "USA"

var_dump($country->numericCode());
// string(3) "840"

var_dump($country->currencyKey());
// string(3) "USD"

var_dump($country->locale());
// string(2) "en"

var_dump($country->name());
// string(13) "United States"

var_dump($country->region());
// string(0) ""

var_dump($country->continent());
// string(13) "North America"

var_dump($country->timezones());
// array(29) { [0]=> string(12) "America/Adak" ... }

var_dump($country->id());
// int(0)

var_dump($country->active());
// bool(true)

var_dump($country->group());
// string(0) ""

var_dump($country->priority());
// int(0)
```

**with methods**

The with methods will return a new instance.

```php
use Tobento\Service\Country\CountryInterface;
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();
$country = $countryRepository->findCountry('US');

var_dump($country instanceof CountryInterface);
// bool(true)

$country = $country->withCurrencyKey('USD');

$country = $country->withLocale('de');

$country = $country->withName('Vereinigte Staaten');

$country = $country->withRegion('Region');

$country = $country->withId(2345);

$country = $country->withActive(false);

$country = $country->withGroup('payment');

$country = $country->withPriority(150);
```

## Countries

### Create Countries

```php
use Tobento\Service\Country\Countries;
use Tobento\Service\Country\CountriesInterface;
use Tobento\Service\Country\Country;
use Tobento\Service\Country\CountryInterface;

$countries = new Countries(
    new Country(code: 'US'), // CountryInterface
    new Country(code: 'CH'),
);

var_dump($countries instanceof CountriesInterface);
// bool(true)
```

Check out [Countries Interface](#countries-interface) to learn more about the interface.

### Countries Factory

Easily create a Countries object with the provided countries factory:

**createCountries**

```php
use Tobento\Service\Country\CountriesFactory;
use Tobento\Service\Country\CountriesFactoryInterface;
use Tobento\Service\Country\CountryFactoryInterface;
use Tobento\Service\Country\CountriesInterface;
use Tobento\Service\Country\CountryInterface;
use Tobento\Service\Country\Country;

$countriesFactory = new CountriesFactory(
    countryFactory: null // null|CountryFactoryInterface
);

var_dump($countriesFactory instanceof CountriesFactoryInterface);
// bool(true)

$countries = $countriesFactory->createCountries(
    new Country(code: 'US'), // CountryInterface
    new Country(code: 'CH'),
);

var_dump($countries instanceof CountriesInterface);
// bool(true)
```

Check out [Countries Interface](#countries-interface) to learn more about the interface.

**createCountriesFromArray**

```php
use Tobento\Service\Country\CountriesFactory;
use Tobento\Service\Country\CountriesInterface;

$countriesFactory = new CountriesFactory();

$countries = $countriesFactory->createCountriesFromArray([
    ['code' => 'US'],
    ['code' => 'CH'],
]);

var_dump($countries instanceof CountriesInterface);
// bool(true)
```

Check out [Countries Interface](#countries-interface) to learn more about the interface.

### Countries Interface

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountriesInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

var_dump($countries instanceof CountriesInterface);
// bool(true)
```

**addCountry**

Adds a country.

```php
use Tobento\Service\Country\CountriesFactory;
use Tobento\Service\Country\CountryInterface;
use Tobento\Service\Country\Country;

$countries = (new CountriesFactory())->createCountries();

$countries->addCountry(
    country: new Country(code: 'US') // CountryInterface
);
```

**addCountries**

```php
use Tobento\Service\Country\CountriesFactory;
use Tobento\Service\Country\CountryInterface;
use Tobento\Service\Country\Country;

$countries = (new CountriesFactory())->createCountries();

$countries->addCountries(
    new Country(code: 'US'), // CountryInterface
    new Country(code: 'CH'),
);
```

**sort**

Returns a new instance with the countries sorted.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

// sorted by country name.
$countries = $countries->sort();

// sort by callback.
$countries = $countries->sort(
    fn(CountryInterface $a, CountryInterface $b): int
        => $a->priority() <=> $b->priority()
);
```

**filter**

Returns a new instance with the filtered countries.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->filter(
    fn(CountryInterface $c): bool => in_array($c->locale(), ['de', 'en'])
);
```

**code**

Returns a new instance with the specified code filtered.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->code(code: 'US');
```

**locale**

Returns a new instance with the specified locale filtered.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->locale(locale: 'de');
```

**group**

Returns a new instance with the specified group filtered.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->group(group: 'shipping');
```

**region**

Returns a new instance with the specified region filtered.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->region(region: 'nearBy');
```

**continent**

Returns a new instance with the specified continent filtered.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->continent(continent: 'Europe');
```

**all**

Returns all countries.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

foreach($countries->all() as $country) {
    var_dump($country instanceof CountryInterface);
    // bool(true)
}

// or just
foreach($countries as $country) {
    var_dump($country instanceof CountryInterface);
    // bool(true)
}
```

**first**

Returns the first country or null if none.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$country = $countries->first();

var_dump($country instanceof CountryInterface);
// bool(true)
```

**get**

Returns the first country found by code, code3, numericCode and/or locale.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$country = $countries->get(code: 'US');

var_dump($country instanceof CountryInterface);
// bool(true)

// and with locale
$country = $countries->get(code: 'US', locale: 'en');

var_dump($country instanceof CountryInterface);
// bool(true)
```

**column**

Returns the column of the countries.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$column = $countries->column('name');

var_dump($column);
// array(249) { [0]=> string(11) "Afghanistan" ... }

// indexed by country code 
$column = $countries->column(column: 'name', index: 'code');

var_dump($column);
// { ["AF"]=> string(11) "Afghanistan" ... }
```

**groupedColumn**

Returns the column of the countries grouped.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$column = $countries->groupedColumn(
    group: 'continent',
    column: 'name',
    index: 'code', // optional
);

print_r($column);
/*Array
(
    [Asia] => Array
        (
            [AF] => Afghanistan
            ...
        )
    [Europe] => Array
        (
            [AX] => Åland Islands
            ...
        )
    ...
)*/
```

**only**

Returns a new instance with countries with only the codes specified.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->only(['CH', 'US']);
```

**except**

Returns a new instance with countries except the codes specified.

```php
use Tobento\Service\Country\CountryRepository;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->except(['CH', 'US']);
```

**map**

Returns a new instance with the countries mapped.

```php
use Tobento\Service\Country\CountryRepository;
use Tobento\Service\Country\CountryInterface;

$countryRepository = new CountryRepository();

$countries = $countryRepository->findCountries();

$countries = $countries->map(function(CountryInterface $c): CountryInterface {
    if (in_array($c->code(), ['CH', 'FR'])) {
        return $c->withRegion('Near by')->withPriority(100);
    }
    return $c->withRegion('All Others');
});
```

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)