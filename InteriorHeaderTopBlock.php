<?php

/**
 * @file
 */
namespace Drupal\creative\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Tests\views\Kernel\Plugin\StyleTest;
use Drupal\node\NodeInterface;
use \Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\file\Entity\File;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Url;
use Drupal\Core\Site\Settings;
use Drupal\Core\Render\Markup;



/**
 * Creates a 'Foobar' Block
 * @Block(
 * id = "HeaderTopId",
 * admin_label = @Translation("Interior Header Top Block"),
 * )
 */
class InteriorHeaderTopBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        

        $config = $this->getConfiguration();
           
        $html ='<div class="container-fluid bg-dark py-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                                <div class="d-inline-flex align-items-center">
                                    <a class="text-white pr-3" href="'.$config['interior_header_faqs_url'].'">FAQs</a>
                                    <span class="text-white">|</span>
                                    <a class="text-white px-3" href="'.$config['interior_header_help_url'].'">HELP</a>
                                    <span class="text-white">|</span>
                                    <a class="text-white pl-3" href="'.$config['interior_header_support_url'].'">Support</a>
                                </div>
                            </div>
                            <div class="col-md-6 text-center text-lg-right">
                                <div class="d-inline-flex align-items-center">
                                    <a class="text-white px-3" href="">
                                        <i class="fab fa-facebook-f"></i>
                                       
                                    </a>
                                    <a class="text-white px-3" href="">
                                        <i class="fab fa-twitter"></i>
                                     
                                    </a>
                                    <a class="text-white px-3" href="">
                                        <i class="fab fa-linkedin-in"></i>
                                      
                                    </a>
                                    <a class="text-white px-3" href="">
                                        <i class="fab fa-instagram"></i>
                                       
                                    </a>
                                    <a class="text-white pl-3" href="">
                                        <i class="fab fa-youtube"></i>
                                       
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                
              
             return array (
            '#type' => 'markup',
            '#markup' => $html,
        );
    }


    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
    
        $config = $this->getConfiguration();
    
        $form['interior_header_faqs_url'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Enter the FAQs url'),
          '#default_value' => $config['interior_header_faqs_url'] ?? '',
        ];
         $form['interior_header_help_url'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Enter the  help link'),
          '#default_value' => $config['interior_header_help_url'] ?? '',
        ];
        $form['interior_header_support_url'] = [
          '#type' => 'textfield',
          '#description' => $this->t('Enter the Support url'),
          '#default_value' => $config['interior_header_support_url'] ?? '',
        ];
       return $form;
      }
    
       public function blockSubmit($form, FormStateInterface $form_state) 
       {
        parent::blockSubmit($form, $form_state);
        $values = $form_state->getValues();
        $this->configuration['interior_header_faqs_url'] = $values['interior_header_faqs_url'];
        $this->configuration['interior_header_help_url'] = $values['interior_header_help_url'];
        $this->configuration['interior_header_support_url'] = $values['interior_header_support_url'];
        
      }
  }