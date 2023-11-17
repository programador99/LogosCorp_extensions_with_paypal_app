# Store Locator by [LogosCorp](https://logoscorp.com)

This module has the following feactures:

- Show current store in header.
- Show a Sidebar with the list of stores defined in magento.
- Select a favorite store.
- Change store.
- Locate the customer in the closest store according to their geographical location.
- Select the store from the list with a radio button and change store
- Added translations with VueI18n
- Filtered list of stores to prevent duplicates of websites, adds the default store only

## Requirements

- Magento Community Edition 2.3.x - 2.4.x

## Dependencies

- Requires module [base-m2-extension](https://bitbucket.org/logoscorp/base-m2-extension/)

## Installation

- Add the submodule in your Magento 2 `app/code/LogosCorp/` directory

```
git submodule add https://bitbucket.org/logoscorp/storelocator-m2-extension StoreLocator
```

- In command line, using "cd", navigate to your Magento 2 root directory
- Run the commands:

```
php bin/magento setup:upgrade
php bin/magento c:f
```
