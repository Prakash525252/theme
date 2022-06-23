<?php

/**
 * @file
 */
namespace Drupal\creative\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;

/**
 * Creates a 'Foobar' Block
 * @Block(
 * id = "HeaderContactId",
 * admin_label = @Translation("Interior Content Block"),
 * )
 */
class InteriorContactBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */

    
    public function build() {
        

         $config = $this->getConfiguration();


         $html ='<div class="container-fluid bg-white py-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 text-left mb-3 mb-lg-0">
                                <div class="d-inline-flex text-left">
                                    <h1 class="flaticon-office font-weight-normal text-primary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h5>Our Office</h5>
                                        <p class="m-0">'.$config['our_office'].'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-left text-lg-center mb-3 mb-lg-0">
                                <div class="d-inline-flex text-left">
                                    <h1 class="flaticon-email font-weight-normal text-primary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h5>Email Us</h5>
                                        <p class="m-0">'.$config['email_id'].'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-left text-lg-right mb-3 mb-lg-0">
                                <div class="d-inline-flex text-left">
                                    <h1 class="flaticon-telephone font-weight-normal text-primary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h5>Call Us</h5>
                                        <p class="m-0">'.$config['contact_us'].'</p>
                                    </div>
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

    $form['our_office'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Enter the office Adrress'),
      '#default_value' => $config['our_office'] ?? '',
    ];
     $form['email_id'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Registered Email that is showing on top'),
      '#default_value' => $config['email_id'] ?? '',
    ];
    $form['contact_us'] = [
      '#type' => 'textfield',
      '#description' => $this->t('contact_us'),
      '#default_value' => $config['contact_us'] ?? '',
    ];
   return $form;
  }

   public function blockSubmit($form, FormStateInterface $form_state) 
   {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['our_office'] = $values['our_office'];
    $this->configuration['email_id'] = $values['email_id'];
    $this->configuration['contact_us'] = $values['contact_us'];
    
  }


}