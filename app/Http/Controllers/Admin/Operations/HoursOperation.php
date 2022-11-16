<?php

namespace App\Http\Controllers\Admin\Operations;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

trait HoursOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupHoursRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/hours', [
            'as'        => $routeName.'.hours',
            'uses'      => $controller.'@hours',
            'operation' => 'hours',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupHoursDefaults()
    {
        $this->crud->allowAccess('hours');

        $this->crud->operation('hours', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('line', 'hours', 'view', 'buttons.hours', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function hours($id)
    {
        $this->crud->hasAccessOrFail('hours');

        // prepare the fields you need to show
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'hours '.$this->crud->entity_name;
        $this->data['years'] = $this->data['entry']->classrooms->sortByDesc('start_date')->groupBy(function($val) {
            return Carbon::parse($val->start_date)->format('Y');
         });
        // dd($this->data['entry']->classrooms->sortByDesc('start_date')->groupBy(function($val) {
        //     return Carbon::parse($val->start_date)->format('Y');
        // }));

        // load the view
        return view("operations.hours", $this->data);
    }
}
