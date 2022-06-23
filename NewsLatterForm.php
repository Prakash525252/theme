<?php
/**
* @file
* Contains \Drupal\creative\Form\NewsLatterForm.
*/
namespace Drupal\creative\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;

class NewsLatterForm extends FormBase {
/**
* {@inheritdoc}
*/
public function getFormId() {
return 'newslater_form';
}

/**
* {@inheritdoc}
*/
public function buildForm(array $form, FormStateInterface $form_state) {

$form['form_start'] = [
        '#type' => 'markup',
        '#markup' => ' <h4 class="text-primary mb-4">Newsletter</h4>'
        ];
$form['message'] = [
    '#type' => 'markup',
    '#markup' => '<div class="result_message"></div>'
    ];

$form['employee_name'] = array(
'#type' => 'textfield',
'#attributes' => array('class' => array('form-control','border-0'),'placeholder'=>$this->t('Your Name')),
'#required' => TRUE,
);

$form['employee_mail'] = array(
'#type' => 'textfield',
'#attributes' => array('class' => array('form-control','border-0'),'placeholder'=>$this->t('Your Email')),
'#required' => TRUE,
);

$form['actions'] = array(
    '#type' => 'button',
    '#value' => $this->t('Submit'),
    '#attributes' => array('class' => array('btn', 'btn-lg', 'btn-primary', 'btn-block', 'border-0')),
    '#ajax' => array(
      'callback' => '::submitNewslatterForm',
    ),
);

//$form['#theme'] = 'newslatter_form';
return $form;
}

public function submitNewslatterForm(array $form, FormStateInterface $form_state) {
    
    $response = new AjaxResponse();
    if($form_state->getValue('employee_name')=='')
    {
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-danger" role="alert">'.$this->t('Please enter your name'). '</div>'),
          );
    }
   elseif($form_state->getValue('employee_mail')=='')
    {
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-danger" role="alert">'.$this->t('Please enter your email'). '</div>'),
          );
    }
    elseif(!filter_var($form_state->getValue('employee_mail'),FILTER_VALIDATE_EMAIL))
    {
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-danger" role="alert">'.$this->t('Please enter a valid email'). '</div>'),
          );
    }
    else
    {
        //Success action would go here
        $conn = Database::getConnection();
        $conn->insert('newsletter_form')->fields(
          array(
            'employee_name' => $form_state->getValue('employee_name'),
            'employee_mail' => $form_state->getValue('employee_mail'),
            )
        )->execute();

        
        /* sending email*/
        $to = $form_state->getValue('employee_mail');
$subject = "Subscription Successfull";

$message = "<b>Successfully Subscribed with the following details</b><br>
<b>Name:</b>".$form_state->getValue('employee_name')."
<b>Gmail:</b>".$form_state->getValue('employee_mail')."
";
 
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";
mail($to,$subject,$message,$headers);

        $form_state->unsetValue('employee_name');
        $form_state->unsetValue('employee_mail');
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-success" role="alert">'.$this->t('Successfully subscriber'). '</div>'),
          );

          $response->addCommand(new InvokeCommand('#newslater-form','trigger',['reset']));
         
    }
   
    return $response;

   }

   public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }



   
   /*public function submitForm(array &$form, FormStateInterface $form_state) {
    // Do nothing.
    $conn = Database::getConnection();
    $conn->insert('newsletter_form')->fields(
      array(
        'employee_name' => $form_state->getValue('employee_name'),
        'employee_mail' => $form_state->getValue('employee_mail'),
        )
    )->execute();

    $this->messenger()->addStatus($this->t('You are succesfully registered!'));
  }
  */
}