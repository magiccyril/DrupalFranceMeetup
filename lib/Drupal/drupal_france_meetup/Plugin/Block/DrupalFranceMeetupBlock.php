<?php

/**
 * @file
 * Contains \Drupal\drupal_france_meetup\Plugin\Block\DrupalFranceMeetupBlock.
 */

namespace Drupal\drupal_france_meetup\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;
use Zend\Feed\Reader\Reader;

/**
 * Provides a simple block with future Drupal France meetups.
 *
 * @Plugin(
 *   id = "drupal_france_meetup_block",
 *   admin_label = @Translation("Drupal France Meetup Block"),
 *   module = "drupal_france_meetup"
 * )
 */
class DrupalFranceMeetupBlock extends BlockBase {

  /**
   * Get XML String from URL
   *
   * @return String XML string
   */
  protected function getXmlString($url) {
    $request = \Drupal::httpClient()->get($url);

    try {
      $response = $request->send();
      $xml = $response->getBody()->__toString();
    }
    catch (\Exception $e) {
      drupal_set_message(t('Cannot access RSS feed.'), 'error');

      return '';
    }

    return $xml;
  }

  /**
   * Get future Drupal France Meetups
   *
   * @return Array Array of entries
   */
  protected function getFutureMeetups() {
    $entries = array();

    $site_config = config('drupal_france_meetup.settings');
    $rss = $site_config->get('rss');
    $nb_items = $site_config->get('nb_items');

    if ($rss) {
      $xml_string = $this->getXmlString($rss);
      $channel = Reader::importString($xml_string);

      foreach ($channel as $item) {
        if (count($entries) < $nb_items) {
          array_push($entries, l($item->getTitle(), $item->getId()));
        }
      }
    }

    return $entries;
  }

  /**
   * Implements \Drupal\block\BlockBase::build().
   */
  public function build() {
    return array(
      '#entries' => $this->getFutureMeetups(),
      '#theme'   => 'drupal_france_meetup_block',
    );
  }

}
