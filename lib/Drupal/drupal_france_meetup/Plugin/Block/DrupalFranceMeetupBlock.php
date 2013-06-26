<?php

/**
 * @file
 * Contains \Drupal\drupal_france_meetup\Plugin\Block\DrupalFranceMeetupBlock.
 */

namespace Drupal\drupal_france_meetup\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;

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
   * Get future Drupal France Meetups
   * @return Array [description]
   */
  protected function getFutureMeetups() {

  }

  /**
   * Implements \Drupal\block\BlockBase::blockBuild().
   */
  protected function blockBuild() {
    return array(
      '#children' => 'This is a block!',
    );
  }

}
