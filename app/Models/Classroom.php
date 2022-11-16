<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'classrooms';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'department_id',
        'room_id',
        'course_program_id',
        'start_date',
        'end_date',
        'batch',
        'year',
        'semester',
        'status'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Clone the model into a new, non-existing instance.
     *
     * @param  array|null  $except
     * @return static
     */
    public function replicate(array $except = null)
    {
        $clone = parent::replicate($except);
        $clone->name .= ' (copy)';
        return $clone;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    // Many2one 
    public function room() {
        return $this->belongsTo(Room::class);
    }
    public function courseProgram() {
        return $this->belongsTo(CourseProgram::class);
    }
    public function department() {
        return $this->belongsTo(Department::class);
    }

    // One2many
    public function studentGroups() {
        return $this->hasMany(StudentGroup::class);
    }

    // Many2many
    public function lecturers() {
        return $this->belongsToMany(Lecturer::class, 'assigned_lecturers')->withPivot('order');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getLecturersListAttribute() {
        return json_encode($this->lecturers->map(function($lecturer) {
            return ['lecturer_id' => $lecturer->id, 'order' => $lecturer->pivot->order];
        }));
    }

    public function getLecturersCoursesTableAttribute() {
        $courses = $this->courseProgram->courses->sortBy('pivot.order')->pluck('name');
        $lecturers = $this->lecturers->sortBy('pivot.order')->pluck('name');

        $table = [
            ['Mon' => $courses[0], 'Tue' => $courses[1], 'Wed' => $courses[2], 'Thu' => $courses[3], 'Fri' => $courses[4]],
            ['Mon' => $lecturers[0], 'Tue' => $lecturers[1], 'Wed' => $lecturers[2], 'Thu' => $lecturers[3], 'Fri' => $lecturers[4]]
        ];
        return json_encode($table);
    }

    public function getStatusAttribute($value) {
        return ucfirst($value);
    }

    // TABLES
    public function getMorningStudentsTableAttribute() {
        $morning_id = Shift::where('name', 'Morning')->first()->id;
        $studentGroup = $this->studentGroups->where('shift_id', $morning_id)->first();
        if ($studentGroup == null) 
            return;

        return json_encode($studentGroup->students->sortBy('name')->values()->map(function($student, $key) {
            return ['count' => $key + 1, 'name' => $student->name, 'birthdate' => $student->birthdate];
        }));
    }
    public function getAfternoonStudentsTableAttribute() {
        $afternoon_id = Shift::where('name', 'Afternoon')->first()->id;
        $studentGroup = $this->studentGroups->where('shift_id', $afternoon_id)->first();
        if ($studentGroup == null) 
            return;

        return json_encode($studentGroup->students->sortBy('name')->values()->map(function($student, $key) {
            return ['count' => $key + 1, 'name' => $student->name, 'birthdate' => $student->birthdate];
        }));
    }
    public function getEveningStudentsTableAttribute() {
        $evening_id = Shift::where('name', 'Evening')->first()->id;
        $studentGroup = $this->studentGroups->where('shift_id', $evening_id)->first();
        if ($studentGroup == null) 
            return;

        return json_encode($studentGroup->students->sortBy('name')->values()->map(function($student, $key) {
            return ['count' => $key + 1, 'name' => $student->name, 'birthdate' => $student->birthdate];
        }));
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
