<?php

/**
 * @file plugins/oaiMetadataFormats/epicur/index.php
 *
 * Author: Božana Bokan, Center for Digital Systems (CeDiS), Freie Universität Berlin
 * Last update: September 26, 2012
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_oaiMetadata
 * @brief Wrapper for the OAI EPICUR format plugin.
 *
 */

require_once('OAIMetadataFormatPlugin_EPICUR.inc.php');
require_once('OAIMetadataFormat_EPICUR.inc.php');

return new OAIMetadataFormatPlugin_EPICUR();

?>
