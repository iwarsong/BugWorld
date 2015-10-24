<?php


namespace QuickBug\Dao;


class UserDao extends BaseDao
{
	protected $table = 'user';

	public function findAllUsers()
	{
		$sql = "SELECT * FROM {$this->table} ";
        return $this->db()->fetchAll($sql, array()) ?: null;
	}

	public function getUser($userId)
	{
		$sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1 ";
		return $this->db()->fetchAssoc($sql,array($userId));
	}
}