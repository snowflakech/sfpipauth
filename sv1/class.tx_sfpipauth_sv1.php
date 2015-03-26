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

require_once(t3lib_extMgm::extPath('sfpipauth').'class/class.tx_sfpipauth_main.php');


/**
 * Service "IP-Auth FE-User" for the "sfpipauth" extension.
 *
 * @author	Christoph Buchli | snowflake productions gmbh <support@snowflake.ch>
 * @package	TYPO3
 * @subpackage	tx_sfpipauth
 */
class tx_sfpipauth_sv1 extends tx_sfpipauth_main {
				var $prefixId = 'tx_sfpipauth_sv1';		// Same as class name
				var $scriptRelPath = 'sv1/class.tx_sfpipauth_sv1.php';	// Path to this script relative to the extension dir.
				var $extKey = 'sfpipauth';	// The extension key.
	
	/**
	 * Find a user by IP ('REMOTE_ADDR')
	 *
	 * @return	mixed	user array or false
	 */
	function getUser()	{
			// Set Readable Values
		$UserIp = $this->authInfo['REMOTE_ADDR'];
			// Get All
		$IPs = $this->getAllIps(" AND feusers NOT LIKE ''");
		if($IPs && $this->mode=='getUserFE' && $this->login['status']!='login') {
			foreach($IPs as $IP) {

					// Checks If Any IP Matches
				if(t3lib_div::cmpIP($UserIp, $IP['ip'])) {
					if(!empty($IP['feusers'])) {
							// Only Add Existing Userdata
						$UserData = $this->getAuthorizedUser($IP['feusers']);
						if($UserData) return $UserData;
					}
				}
			}
		}
		return false;
	}

	/**
	 * Authenticate a user
	 * Return 200 if the IP is right. This means that no more checks are needed. Otherwise authentication may fail because we may don't have a password.
	 *
	 * @param	array 	Data of user.
	 * @return	boolean
	 */
	function authUser($user)	{
			// if there's no IP-list given then the user is valid
		$Return=100;
			// Set Readable Values
		$UserIp = $this->authInfo['REMOTE_ADDR'];

		$IPs = $this->getAllIps(" AND CONCAT(',',feusers,',') LIKE '%,".$user['uid'].",%'");

		if(is_array($IPs) && $this->authInfo['loginType']=='FE' && $this->login['status']!='login') {
	 		foreach($IPs as $IP) {
				$match = t3lib_div::cmpIP($UserIp, $IP['ip']);
				if ($match) {
					switch ($IP['loginmode']) {
						case 0:
							$Return = 100;
							break;
						case 1:
							$Return = $match ? 200 : 100;
							break;
						case 2:
							$Return = $match ? 200 : false;
							break;
						case 3:
							$Return = $match ? 100 : false;
							break;
						default:
							$this->writelog(255,3,3,1,'No loginmode (%s) but IP-match (%s). That\'s one weird user: %s.',
									array($IP['loginmode'],$IP['ip'],$UserIp));
							break;
					}
				}
			}
		}
		return $Return;
	}

	/**
	 * fetch groups by ip
	 *
	 * @param	array 	Data of user.
	 * @param	array 	Already known groups
	 * @return	mixed 	groups array
	 */
	function getGroups($user, $knownGroups) {
		$Groups = array();

				// Set Readable Values
		$UserIp = $this->authInfo['REMOTE_ADDR'];

				// Get All
		$IPs = $this->getAllIps(' AND fegroups NOT LIKE ""');
		if(is_array($IPs)) {
			foreach($IPs as $IP) {
					// Checks If Any IP Matches
				if(t3lib_div::cmpIP($UserIp, $IP['ip'])) {

				$GroupIds = $this->checkGroupIds($IP['fegroups']);
					// More Than One Id
				if($GroupIds) {
					// Get Back Formated Ids. Note: GroupIds always is an array or false (see checkGroupIds).
					foreach($GroupIds as $GroupId) {
							// Only Add Existing Groupdata
						$GroupData = $this->getAuthorizedGroup($GroupId);
						if($GroupData) $Groups[$GroupId] = $GroupData;
						}
					}
				}
			}
		}
		return $Groups;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sfpipauth/sv1/class.tx_sfpipauth_sv1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sfpipauth/sv1/class.tx_sfpipauth_sv1.php']);
}

?>
