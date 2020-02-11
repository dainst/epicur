<?php

/**
 * @file OAIMetadataFormat_EPICUR.inc.php
 *
 * Author: Božana Bokan, Center for Digital Systems (CeDiS), Freie Universität Berlin
 * Last update: September 25, 2015
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.oaiMetadataFormats.epicur
 * @class OAIMetadataFormat_EPICUR
 *
 * @brief OAI metadata format class -- epicur.
 */

class OAIMetadataFormat_EPICUR extends OAIMetadataFormat {
	/**
	 * @see OAIMetadataFormat#toXml
	 */
	function toXml(&$record, $format = null) {
		$article = $record->getData('article');
		$issue = $record->getData('issue');
		$journal = $record->getData('journal');
		$section = $record->getData('section');
		$galleys = $record->getData('galleys');

		$identifiers = array();
		$pubIdPlugins = PluginRegistry::loadCategory('pubIds', true, $journal->getId());
		$urnPlugin = $pubIdPlugins['urnpubidplugin'];
		if ($urnPlugin) {
			$urnScheme = $urnPlugin->getSetting($journal->getId(), 'namespace');

			$galleysIdentifiers = array();
			// filter PDF and EPUB full text galleys -- DNB concerns only PDF and EPUB formats
			$filteredGalleys = array_filter($galleys, array($this, 'filterGalleys'));
			$galleys = $filteredGalleys;
			foreach ($galleys as $galley) {
				$galleyURN = $galley->getStoredPubId('other::urn');
				if ($galleyURN) {
					$galleyViewURL = Request::url($journal->getPath(), 'article', 'view', array($article->getBestArticleId($journal), $galley->getBestGalleyId($journal)));
					$galleyDownloadURL = Request::url($journal->getPath(), 'article', 'download', array($article->getBestArticleId($journal), $galley->getBestGalleyId($journal)));
					$identifiers[] = array(
						'urn' => $galleyURN,
						'viewURL' => $galleyViewURL,
						'downloadURL' => $galleyDownloadURL
					);
				}
			}
		}
		$response = "<epicur\n" .
			"\txmlns=\"urn:nbn:de:1111-2004033116\"\n" .
			"\txmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n" .
		 	"\txsi:schemaLocation=\"urn:nbn:de:1111-2004033116\n" .
			//"\thttp://nbn-resolving.de/urn/resolver.pl?urn=urn:nbn:de:1111-2004033116\">\n" .
			"\thttp://www.persistent-identifier.de/xepicur/version1.0/xepicur.xsd\">\n" .
			"\t\t<administrative_data>\n" .
			"\t\t\t<delivery>\n" .
			"\t\t\t\t<update_status type=\"urn_new\"></update_status>\n" .
			"\t\t\t</delivery>\n" .
			"\t\t</administrative_data>\n" .
			(!empty($identifiers) ? $this->formatIdentifier($urnScheme, $identifiers) : "") .
			"</epicur>\n";
		return $response;
	}

	/**
	 * Format XML for single identifier and resource element.
	 * @param $urnScheme string
	 * @param $values array
	 */
	function formatIdentifier($urnScheme, $values) {
		$response = '';
		$tab = "\t\t";

		foreach ($values as $value) {
 			$response .= $tab. "\t<record>\n<identifier scheme=\"" .$urnScheme ."\">" .$value['urn'] ."</identifier>\n" .
				$tab ."\t<resource>\n" .
				$tab ."\t\t<identifier scheme=\"url\" type=\"frontpage\" role=\"primary\">" .$value['viewURL'] ."</identifier>\n" .
				$tab ."\t\t<format scheme=\"imt\">text/html</format>\n" .
				$tab ."\t</resource>\n" .

				$tab ."\t<resource>\n" .
				$tab ."\t\t<identifier scheme=\"url\">" .$value['downloadURL'] ."</identifier>\n" .
				$tab ."\t\t<format scheme=\"imt\">application/pdf</format>\n" .
				$tab ."\t</resource>\n</record>\n";
		}

		return $response;
	}

	/**
	 * Check if a galley is a full text as well as PDF or an EPUB file.
	 * @param $galley ArticleGalley
	 * @return boolean
	 */
	function filterGalleys($galley) {
		// check if it is a full text
		$genreDao = DAORegistry::getDAO('GenreDAO');
		$galleyFile = $galley->getFile();
		if ($galleyFile) {
			$genre = $genreDao->getById($galleyFile->getGenreId());
			// if it is not a full text, continue
			if ($genre->getCategory() != 1 || $genre->getSupplementary() || $genre->getDependent()) {
				return false;
			}
			return $galley->isPdfGalley() ||  $galley->getFileType() == 'application/epub+zip';
		}
		return false;
	}
}

?>
