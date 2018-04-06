# Donate Fast With Stripe for Craft 3

This plugin can be used for non-profit companies that accept donations to help others.

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
- [License](#license)

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
       data-amount="100"
       data-amount-min="5"
       data-amount-default-validation="true"
       data-amount-input-id="amount"
       data-amount-fixed="false"
       data-additional-information="true"
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

Brought to you by [infoser.io](https://infoserv.io)

## License

Copyright © infoser.io, Inc.

Permission is hereby granted to any person obtaining a copy of this software (the “Software”) to use, copy, modify, merge, publish and/or distribute copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

- Don’t plagiarize. The above copyright notice and this license shall be included in all copies or substantial portions of the Software.

- Don’t use the same license on more than one project. Each licensed copy of the Software shall be actively installed in no more than one production environment at a time.

- Don’t mess with the licensing features. Software features related to licensing shall not be altered or circumvented in any way, including (but not limited to) license validation, payment prompts, feature restrictions, and update eligibility.

- Pay up. Payment shall be made immediately upon receipt of any notice, prompt, reminder, or other message indicating that a payment is owed.

- Follow the law. All use of the Software shall not violate any applicable law or regulation, nor infringe the rights of any other person or entity.

Failure to comply with the foregoing conditions will automatically and immediately result in termination of the permission granted hereby. This license does not include any right to receive updates to the Software or technical support. Licensees bear all risk related to the quality and performance of the Software and any modifications made or obtained to it, including liability for actual and consequential harm, such as loss or corruption of data, and any necessary service, repair, or correction.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES, OR OTHER LIABILITY, INCLUDING SPECIAL, INCIDENTAL AND CONSEQUENTIAL DAMAGES, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
