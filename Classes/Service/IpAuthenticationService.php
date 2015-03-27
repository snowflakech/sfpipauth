<?php
namespace Snowflake\Sfpipauth\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * Class IpAuthenticationService
 *
 * @package Snowflake\Sfpipauth\Service
 */
class IpAuthenticationService extends AbstractIpAuthenticationService {


	/**
	 * Authenticate user by ip
	 *
	 * @param array $user
	 * @return bool|int
	 */
	public function authUser($user) {

		// If there is no ip list given then the user is valid
		$authentication = 100;

		if ($this->authInfo['loginType'] == 'FE') {

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

		if (!$authentication && $this->writeAttemptLog) {
			$this->writelog(255, 3, 3, 1,
				"Login-attempt from %s (%s), username '%s', remote address do not match IP list!",
				Array ($this->authInfo['REMOTE_ADDR'], $this->authInfo['REMOTE_HOST'], $user[$this->db_user['username_column']]));
		}

		return $authentication;

	}


	/**
	 * Authenticate group by ip
	 *
	 * @param $user
	 * @param $group
	 * @return bool
	 */
	public function authGroup($user, $group) {

		$authentication = TRUE;

		if ($this->mode == 'authGroupsFE') {

			// Find ip configuration for provided user
			$ipConfiguration = $this->findConfigurationByGroupId($group['uid']);

			if ($ipConfiguration !== NULL) {

				$userIp = $this->authInfo['REMOTE_ADDR'];
				$ipMatch = GeneralUtility::cmpIP($userIp, $ipConfiguration['ip']);

				switch ($ipConfiguration['loginmode']) {
					case 0:
						$authentication = is_array($user);
						break;
					case 2:
						$authentication = $ipMatch;
						break;
					case 3:
						$authentication = $ipMatch;
						break;
				}

			}

		}

		return $authentication;
	}

}