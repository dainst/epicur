<?php

/**
 * @file plugins/oaiMetadataFormats/epicur/index.php
 *
 * Author: Božana Bokan, Center for Digital Systems (CeDiS), Freie Universität Berlin
 * Last update: September 25, 2015
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.oaiMetadataFormats.epicur
 *
 * @brief Wrapper for the OAI EPICUR format plugin.
 *
 */

require_once('OAIMetadataFormatPlugin_EPICUR.inc.php');
require_once('OAIMetadataFormat_EPICUR.inc.php');

return new OAIMetadataFormatPlugin_EPICUR();

?>
