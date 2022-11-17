<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseProgramRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CourseProgramCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CourseProgramCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;

    //for Clone Multiple Items (Bulk Clone)
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    //Delete Multiple Items (Bulk Delete)
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CourseProgram::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/course-program');
        CRUD::setEntityNameStrings('course program', 'course programs');
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
        CRUD::column('remark');

        $this->crud->enableExportButtons();//for Export
        $this->crud->disableResponsiveTable();// for Responsive Table

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
        CRUD::setValidation(CourseProgramRequest::class);

        CRUD::field('name');
        CRUD::field('remark');
        CRUD::field('courses_list')
            ->type('repeatable')
            ->fields([
                [
                    'name' => 'course_id',
                    'type' => 'select2',
                    'model' => 'App\Models\Course',
                    'attribute' => 'name',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ],
                [
                    'name' => 'order',
                    'type' => 'number',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]
            ])
            ->init_rows(5)
            ->min_rows(5)
            ->max_rows(5);

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

    public function store()
    {
        $courses = collect(json_decode(request('courses_list'), true));

        $response = $this->traitStore();

        $this->crud->entry->courses()->sync($courses);

        return $response;
    }

    public function update()
    {
        $courses = collect(json_decode(request('courses_list'), true));

        $response = $this->traitUpdate();

        $this->crud->entry->courses()->detach();
        $this->crud->entry->courses()->attach($courses);

        return $response;
    }

    protected function setupShowOperation() {
        CRUD::column('name');
        CRUD::column('remark');
        CRUD::column('courses_table')->type('table')
            ->label('Courses')
            ->columns([
                'order' => 'Order',
                'name' => 'Name'
            ]);
    }
}
