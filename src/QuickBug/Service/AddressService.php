<?php

namespace QuickBug\Service;

use QuickBug\Common\ArrayToolkit;

class AddressService extends BaseService
{
    public function getAddress($id)
    {
        return $this->getAddressDao()->getAddress($id);
    }

    public function importAddresses($groupId, $sourceId, $emails)
    {
        shuffle($emails);
        $now = time();

        $addresses = [];

        foreach ($emails as $email) {
            $email = strtolower(trim($email));
            if (!empty($addresses[$email])) {
                // echo $email . "\n";
                continue;
            }
            $addresses[$email] = array(
                'groupId' => $groupId,
                'sourceId' => $sourceId,
                'email' => $email,
                'createdTime' => $now,
            );
        }

        $addresses = array_values($addresses);

        $this->getAddressDao()->addAddresses($addresses);
    }

    public function deleteAddresses($ids)
    {
        foreach ($ids as $id) {
            $this->getAddressDao()->deleteAddress($id);
        }
    }

    public function trashAddresses($ids)
    {
        foreach ($ids as $id) {
            $address = $this->getAddress($id);
            if (empty($address)) {
                continue;
            }
            $this->getBlacklistService()->putInBlacklist($address['email']);
            $this->getAddressDao()->deleteAddress($id);
        }
    }

    public function searchAddresses($conditions, $orderBy, $start, $limit)
    {
        return $this->getAddressDao()->searchAddresss($conditions, $orderBy, $start, $limit);
    }

    public function searchAddressesCount($conditions)
    {
        return $this->getAddressDao()->searchAddresssCount($conditions);
    }

    protected function getAddressDao()
    {
        return $this->kernel()->dao('AddressDao');
    }

    protected function getBlacklistService()
    {
        return $this->kernel()->service('BlacklistService');
    }
}
