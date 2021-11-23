<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes;

class Config
{
    public static function getShopRoot(): string
    {
        return defined('DIR_FS_CATALOG') ? DIR_FS_CATALOG : '';
    }

    public static function getCurrentTemplate(): string
    {
        return defined('CURRENT_TEMPLATE') ? CURRENT_TEMPLATE : '';
    }

    public static function getShowDiffDeliveryAddress(): bool
    {
        if (defined('RTH_PDF_BUILDER_SHOW_DIFF_DELIVERY_ADRESS') && RTH_PDF_BUILDER_SHOW_DIFF_DELIVERY_ADRESS == 'true') {
            return true;
        }
        return false;
    }

    public static function getShopAddressSmall(): string
    {
        return defined('RTH_PDF_BUILDER_SHOP_ADDRESS_SMALL') ? RTH_PDF_BILL_SHOP_ADDRESS_SMALL : '';
    }

    public static function getShowAmazonOrderIdAsCode128(): bool
    {
        if (
            defined('RTH_PDF_BUILDER_SHOW_AMAZON_ORDER_ID_AS_CODE128')
            && RTH_PDF_BUILDER_SHOW_AMAZON_ORDER_ID_AS_CODE128 == 'true'
        ) {
            return true;
        }
        return false;
    }

    public static function getHiedeAttributeModel(): bool
    {
        if (
            defined('RTH_PDF_BUILDER_HIDE_ATTRIBUTE_MODLE')
            && RTH_PDF_BUILDER_HIDE_ATTRIBUTE_MODLE == 'true'
        ) {
            return true;
        }
        return false;
    }

    public static function getShowGroupedVatTotals(): bool
    {
        if (
            defined('RTH_PDF_BUILDER_SHOW_GROUPED_VAT_TOTALS')
            && RTH_PDF_BUILDER_SHOW_GROUPED_VAT_TOTALS == 'true'
        ) {
            return true;
        }
        return false;
    }
}
