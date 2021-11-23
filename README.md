# modified Module: Pdf Builder
[![dicord](https://img.shields.io/discord/727190419158597683)](https://discord.gg/9NqwJqP)

🛠 This module is under development

## Installation
You can install this module with the [Modified Module Loader Client (MMLC)](http://module-loader.de).

Search for: `robinthehood/pdf-builder`

## Authors
- Robin Wieschendorf | <mail@robinwieschendorf.de> | [robinwieschendorf.de](https://robinwieschendorf.de)

## Contributing
We would be happy if you would like to take part in the development of this module. If you wish more features or you want to make improvements or to fix errors feel free to contribute. In order to contribute, you just have to fork this repository and make pull requests.

### Coding Style
We are using:
- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [PSR-12: Extended Coding Style](https://www.php-fig.org/psr/psr-12/)

### Version and Commit-Messages
We are using:
- [Semantic Versioning 2.0.0](https://semver.org)
- [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/)

## TODO

### Config options
| NAME                            | TYPE       | EXAMPLE VALUE | COMMENT |
|---------------------------------|------------|---------------|---------|
| SHOW_DIFF_DELIVERY_ADRESS       | bool       |               ||
| SHOW_ORDER_ID_ON_BILL           | bool       |               ||
| SHOW_DOCUMENT_ID                | bool       |               ||
| HIDE_CUSTOMER_NUMBER            | bool       |               ||
| HIDE_ATTRIBUTE_MODLE            | bool       |               ||
| HIDE_PAGES                      | bool       |               ||
| SHOW_MANUFACTURER_MODEL         | bool       |               ||
| SHOW_AMAZON_ORDER_ID_AS_CODE128 | bool       |               ||
| SHOW_GROUPED_VAT_TOTALS         | bool       |               ||
| CUSTOMER_GROUP_IDS_IN_EU        | array(int) |               | customer group IDs separated by commas |
| CUSTOMER_GROUP_IDS_OUTSIDE_EU   | array(int) |               | customer group IDs separated by commas |
| LOGO_X                          | int        | 100           ||
| LOGO_Y                          | int        | 100           ||
| LOGO_SCALE                      | int        | 0.75          ||
