<?php
/**
* @file
* Contains \Drupal\creative\Form\contactForm.
*/
namespace Drupal\creative\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;

class contactForm extends FormBase {
/**
* {@inheritdoc}
*/
public function getFormId() {
return 'contactForm_form';
}

/**
* {@inheritdoc}
*/
public function buildForm(array $form, FormStateInterface $form_state) {

  /*
$form['form_start'] = [
  '#type' => 'markup',
  '#attributes' => array('class' => array('contact-form','col-lg-7', 'mb-5', 'my-lg-5', 'py-5', 'pl-lg-5')),

  ]; */

  
$form['message'] = [
    '#type' => 'markup',
    '#markup' => '<div class="result_message"></div>'
  ];

$form['your_name'] = array(
'#type' => 'textfield',
'#attributes' => array('class' => array('contact-form','control-group','form-control','p-4'),'placeholder'=>$this->t('Your Name')),
'#required' => TRUE,
);

$form['your_mail'] = array(
'#type' => 'email',
'#attributes' => array('class' => array('contact-form','control-group','form-control','p-4'),'placeholder'=>$this->t('Your Email')),
'#required' => TRUE,
);

$form['subject'] = array(
  '#type' => 'textfield',
  '#attributes' => array('class' => array('contact-form','control-group','form-control','p-4'),'placeholder'=>$this->t('subject')),
  '#required' => TRUE,
);


$form['description'] = array(
  '#type' => 'textarea',
  '#attributes' => array('class' => array('contact-form','control-group','form-control','p-4'),'rows'=>$this->t('6'),'placeholder'=>$this->t('enter the message')),
  '#required' => TRUE,
);
  



$form['actions'] = array(
    '#type' => 'button',
    '#value' => $this->t('Send Message'),
    '#attributes' => array('class' => array('btn', 'btn-lg', 'btn-primary', 'py-3', 'px-5')),
    '#ajax' => array(
      'callback' => '::submitContactForm',
    ),
);

 
return $form;
}

public function submitContactForm(array $form, FormStateInterface $form_state) {
    
    $response = new AjaxResponse();
    if($form_state->getValue('your_name')=='')
    {
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-danger" role="alert">'.$this->t('Please enter your name'). '</div>'),
          );
    }
   elseif($form_state->getValue('your_mail')=='')
    {
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-danger" role="alert">'.$this->t('Please enter your email'). '</div>'),
          );
    }
    
    elseif($form_state->getValue('subject')=='')
    {
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-danger" role="alert">'.$this->t('Please enter the subject'). '</div>'),
          );
    }
    elseif($form_state->getValue('description')=='')
    {
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-danger" role="alert">'.$this->t('Please enter the message'). '</div>'),
          );
    }
    elseif(!filter_var($form_state->getValue('your_mail'),FILTER_VALIDATE_EMAIL))
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
        $conn->insert('contact_form')->fields(
          array(
            'name' => $form_state->getValue('your_name'),
            'email' => $form_state->getValue('your_mail'),
            'subject' => $form_state->getValue('subject'),
            'message' => $form_state->getValue('description'),
            )
        )->execute();


        
        /* sending email*/
        $to = $form_state->getValue('email');
$subject = "Subscription Successfull";

$message = "<b>Successfully Subscribed with the following details</b><br>
<b>Name:</b>".$form_state->getValue('name')."
<b>Gmail:</b>".$form_state->getValue('email')."
<b>Subject:</b>".$form_state->getValue('subject')."
<b>message:</b>".$form_state->getValue('description')."
";
 
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";
mail($to,$subject,$message,$headers);

        $form_state->unsetValue('your_name');
        $form_state->unsetValue('your_mail');
        $response->addCommand(
            new HtmlCommand(
              '.result_message',
              '<div class="alert alert-success" role="alert">'.$this->t('Successful'). '</div>'),
          );

          $response->addCommand(new InvokeCommand('#contactForm_form','trigger',['reset']));
         
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