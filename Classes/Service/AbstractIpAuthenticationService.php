<?php
namespace Snowflake\Sfpipauth\Service;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Sv\AuthenticationService;

/**
 * Class AbstractIpAuthenticationService
 *
 * @package Snowflake\Sfpipauth\Service
 */
class AbstractIpAuthenticationService extends \TYPO3\CMS\Sv\AbstractAuthenticationService {


	/**
	 * @var array
	 */
	protected $ipConfigurations = [];


	// TODO: $this->cObj->enableFields

	public function __construct() {

		// Get all available ip configurations
		$result = $this->getDatabaseConnection()->exec_SELECTgetRows(
			'ip,feusers,fegroups,loginmode',
			'tx_sfpipauth_ipconfiguration',
			'hidden=0 AND deleted=0'
		);

		if (is_array($result)) {
			$this->ipConfigurations = $result;
		}

	}


	/**
	 * Find user which matches provided ip
	 *
	 * @param $userIp
	 * @return array|bool
	 */
	protected function findUserByIp($userIp) {

		$user = FALSE;

		foreach ($this->ipConfigurations as $ipConfiguration) {

			$userId = $ipConfiguration['feusers'];

			// Check if ip address matches && user ID is valid
			if ($userId > 0 && GeneralUtility::cmpIP($userIp, $ipConfiguration['ip'])) {

				// Get user from database
				$user = $this->pObj->getRawUserByUid($userId);

			}
		}

		return $user;

	}


	/**
	 * Find groups which matches provided ip
	 *
	 * @param $userIp
	 * @return array
	 */
	protected function findGroupsByIp($userIp) {

		$groups = [];
		$hiddenP = '';

		if (!$this->authInfo['showHiddenRecords']) {
			$hiddenP = 'AND hidden=0 ';
		}

		$lockToDomain_SQL = ' AND (lockToDomain=\'\' OR lockToDomain IS NULL OR lockToDomain=\'' . $this->authInfo['HTTP_HOST'] . '\')';

		foreach ($this->ipConfigurations as $ipConfiguration) {

			// Check if ip address matches && group ID is valid
			if (GeneralUtility::cmpIP($userIp, $ipConfiguration['ip'])) {

				$groupIds = array_unique(explode(',', $ipConfiguration['fegroups']));

				if (count($groupIds) !== 0) {

					$groupList = implode(',', $groupIds);

					$result = $this->getDatabaseConnection()->exec_SELECTquery(
						'*',
						$this->db_groups['table'],
						'deleted=0 ' . $hiddenP . ' AND uid IN (' . $groupList . ')' . $lockToDomain_SQL
					);

					while ($row = $this->getDatabaseConnection()->sql_fetch_assoc($result)) {
						$groups[$row['uid']] = $row;
					}

					if ($result) {
						$this->getDatabaseConnection()->sql_free_result($result);
					}

				}

			}
		}

		return $groups;

	}


	/**
	 * @param $userId
	 * @return null|
	 */
	protected function findConfigurationByUserId($userId) {

		$configuration = NULL;

		foreach ($this->ipConfigurations as $ipConfiguration) {

			// If user found & ip address matches, set login mode & stop foreach
			if (intval($userId) > 0 && (int)$ipConfiguration['feusers'] === (int)$userId) {
				$configuration = $ipConfiguration;
				break;
			}

		}

		return $configuration;

	}


	/**
	 * @param $groupId
	 * @return null
	 */
	protected function findConfigurationByGroupId($groupId) {

		$configuration = NULL;

		foreach ($this->ipConfigurations as $ipConfiguration) {

			$groupId = intval($groupId);
			$groupIds = array_unique(explode(',', $ipConfiguration['fegroups']));

			// If user found & ip address matches, set login mode & stop foreach
			if ($groupId > 0 && in_array($groupId, $groupIds, TRUE)) {
				$configuration = $ipConfiguration;
				break;
			}

		}

		return $configuration;

	}


	/**
	 * Gets the database object.
	 *
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	public static function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}


}