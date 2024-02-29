add these two lines in settings.php
$settings['file_public_path'] = 'sites/default/files';
$settings['file_employee_path'] = 'public/assets/employees/';

The following installation for the employee module
____________________________________________________

1. generate module (.\vendor\bin\drush generate module)
2. Craete employee.info.yml (will be created automatically)
3. enable the module (.\vendor\bin\drush en employee)
4. Create form (.\vendor\bin\drush generate form)
5. Update EmployeeForm.php accordingly
5.1 In EmployeeForm.php update the validateForm Func
5.2 Update the submitForm func
6. For db update, generate the install file with drush command (.\vendor\bin\drush generate install-file)
7. re-install employee
8. connect the db from EmployeeForm.php and make necessary db update: $conn = Database::getConnection();
9. to customize the form style add the following line public function buildForm in EmployeeForm.php
    $form['#theme'] = 'employee_data_form';
9.1. Create employee.module:
/**
 * Implements hook_theme().
 */ 
<?php
{
  return [
    'employee_data_form' => [
      'render element' => 'form',
    ]
  ];
}
9.2. create employee_data_form.html.twig in templates folder

