<?php

namespace Snowflake\Sfpipauth\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FindUserGroupService
 *
 * @package Snowflake\Sfpipauth\Service
 */
class FindUserGroupService extends AbstractIpAuthenticationService {


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
	 * Authenticate user by ip
	 *
	 * @param array $user
	 * @return bool|int
	 */
	public function authUser($user) {

		// If there is no ip list given then the user is valid
		$authentication = 100;

		if ($this->authInfo['loginType'] === 'FE' && $this->login['status'] !== 'login') {

			// Find ip configuration for provided user
			$ipConfiguration = $this->findConfigurationByUserId($user['uid']);

			if ($ipConfiguration !== NULL) {

				$userIp = $this->authInfo['REMOTE_ADDR'];
				$ipMatch = GeneralUtility::cmpIP($userIp, $ipConfiguration['ip']);

				switch ($ipConfiguration['loginmode']) {
					case 0:
						$authentication = 100;
						break;
					case 1:
						$authentication = $ipMatch ? 200 : 100;
						break;
					case 2:
						$authentication = $ipMatch ? 200 : FALSE;
						break;
					case 3:
						$authentication = $ipMatch ? 100 : FALSE;
						break;
					default:
						$this->writelog(255, 3, 3, 1, 'No loginmode (%s) but IP-match (%s). That\'s one weird user: %s.',
							array ($ipConfiguration['loginmode'], $ipConfiguration['ip'], $userIp));
						break;
				}
			}
		}

		return $authentication;
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