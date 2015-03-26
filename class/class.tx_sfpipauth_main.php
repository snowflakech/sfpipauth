<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Christoph Buchli | snowflake <support@snowflake.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_t3lib.'class.t3lib_svbase.php');

/**
 * Service "IP-Auth FE-User" for the "sfpipauth" extension.
 *
 * @author	Christoph Buchli | snowflake productions gmbh <support@snowflake.ch>
 * @package	TYPO3
 * @subpackage	tx_sfpipauth
 */
class tx_sfpipauth_main extends tx_sv_authbase {
	/**
	 * @return void
	 */
	function getAllIps($additionalWhere = '') {

		$ResultIpMatch = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$Fields		= 'ip,feusers,fegroups,loginmode',
			$From		= 'tx_sfpipauth_ipconfiguration',
			$WhereIp	= 'hidden=0 AND deleted=0'.$additionalWhere,
			$GroupBy	= '',
			$OrderBy	= '',
			$Limit		= ''
		);

		if(is_array($ResultIpMatch)) {
			return $ResultIpMatch;
		}
		else {
			return false;
		}
	}

	/**
	 * @param  $Ids
	 * @return array|bool
	 */
	function checkGroupIds($Ids) {

		if(is_string($Ids)) {

				// Returns Array
			if(strpos($Ids, ',') !== false) {
				return explode(',', $Ids);
			}
				// Returns Single Value
			else {
				return array(0 => $Ids);
			}

		}
		else {
			return false;
		}

	}

	function getAuthorizedUser($UserId) {

		$UserTable 			= $this->db_user['table'];
		$Where				= 'uid=' . $UserId;

		$UserPidList = $this->db_user['checkPidList'];

			// Create 'Where'
		$Where .= $this->db_user['enable_clause'];

		if($UserPidList) {
			$Where .= ' AND pid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($UserPidList).')';
		}

		$User = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$Fields		= '*',
			$From		= $UserTable,
			$Where		= $Where,
			$GroupBy	= '',
			$OrderBy	= '',
			$Limit		= '1'
		);
			// Get Back Data If Something Available
		if(count($User) > 0) {
			return $User[0];
		}
			// Otherwise Return False
		else {
			return false;
		}

	}

	/**
	 * @param  $GroupId
	 * @return bool
	 */
	function getAuthorizedGroup($GroupId) {

		$UserHttp			= $this->authInfo['HTTP_HOST'];
		$ShowHiddenGroups	= $this->authInfo['showHiddenRecords'];
		$GroupTable			= $this->db_groups['table'];
		$lockToDomain_SQL	= ' AND (lockToDomain=\'\' OR lockToDomain IS NULL OR lockToDomain=\''. $UserHttp .'\')';

			// SQL Where
		$Where		= 'deleted=0';
		if(!$ShowHiddenGroups) $Where .= ' AND hidden=0';

		$Group = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$Fields		= '*',
			$From		= $GroupTable,
			$Where		.= $lockToDomain_SQL . ' AND uid=' . $GroupId,
			$GroupBy	= '',
			$OrderBy	= '',
			$Limit		= '1'
		);

			// Get Back Data If Something Available
		if(count($Group) > 0) {
			return $Group[0];
		}
			// Otherwise Return False
		else {
			return false;
		}

	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sfpipauth/class/class.tx_sfpipauth_main.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sfpipauth/class/class.tx_sfpipauth_main.php']);
}

?>
