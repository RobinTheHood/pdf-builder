<?php

namespace RobinTheHood\PdfBuilder\Classes\Helper;

class PaymentHelper
{
    public static function getPaymentMethodName($paymentMethod, $language)
    {
        if ($paymentMethod == '' || $paymentMethod == 'no_payment') {
            return '';
        }

        LanguageHelper::loadLanguageFile($language, '/modules/payment/' . $paymentMethod . '.php');

        $constantName = strtoupper('MODULE_PAYMENT_' . $paymentMethod . '_TEXT_TITLE');
        $paymentMethodName = constant($constantName) ?? 'unbekannt';

        return $paymentMethodName;
    }
}
