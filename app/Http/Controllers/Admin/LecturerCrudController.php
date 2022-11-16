<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LecturerRequest;
use App\Models\Department;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LecturerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LecturerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \App\Http\Controllers\Admin\Operations\HoursOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Lecturer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lecturer');
        CRUD::setEntityNameStrings('lecturer', 'lecturers');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('department_id');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column('address');
        // CRUD::column('birthdate')->type('date');
        // CRUD::column('place_of_birth');

        CRUD::filter('department_id')
            ->type('select2')
            ->values(function() {
                return Department::all()->keyBy('id')->pluck('name', 'id')->toArray();
            })
            ->whenActive(function($value) {
                $this->crud->addClause('where', 'department_id', $value);
            })->apply();

        // CRUD::button('getWorkHours')
        //     ->stack('line')
        //     ->type('model_function')
        //     ->content('getWorkHours')
        //     ->makeFirst();
            
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(LecturerRequest::class);

        CRUD::field('name');
        CRUD::field('birthdate');
        CRUD::field('place_of_birth');
        CRUD::field('address');
        CRUD::field('email');
        CRUD::field('phone');
        CRUD::field('department_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
