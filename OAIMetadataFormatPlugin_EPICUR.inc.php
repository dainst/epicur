<?php

/**
 * @file OAIMetadataFormatPlugin_EPICUR.inc.php
 *
 * Author: Božana Bokan, Center for Digital Systems (CeDiS), Freie Universität Berlin
 * Last update: September 25, 2015
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.oaiMetadataFormats.epicur
 * @class OAIMetadataFormatPlugin_EPICUR
 *
 * @brief EPICUR metadata format plugin for OAI.
 */


import('lib.pkp.classes.plugins.OAIMetadataFormatPlugin');

class OAIMetadataFormatPlugin_EPICUR extends OAIMetadataFormatPlugin {
	/**
	 * Get the name of this plugin. The name must be unique within
	 * its category.
	 * @return String name of plugin
	 */
	function getName() {
		return 'OAIMetadataFormatPlugin_EPICUR';
	}

	function getDisplayName() {
		return __('plugins.OAIMetadataFormats.epicur.displayName');
	}

	function getDescription() {
		return __('plugins.OAIMetadataFormats.epicur.description');
	}

	function getFormatClass() {
		return 'OAIMetadataFormat_EPICUR';
	}

	static function getMetadataPrefix() {
		return 'epicur';
	}

	static function getSchema() {
		//return 'http://nbn-resolving.de/urn/resolver.pl?urn=urn:nbn:de:1111-2004033116';
		return 'http://www.persistent-identifier.de/xepicur/version1.0/xepicur.xsd';
	}

	static function getNamespace() {
		return 'urn:nbn:de:1111-2004033116';
	}
}

?>
