<?php

namespace Drupal\employee\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Database\Connection;

/**
 * Controller routines for employee routes.
 */
class EmployeeController extends ControllerBase
{


  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a new EmployeeController object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(Connection $database)
  {
    $this->database = $database;
  }



  /**
   * Returns the employee list page.
   *
   * @return array
   *   A render array representing the employee list page content.
   */
  public function employeeList()
  {

    $employees = $this->database->select('employee', 'e')
      ->fields('e')
      ->execute()
      ->fetchAllAssoc('id');

    // dd($employees);

    $build = [
      '#theme' => 'employee_list',
      '#employees' => $employees,
    ];

    return $build;
  }

  /**
   * Returns the employee detail page.
   *
   * @param int $id
   *   The employee ID.
   *
   * @return array
   *   A render array representing the employee detail page content.
   */
  public function employeeDetail($id)
  {
    // Your logic to fetch employee data for the given ID goes here.
    $employee = $this->database->select('employee', 'e')
      ->fields('e')
      ->condition('e.id', $id)
      ->execute()
      ->fetchAssoc();


    $build = [
      '#theme' => 'employee_detail', // Name of the Twig template to render.
      '#employee' => $employee, // Pass data to the Twig template.
      '#id' => $id,
      '#title' => $employee['name'],
    ];


    // Set the page title dynamically.

    return $build;
  }

  /**
   * Returns the title for the employee detail page.
   *
   * @param int $id
   *   The employee ID.
   *
   * @return string
   *   The title for the employee detail page.
   */
  public function employeeDetailTitle($id)
  {
    // Your logic to fetch the employee name or title based on ID goes here.
    // For example:
    // $employee = // Fetch employee data based on $id.
    // $title = $employee->getName(); // Assuming getName() returns the employee name.
    $title = 'Employee Detail - ' . $id; // Placeholder title.
    return $title;
  }
}
