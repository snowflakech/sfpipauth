<?php

namespace Snowflake\Sfpipauth\Service;

/**
 * Class FindUserOrGroupByIpService
 *
 * @package Snowflake\Sfpipauth\Service
 */
class FindUserOrGroupByIpService extends AbstractIpAuthenticationService {


	/**
	 * Find user by incoming ip address
	 *
	 * @return array|bool
	 */
	public function getUser() {

		$user = FALSE;

		if ($this->mode === 'getUserFE' && $this->login['status'] !== 'login') {

			// Find user by incoming ip address
			$user = $this->findUserByIp($this->authInfo['REMOTE_ADDR']);
		}

		return $user;
	}



	/**
	 * Find groups by incoming ip address
	 *
	 * @param array $user
	 * @param array $knownGroups
	 * @return array
	 */
	public function getGroups($user, $knownGroups) {

		// Find groups by incoming ip address
		$groups = $this->findGroupsByIp($this->authInfo['REMOTE_ADDR']);

		return $groups;
	}


}