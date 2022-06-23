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
 * id = "interiorFooterId",
 * admin_label = @Translation("Interior footer Block"),
 * )
 */
class InteriorfooterBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */

    
    public function build() {
        

         $config = $this->getConfiguration();


         $html ='<div>
                    <h4 class="text-primary mb-4">'.$config['footer_title'].'</h4>
                    <p><i class="fa fa-map-marker-alt mr-2"></i>'.$config['office_address'].'</p>
                    <p><i class="fa fa-phone-alt mr-2"></i>'.$config['contact_us'].'</p>
                    <p><i class="fa fa-envelope mr-2"></i>'.$config['email_id'].'</p>
                    <div class="d-flex justify-content-start mt-4">
                        <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
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

    $form['footer_title'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Enter the interior footer title'),
      '#default_value' => $config['footer_title'] ?? '',
    ];
     $form['office_address'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Enter the office address'),
      '#default_value' => $config['office_address'] ?? '',
    ];
    $form['contact_us'] = [
      '#type' => 'textfield',
      '#description' => $this->t('contact_us'),
      '#default_value' => $config['contact_us'] ?? '',
    ];
    $form['email_id'] = [
      '#type' => 'textfield',
     '#description' => $this->t('enter the email id'),
     '#default_value' => $config['email_id'] ?? '',
    ];
   return $form;
  }

   public function blockSubmit($form, FormStateInterface $form_state) 
   {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['footer_title'] = $values['footer_title'];
    $this->configuration['office_address'] = $values['office_address'];
    $this->configuration['contact_us'] = $values['contact_us'];
    $this->configuration['email_id'] = $values['email_id'];
    
  }


}