<?php

namespace QuickBug\Dao;

class AddressDao extends BaseDao
{
    protected $table = 'address';

    public function getAddress($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
        return $this->db()->fetchAssoc($sql, array($id)) ?: null;
    }

    public function addAddress($address)
    {
        $affected = $this->db()->insert($this->table, $address);
        if ($affected <= 0) {
            throw $this->createDaoException('Insert address error.', 51001);
        }

        return $this->getAddress($this->db()->lastInsertId());
    }

    public function addAddresses($addresses)
    {
        try {
            $this->db()->beginTransaction();

            foreach ($addresses as $address) {
                $affected = $this->db()->insert($this->table, $address);
                if ($affected <= 0) {
                    throw $this->createDaoException('Batch add addresses error.');
                }
            }
            $this->db()->commit();
        } catch(\Exception $e) {
            var_dump($e);exit();
            $this->db()->rollback();
        }
    }

    public function updateAddress($id, $fields)
    {
        $this->db()->update($this->table, $fields, array('id' => $id));

        return $this->getAddress($id);
    }

    public function deleteAddress($id)
    {
        return $this->db()->delete($this->table, ['id' =>$id]);
    }

    public function searchAddresss($conditions, $order, $start, $limit)
    {
        $this->filterStartLimit($start, $limit);
        $builder = $this->createAddressQueryBuilder($conditions)
            ->select('*')
            ->addOrderBy($order[0], $order[1])
            ->setFirstResult($start)
            ->setMaxResults($limit);

        return $builder->execute()->fetchAll() ?: array();
    }

    public function searchAddresssCount($conditions)
    {
        $builder = $this->createAddressQueryBuilder($conditions)
            ->select('COUNT(id)');

        return $builder->execute()->fetchColumn(0) ? : 0;
    }

    protected function createAddressQueryBuilder($conditions)
    {
        $conditions = array_filter($conditions, function ($value) {
            if ($value === '' || $value === null) {
                return false;
            }

            return true;
        });

        if (!empty($conditions['keyword'])) {
            $conditions['keyword'] = "%{$conditions['keyword']}%";
        }

        $builder = $this->createDynamicQueryBuilder($conditions)
            ->from($this->table, 'hosts')
            ->andWhere('groupId = :groupId')
            ->andWhere('sourceId = :sourceId')
            ->andWhere('suspected = :suspected')
            ->andWhere('email = :email')
            ->andWhere("email LIKE :keyword");


        return $builder;
    }

}