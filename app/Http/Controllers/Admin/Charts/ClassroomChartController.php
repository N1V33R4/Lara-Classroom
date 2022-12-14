<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Department;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class ClassroomChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClassroomChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $labels = Department::all()->sortBy('name')->pluck('name');
        $this->chart->labels($labels);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/classroom'));

        // OPTIONAL
        // $this->chart->minimalist(false);
        // $this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $all_departments = Department::all()->sortBy('name')->values();
        
        $colors = [];
        $hue = 0;
        foreach ($all_departments as $_) {
            $colors[] = "hsl($hue, 75%, 50%)";
            $hue += 40;
        }
        
        $data = $all_departments->map(function ($d) use ($hue, $colors) {
            return $d->classrooms()->where(function ($query) {
                                        $query->where('status', 'Current')
                                            ->orWhere('status', 'Finished');
                                    })
                                    ->count();
        });

        $this->chart->dataset('Classrooms Count', 'pie', $data)
            ->color('#333')
            ->backgroundColor($colors);
    }
}