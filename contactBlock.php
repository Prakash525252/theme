<?php

/**
 * @file
 */
namespace Drupal\creative\Plugin\Block;

use Drupal\node\NodeInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Core\Block\BlockBase;
use \Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\file\Entity\File;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Site\Settings;
use Drupal\Core\Render\Markup;

/**
 * Creates a 'Foobar' Block
 * @Block(
 * id = "contactBlockId",
 * admin_label = @Translation("contact Block"),
 * )
 */
class contactBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */

    
    public function build() {
        
        $form = \Drupal::formBuilder()->getForm('Drupal\creative\Form\contactForm');
        return $form;
  }

}