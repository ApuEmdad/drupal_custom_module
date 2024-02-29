<?php

declare(strict_types=1);

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\File\FileSystemInterface;

/**
 * Provides a employee form.
 */
final class EmployeeForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string
  {
    return 'employee_employee';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array
  {

    $form['emp_firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
      '#maxlength' => 30,
    ];

    $form['emp_lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#required' => TRUE,
      '#maxlength' => 30,
    ];

    $form['emp_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Employee Email'),
      '#required' => TRUE,
      '#maxlength' => 100,
    ];

    $form['emp_zipcode'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Employee ZIP code'),
      '#required' => TRUE,
      '#maxlength' => 6,
    ];

    $form['emp_file'] = [
      '#type' => 'file',
      '#title' => $this->t('File'),
      '#description' => $this->t('Upload your File.'),
      '#attributes' => [
        'class' => ['employee-file'],
      ],
      '#required' => TRUE,
    ];


    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    $form['#theme'] = 'employee_data_form';


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void
  {

    $formField = $form_state->getValues();

    $firstName = trim($formField['emp_firstname']);
    $lastName = trim($formField['emp_lastname']);
    $email = trim($formField['emp_email']);
    $zipcode = trim($formField['emp_zipcode']);

    if (!preg_match("/^([a-zA-Z']+)$/", $firstName)) {
      $form_state->setErrorByName('emp_firstname', $this->t('Enter the valid first name'));
    }

    if (!preg_match("/^([a-zA-Z']+)$/", $lastName)) {
      $form_state->setErrorByName('emp_lastname', $this->t('Enter the valid last name'));
    }

    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('emp_email', $this->t('Enter valid email address'));
    }

    if (!preg_match("/^\d{1,6}$/", $zipcode)) {
      $form_state->setErrorByName('emp_zipcode', $this->t('Enter the valid zip code'));
    }


    $file = file_save_upload('emp_file', [
      'file_validate_extensions' => ['png jpg jpeg pdf'],
    ]);
    if (!$file) {
      $form_state->setErrorByName('emp_file', $this->t('Please upload a valid file.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $conn = Database::getConnection();

    $formField = $form_state->getValues();

    $formData['emp_firstname'] = $formField['emp_firstname'];
    $formData['emp_lastname'] = $formField['emp_lastname'];
    $formData['emp_email'] = $formField['emp_email'];
    $formData['emp_zipcode'] = $formField['emp_zipcode'];


    $file = file_save_upload('emp_file', [
      'file_validate_extensions' => ['png jpg jpeg pdf'],
    ]);


    if ($file) {
      $_file = reset($file);
      $_file->setPermanent();
      $_file->save();
      $file_system = \Drupal::service('file_system');
      $file_path = 'public/assets/employees/' . $_file->getFilename();
      // $file_path = 'sites/default/files/' . $_file->getFilename();
      $file_system->move($_file->getFileUri(), $file_path, FileSystemInterface::EXISTS_REPLACE);
      $formData['emp_file'] = $file_path;
    }


    $conn->insert('employee')
      ->fields($formData)->execute();

    $this->messenger()->addStatus($this->t('Employee data saved successfully.'));
    $form_state->setRedirect('employee.employee');
    // dd($formData);
  }
}
