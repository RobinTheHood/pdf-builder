<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Old\Helper;

class CustomerHelper
{

    public function getCustomerId($customer)
    {
        if (PDF_USE_CUSTOMER_ID == 'true') {
            $customerId = $customer['customers_id'];
        } else {
            $customerId = $customer['customers_cid'];
        }

        return $customerId;
    }

    public function getCustomerGender($customerId)
    {
        $sql = "SELECT customers_gender FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . (int) $customerId . "'";

        $query = xtc_db_query($sql);
        $row = xtc_db_fetch_array($query);
        return $row['customers_gender'];
    }
}
