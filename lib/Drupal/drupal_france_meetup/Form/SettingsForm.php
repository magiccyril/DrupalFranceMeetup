<?php

/**
 * @file
 * Contains \Drupal\drupal_france_meetup\Form\SettingsForm.
 */

namespace Drupal\drupal_france_meetup\Form;

use Drupal\system\SystemConfigFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure drupal france meetup module.
 */
class SettingsForm extends SystemConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'drupal_france_meetup_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    $site_config = $this->configFactory->get('drupal_france_meetup.settings');

    $form['source'] = array(
      '#type' => 'details',
      '#title' => t('Source'),
    );
    $form['source']['rss'] = array(
      '#type' => 'textfield',
      '#title' => t('Drupal France Meetup RSS Feed'),
      '#default_value' => $site_config->get('rss'),
      '#required' => TRUE
    );

    $form['display'] = array(
      '#type' => 'details',
      '#title' => t('Display'),
    );

    $nb_items = $site_config->get('nb_items');
    $default_nb_items = !empty($nb_items) ? $nb_items : 10;

    $form['display']['nb_items'] = array(
      '#type' => 'textfield',
      '#title' => t('Maximum number of meetups to display'),
      '#default_value' => $default_nb_items,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, array &$form_state) {
    // Check for nb items to display > 0.
    if (0 >= $form_state['values']['nb_items']) {
      form_set_error('nb_items', t('The maximum number of items to display must be superior to 0.'));
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    $this->configFactory->get('drupal_france_meetup.settings')
      ->set('rss', $form_state['values']['rss'])
      ->set('nb_items', $form_state['values']['nb_items'])
      ->save();

    parent::submitForm($form, $form_state);
  }
}
