<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Lecturer;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class WorkingHoursChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WorkingHoursChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // $lecturers = Lecturer::whereHas('classrooms', function ($query) {
        //     $query->has('studentGroups', '>', 0); // redundant later
        // }, '>', 0)->get();
        $lecturers = Lecturer::has('classrooms', '>', 0)->get();

        $hours_per_shift_per_semester = 45; // 3 h/day * 15 weeks
        $data = $lecturers->map(function ($l) use ($hours_per_shift_per_semester) {
            $total_hours = $l->classrooms()->whereYear('start_date', date('Y'))
                ->where(function ($query) {
                    $query->where('status', 'Current')
                        ->orWhere('status', 'Finished');
                })
                ->has('studentGroups', '>', 0)
                ->get()
                ->reduce(function ($work_hours, $classroom) use ($hours_per_shift_per_semester) {
                    $work_hours += $hours_per_shift_per_semester * $classroom->studentGroups->count();
                    return $work_hours;
                }, 0);

            return ['name' => $l->name, 'hours_worked' => $total_hours];
        });

        $colors = [];
        $hue = 180;
        foreach ($lecturers as $_) {
            $colors[] = "hsl($hue, 75%, 50%)";
            $hue += 10;
        }

        $data = $data->sortByDesc('hours_worked')->slice(0, 10);
        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels($data->pluck('name'));

        $this->chart->dataset('Work Hours', 'bar', $data->pluck('hours_worked'))
            // ->color('#333')
            ->backgroundColor($colors);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        // $this->chart->load(backpack_url('charts/working-hours'));
    }
}