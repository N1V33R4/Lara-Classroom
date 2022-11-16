<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentGroupRequest;
use App\Models\Classroom;
use App\Models\Department;
use App\Models\Shift;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StudentGroupCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentGroupCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation { bulkClone as traitBulkClone; }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\StudentGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student-group');
        CRUD::setEntityNameStrings('student group', 'student groups');
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
        CRUD::column('batch');
        // CRUD::column('year');
        // CRUD::column('semester');
        CRUD::column('department_id');
        CRUD::column('classroom_id');
        CRUD::column('shift_id');
        CRUD::column('active')->type('boolean');
        CRUD::column('students')->type('relationship_count')
            ->suffix(' pupils');

        CRUD::filter('shift_id')
            ->type('select2')
            ->values(function() {
                return Shift::all()->keyBy('id')->pluck('name', 'id')->toArray();
            })
            ->whenActive(function($value) {
                $this->crud->addClause('where', 'shift_id', $value);
            })->apply();
        CRUD::filter('department_id')
            ->type('select2')
            ->values(function() {
                return Department::all()->keyBy('id')->pluck('name', 'id')->toArray();
            })
            ->whenActive(function($value) {
                $this->crud->addClause('where', 'department_id', $value);
            })->apply();
        CRUD::filter('classroom_id')
            ->type('select2')
            ->values(function() {
                return Classroom::all()->keyBy('id')->pluck('name', 'id')->toArray();
            })
            ->whenActive(function($value) {
                $this->crud->addClause('where', 'classroom_id', $value);
            })->apply();
        CRUD::filter('batch')
            ->type('text')
            ->whenActive(function($value) {
                $this->crud->addClause('where', 'batch', $value);
            })->apply();

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
        CRUD::setValidation(StudentGroupRequest::class);

        CRUD::field('name');
        CRUD::field('batch')->type('number')->size(4);
        CRUD::field('year')->type('number')->size(4);
        CRUD::field('semester')->type('number')->size(4);
        CRUD::field('department_id');
        CRUD::field('classroom_id')->type('relationship');
        CRUD::field('shift_id');
        CRUD::field('active');
        CRUD::field('students');
        // CRUD::field('students')->type('select2_multiple')->entity('students');
        // CRUD::field('students')->type('repeatable')
        //     ->fields([
        //         [
        //             'name' => 'student_id',
        //             'type' => 'select2',
        //             'model' => 'App\Models\Student',
        //             'attribute' => 'name',
        //             'wrapper' => ['class' => 'form-group col-md-6']
        //         ]
        //     ]);

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

    protected function setupShowOperation() {
        CRUD::column('name');
        CRUD::column('batch');
        CRUD::column('year');
        CRUD::column('semester');
        CRUD::column('students_table')->type('table')
            ->label('Students')
            ->columns([
                'count' => 'Count',
                'name' => 'Name',
                'birthdate' => 'Birthdate'
            ]);
    }
    
    public function bulkClone()
    {
        // your custom code here
        // 
        // then you can call the old bulk clone if you want
        // return $this->traitBulkClone($id);
        $this->crud->hasAccessOrFail('bulkClone');

        $entries = request()->input('entries', []);
        $clonedEntries = [];

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $clone = $entry->replicate();
                $clone->push();
                $clone->students()->attach($entry->students); 
                $clonedEntries[] = $clone;
            }
        }

        return $clonedEntries;
    }
}
