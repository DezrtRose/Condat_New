<?php namespace App\Modules\Tenant\Models\Intake;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intake extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'intakes';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'intake_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['orientation_date', 'intake_date', 'term_id', 'description'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /*
     * Add institute info
     * Output intake id
     */
    function add(array $request, $institute_id)
    {
        DB::beginTransaction();

        try {
            $intake = Intake::create([
                'intake_date' => insert_dateformat($request['intake_date']),
                'description' => $request['description']
            ]);

            InstituteIntake::create([
                'intake_id' => $intake->intake_id,
                'institute_id' => $institute_id,
                //'description' => $request['description'],
            ]);

            DB::commit();
            return $intake->intake_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    /*
     * Get intakes for Institute
     * Output Array
     */
    function getIntakes($institute_id)
    {
        $intakes = InstituteIntake::join('intakes', 'intakes.intake_id', '=', 'institute_intakes.intake_id')
            ->where('institute_intakes.institute_id', $institute_id)
            ->select('intakes.intake_id', DB::raw('CONCAT(DATE_FORMAT(intakes.intake_date, "%d/%m/%Y"), " ", intakes.description) AS intake'))
            ->orderBy(DB::raw('CONCAT(DATE_FORMAT(intakes.intake_date, "%d/%m/%Y"), " ", intakes.description)'), 'asc')
            ->lists('intakes.intake', 'intakes.intake_id');
        return $intakes;
    }

    /*
     * Get details of an intake
     */
    function getDetails($intake_id)
    {
        $intake = Intake::select('*')->find($intake_id);
        return $intake;
    }

    /*
     * Add institute info
     * Output intake id
     */
    function edit(array $request, $intake_id)
    {
        DB::beginTransaction();

        try {
            $intake = Intake::find($intake_id);
            $intake->intake_date = insert_dateformat($request['intake_date']);
            $intake->description = $request['description'];
            $intake->save();

            $institute = InstituteIntake::where('intake_id', $intake_id)->first();
            $institute_id = $institute->institute_id;

            DB::commit();
            return $institute_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }
}
