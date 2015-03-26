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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(t3lib_extMgm::extPath('sfpipauth').'class/class.tx_sfpipauth_main.php');

/**
 * Service "IP-Auth FE-User" for the "sfpipauth" extension.
 *
 * @author	Christoph Buchli | snowflake productions gmbh <support@snowflake.ch>
 * @package	TYPO3
 * @subpackage	tx_sfpipauth
 */
class tx_sfpipauth_sv2 extends tx_sfpipauth_main {
				var $prefixId = 'tx_sfpipauth_sv2';		// Same as class name
				var $scriptRelPath = 'sv2/class.tx_sfpipauth_sv2.php';	// Path to this script relative to the extension dir.
				var $extKey = 'sfpipauth';	// The extension key.
	
	/**
	 * Authenticate a user
	 * Return 200 if the IP is right. This means that no more checks are needed. Otherwise authentication may fail because we may don't have a password.
	 *
	 * @param	array 	Data of user.
	 * @return	boolean
	 */
	function authUser($user)	{
			// if there's no IP-list given then the user is valid
		$Return = 100;

                $UserIp = $this->authInfo['REMOTE_ADDR'];
                        // Get All
                $IPs = $this->getAllIps(" AND CONCAT(',',feusers,',') LIKE '%,".$user['uid'].",%'");
		if(is_array($IPs) && $this->authInfo['loginType']=='FE') {
                        foreach($IPs as $IP) {
                                $match = t3lib_div::cmpIP($UserIp, $IP['ip']);
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
		if (!$Return && $this->writeAttemptLog) {
			$this->writelog(255,3,3,1,
				"Login-attempt from %s (%s), username '%s', remote address do not match IP list!",
				Array($this->authInfo['REMOTE_ADDR'], $this->authInfo['REMOTE_HOST'], $user[$this->db_user['username_column']]));
		}
                return $Return;
	}

	/**
	 * auth groups by ip
	 *	if auto login is enabled user is still valid if IP do not match
	 *	this needed to let the user login by login form
	 *
	 * @param	array 	Data of user.
	 * @param	array 	Group data array.
	 * @return	boolean 	
	 */
	function authGroup($user, $group)	{
		$valid = true;
		$IPlist = '';
		$UserIp = $this->authInfo['REMOTE_ADDR'];
		$IPs = $this->getAllIps(" AND CONCAT(',',fegroups,',') LIKE '%,".$group['uid'].",%'");

		if (is_array($IPs) && $this->mode=='authGroupsFE') {
			foreach ($IPs as $IP) {
				$IPlist .= $IP['ip'].',';
			}
			$IPlist = preg_replace('/\,$/','',$IPlist);
                        $match = t3lib_div::cmpIP($UserIp, $IPlist);
			switch ($IP['loginmode']) {
				case 0:
					$valid = (is_array($user)) ? true : false;
					break;
                        	case 2:
                                	$valid = $match;
                                    	break;
                                case 3:
                                    	$valid = $match;
                                        break;
                                default:
                                       break;
                            }
		}
		return $valid;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sfpipauth/sv2/class.tx_sfpipauth_sv2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sfpipauth/sv2/class.tx_sfpipauth_sv2.php']);
}

?>
