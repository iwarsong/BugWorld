<?php


namespace QuickBug\Dao;


class UserDao extends BaseDao
{
	protected $table = 'user';
	public function findAllUsers()
	{
		$sql = "SELECT * FROM {$this->table} ";
        return $this->db()->fetchAssoc($sql, array()) ?: null;
	}
}