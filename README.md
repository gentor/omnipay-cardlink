# omnipay-cardlink

**Cardlink driver for the Omnipay PHP payment processing library**

Omnipay implementation of the Cardlink payment gateway.

[![Build Status](https://travis-ci.org/digitickets/omnipay-cardlink.png?branch=master)](https://travis-ci.org/digitickets/omnipay-cardlink)
[![Coverage Status](https://coveralls.io/repos/github/digitickets/omnipay-cardlink/badge.svg?branch=master)](https://coveralls.io/github/digitickets/omnipay-cardlink?branch=master)
[![Latest Stable Version](https://poser.pugx.org/digitickets/omnipay-cardlink/version.png)](https://packagist.org/packages/digitickets/omnipay-cardlink)
[![Total Downloads](https://poser.pugx.org/digitickets/omnipay-cardlink/d/total.png)](https://packagist.org/packages/digitickets/omnipay-cardlink)

## Installation

**Important: Driver requires [PHP's Intl extension](http://php.net/manual/en/book.intl.php) and [PHP's SOAP extension](http://php.net/manual/en/book.soap.php) to be installed.**

**All payment details sent to the Payment Gateway must be UTF-8 encoded.**

The Cardlink Omnipay driver is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "digitickets/omnipay-cardlink": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## What's Included

This driver handles transactions being processed by the hosted version of Cardlink.

## What's Not Included

It does not (currently) handle refunds.

## Basic Usage

For general Omnipay usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you believe you have found a bug in this driver, please report it using the [GitHub issue tracker](https://github.com/digitickets/omnipay-cardlink/issues),
or better yet, fork the library and submit a pull request.
