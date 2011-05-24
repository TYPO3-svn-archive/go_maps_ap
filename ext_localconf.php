<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_gomapsap_adress=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_gomapsap_pi1.php', '_pi1', 'list_type', 1);
$_EXTCONF = unserialize($_EXTCONF);
if (!defined($TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['mapKey'])) 
      $TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['mapKey'] = $_EXTCONF['mapKey'];
?>