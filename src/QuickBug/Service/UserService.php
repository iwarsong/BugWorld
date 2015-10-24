<?php


namespace QuickBug\Service;


class UserService extends BaseService
{
	public function findAllUsers()
	{
		return $this->getUserDao()->findAllUsers();
	}

	public function getUser($userId)
	{
		return $this->getUserDao()->getUser($userId);
	}

	protected function getUserDao()
	{
		return $this->kernel()->dao('UserDao');
	}
}