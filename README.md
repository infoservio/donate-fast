# DonateFast | Stripe for Craft 3

This plugin can be used for anyone that accept donations to help others.

[![forthebadge](https://img.shields.io/badge/style-PHP-green.svg?style=for-the-badge&label=made-with&colorA=ef4041&colorB=c1282d)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/style-LOVE-green.svg?style=for-the-badge&label=built-with&colorA=e36d25&colorB=d15d27)](http://forthebadge.com)

[![Github All Releases](https://img.shields.io/github/downloads/infoservio/donate-fast/total.svg)]()
[![GitHub tag](https://img.shields.io/github/tag/infoservio/donate-fast.svg)]()
[![GitHub package version](https://img.shields.io/github/package-json/v/infoservio/donate-fast.svg)]()

# Table of contents

- [Requirements](#requirements)
- [Usage](#usage)
- [Installation](#installation)
- [Overview](#overwiew)
- [Configuring](#configuring)
- [Roadmap](#roadmap)
- [License](LICENSE.md)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Usage 

[(Back to top)](#table-of-contents)

You have to create form with amount input if you need to and button for donation process. You can manually set up it with css, name button too. Also, you have to add checkout stripe library and our donate-fast library. Anyway, you can setup our script for you goals. You can set up button for donation fixed amount of money or give an opportunity for users to put amount by hand. More about attributes and their definitions in the docs for donate-fast script.

```html
 <form id="donate-fast-form" action="/donate-fast/donate" method="post">
    <input id="amount" type="number" name="amount">
    <button id="donate-btn" class="btn">Donate</button>
 </form>
 <script src="https://checkout.stripe.com/checkout.js"></script>
 <script id="donate-fast-script" src="https://cdn.infoserv.io/donate-fast.min.js"
       data-stripe-public-key="your_stripe_public_key"
       data-stripe-form-name="Donation"
       data-stripe-form-description="One-time donation"
       data-form-id="donate-fast-form"
       data-btn-id="donate-btn"
       data-amount-min="5"
       data-amount-input-id="amount"
       data-project-id="1"
       data-project-name="name"></script>
```

## Installation

[(Back to top)](#table-of-contents)

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require donate-fast

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for donate-fast.

## Overview

For testing purpose you can try stripe form.
Credit card number: 4242 4242 4242 4242
https://sandbox.infoserv.org/stripe

## Configuring

##### You have to fill in stripe keys in settings of the donate-fast.
Go to Settings -> Plugins -> Donate Fast ---- Settings
###### Where to get stripe tokens:
API credentials are unique account identifiers that must be added to your code before you can process payments via the     API. Think of them as your username and password to payment processing.
This is your user-specific public identifier. Each user associated with your Stripe gateway will have their own public and private keys.
To find your keys:
- Log into either the production Control Panel or the sandbox Control Panel, depending on which environment you are working in
- Navigate to Account > My User
- Under API Keys, Token Keys, Encryption Keys, click View Authorizations

You'll find your keys under the API Keys section at the top. If no API keys appear, click Generate New API Key.

##### You should also fill in information about your non-profit organizations and success with error messages for users.
Go to Donate Fast -> Settings

## Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [infoserv.io](https://infoserv.io)