<?php


namespace QuickBug\Service;


class UserService extends BaseService
{
	public function findAllUsers()
	{
		return $this->getUserDao()->findAllUsers();
	}

	protected function getUserDao()
	{
		return $this->kernel()->dao('UserDao');
	}
}