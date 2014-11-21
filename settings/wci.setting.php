<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM Widget Creation Interface (WCI) Version 1.0                |
 +--------------------------------------------------------------------+
 | Copyright Zyxware Technologies (c) 2014                            |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM WCI.                                |
 |                                                                    |
 | CiviCRM WCI is free software; you can copy, modify, and distribute |
 | it under the terms of the GNU Affero General Public License        |
 | Version 3, 19 November 2007.                                       |
 |                                                                    |
 | CiviCRM WCI is distributed in the hope that it will be useful,     |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of     |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License along with this program; if not, contact Zyxware           |
 | Technologies at info[AT]zyxware[DOT]com.                           |
 +--------------------------------------------------------------------+
*/
return array(
  'default_wci_profile' => array(
    'group_name' => 'Wci Preference',
    'group' => 'wci',
    'name' => 'default_wci_profile',
    'type' => 'Integer',
    'default' => 0,
    'description' => 'Default profile id',
    'help_text' => 'Sets default profile id',
  ),
  'widget_cache_timeout' => array(
    'group_name' => 'Wci Preference',
    'group' => 'wci',
    'name' => 'widget_cache_timeout',
    'type' => 'Integer',
    'default' => 0,
    'description' => 'Widget timeout',
    'help_text' => 'widget timeout',
  ),
 );
