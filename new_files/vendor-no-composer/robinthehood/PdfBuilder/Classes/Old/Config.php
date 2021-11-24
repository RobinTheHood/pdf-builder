<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Old;

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

    public static function getProductModelLength(): int
    {
        return (int) (defined('RTH_PDF_BUILDER_PRODUCT_MODEL_LENGTH') ? RTH_PDF_BUILDER_PRODUCT_MODEL_LENGTH : 0);
    }

    public static function getShowManufacturerModel(): bool
    {
        if (
            defined('RTH_PDF_BUILDER_SHOW_MANUFACTURER_MODEL')
            && RTH_PDF_BUILDER_SHOW_MANUFACTURER_MODEL == 'true'
        ) {
            return true;
        }
        return false;
    }

    public static function getManufacturerModel(): string
    {
        return defined('RTH_PDF_BUILDER_MANUFACTURER_MODEL') ? RTH_PDF_BUILDER_MANUFACTURER_MODEL : '';
    }

    public static function getCustomerGroupIdsInEu(): array
    {
        $customerGroupIdsInEu = [];
        if (defined('RTH_PDF_BUILDER_CUSTOMER_GROUP_IDS_IN_EU')) {
            $cleanedString = preg_replace("'[\r\n\s]+'", '', RTH_PDF_BUILDER_CUSTOMER_GROUP_IDS_IN_EU);
            $customerGroupIdsInEu = explode(',', $cleanedString);
        }
        return $customerGroupIdsInEu;
    }

    public static function getCustomerGroupIdsOutsideEu(): array
    {
        $customerGroupIdsOutsideEu = [];
        if (defined('RTH_PDF_BUILDER_CUSTOMER_GROUP_IDS_OUTSIDE_EU')) {
            $cleanedString = preg_replace("'[\r\n\s]+'", '', RTH_PDF_BUILDER_CUSTOMER_GROUP_IDS_OUTSIDE_EU);
            $customerGroupIdsOutsideEu = explode(',', $cleanedString);
        }
        return $customerGroupIdsOutsideEu;
    }

    public static function getEuCustomersGroupId(): array
    {
        $euCustomersGroupId = [];
        if (defined('RTH_PDF_BUILDER_EU_CUSTOMERS_GROUP_ID')) {
            $cleanedString = preg_replace("'[\r\n\s]+'", '', RTH_PDF_BUILDER_EU_CUSTOMERS_GROUP_ID);
            $euCustomersGroupId = explode(',', $cleanedString);
        }
        return $euCustomersGroupId;
    }

    public static function getLogoX(): int
    {
        return (int) (defined('RTH_PDF_BUILDER_LOGO_X') ? RTH_PDF_BUILDER_LOGO_X : '');
    }

    public static function getLogoY(): int
    {
        return (int) (defined('RTH_PDF_BUILDER_LOGO_Y') ? RTH_PDF_BUILDER_LOGO_Y : '');
    }

    public static function getLogoScale(): int
    {
        return (int) (defined('RTH_PDF_BUILDER_LOGO_SCALE') ? RTH_PDF_BUILDER_LOGO_SCALE : '');
    }
}
