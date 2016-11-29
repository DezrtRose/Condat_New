<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Application\ApplicationStatus;
use App\Modules\Tenant\Models\Application\ApplicationStatusDocument;
use App\Modules\Tenant\Models\Client\ApplicationNotes;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Course\BroadField;
use App\Modules\Tenant\Models\Course\CourseLevel;
use App\Modules\Tenant\Models\Course\NarrowField;
use App\Modules\Tenant\Models\Document;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Tenant\Models\Timeline\ClientTimeline;
use Flash;
use DB;

use Illuminate\Http\Request;

class ApplicationController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, CourseApplication $application, Institute $institute, Agent $agent, CollegePayment $payment, CollegeInvoice $invoice, StudentInvoice $student_invoice, ApplicationNotes $notes, ClientTimeline $timeline, ApplicationStatus $status, ApplicationStatusDocument $document)
    {
        $this->client = $client;
        $this->request = $request;
        $this->application = $application;
        $this->institute = $institute;
        $this->agent = $agent;
        $this->payment = $payment;
        $this->invoice = $invoice;
        $this->notes = $notes;
        $this->timeline = $timeline;
        $this->student_invoice = $student_invoice;
        $this->status = $status;
        $this->document = $document;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/Application/index", $data);
    }

    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getApplicationsData($tenant_id, $client_id)
    {
        $clients = CourseApplication::leftJoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftJoin('intakes', 'course_application.intake_id', '=', 'intakes.intake_id')
            ->join('application_status', 'application_status.course_application_id', '=', 'course_application.course_application_id')
            ->join('status', 'application_status.status_id', '=', 'status.status_id')
            ->where('course_application.client_id', $client_id)
            ->where('application_status.active', 1)
            ->select(['companies.name', 'courses.name as course_name', 'course_application.end_date', 'intakes.intake_date', 'course_application.student_id', 'course_application.course_application_id as application_id', 'course_application.tuition_fee', 'course_application.user_id as added_by', 'status.name as status']);

        $datatable = \Datatables::of($clients)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<a data-toggle="tooltip" title="View Application" class="btn btn-action-box" href ="'. route('tenant.application.show', [$tenant_id, $data->application_id]) .'"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Application Documents" class="btn btn-action-box" href ="'. route( 'tenant.application.document', [$tenant_id, $data->application_id]) .'"><i class="fa fa-file"></i></a> <a data-toggle="tooltip" title="Edit Application" class="btn btn-action-box" href ="'. route('tenant.application.edit', [$tenant_id, $data->application_id]) .'"><i class="fa fa-edit"></i></a>';
            })
            ->editColumn('application_id', function ($data) {
                return format_id($data->application_id, 'App');
            })
            ->editColumn('added_by', function ($data) {
                return get_tenant_name($data->added_by);
            })
            ->editColumn('intake_date', function ($data) {
                return format_date($data->intake_date);
            })
            ->editColumn('end_date', function ($data) {
                return format_date($data->end_date);
            });
        // Global search function
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($tenant_id, $client_id)
    {
        $data['institutes'] = $this->institute->getList();
        $data['courses'] = ['' => 'Select Course'];
        $data['intakes'] = ['' => 'Select Intake'];
        $data['agents'] = $this->agent->getAgents();
        $data['client'] = $this->client->getDetails($client_id);
        return view('Tenant::Client/Application/add', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($tenant_id, $client_id)
    {
        /* Additional validations for creating user */
        /*$this->rules['email'] = 'required|email|min:5|max:55|unique:users';

        $this->validate($this->request, $this->rules);*/
        // if validates
        $created = $this->application->add($this->request->all(), $client_id);
        if ($created) {
            Flash::success('Application has been created successfully.');

            $app = $this->application->getDetails($created);
            $this->client->addLog($client_id, 6, ['{{NAME}}' => get_tenant_name(), '{{INSTITUTE}}' => $app->company_name, '{{COURSE}}' => $app->course_name, '{{INTAKE_DATE}}' => format_date($app->intake_date), '{{TUITION_FEE}}' => $app->tuition_fee, '{{VIEW_LINK}}' => route('tenant.application.show', [$tenant_id, $created])], $created);
        }
        return redirect()->route('tenant.client.application', [$tenant_id, $client_id]);
    }

    /**
     * Get Institute Add form
     */
    function createInstitute()
    {
        return view("Tenant::Client/Application/institute");
    }

    /**
     * Get Course Add form
     */
    function createCourse()
    {
        $data['course_levels'] = CourseLevel::lists('name', 'level_id');
        $data['broad_fields'] = BroadField::lists('name', 'id');
        $data['narrow_fields'] = NarrowField::where('broad_field_id', 1)->lists('name', 'id');
        return view("Tenant::Client/Application/course", $data);
    }

    /**
     * Get Intake Add form
     */
    function createIntake()
    {
        return view("Tenant::Client/Application/intake");
    }

    /**
     * Get Sub Agent Add form
     */
    function createAgent()
    {
        return view("Tenant::Client/Application/subagent");
    }

    /**
     * Get Sub Agent Add form
     */
    function createSuperAgent()
    {
        return view("Tenant::Client/Application/superagent");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $client_id
     * @return Response
     */
    public function show($tenant_id, $application_id)
    {
        $data['stats']=null;
        $data['agents'] = $this->agent->getAll();
        $data['application'] = $application = $this->application->getDetails($application_id); //dd($data['application']->toArray());
        $data['paid_to_college'] = $this->payment->paymentToCollege($application_id);
        $remaining = $application->tuition_fee - $data['paid_to_college'];
        $data['remaining'] = ($remaining < 0)? 0 : $remaining;

        $data['total_commission_amount'] = $this->invoice->getTotalAmount($application_id);
        $data['commission_claimed'] = $this->payment->commissionClaimed($application_id);
        $remaining_commission = $data['total_commission_amount'] - $data['commission_claimed'];
        $data['remaining_commission'] = ($remaining_commission < 0)? 0 : $remaining_commission;

        $data['status'] = $this->status->getStatusDetails($tenant_id, $application_id);

        $student_stats = $this->student_invoice->getStats($application_id);
        $data['student_outstanding'] = $student_stats['due_amount'];
        $college_stats = $data['college_stats'] = $this->invoice->getStats($application_id);
        $data['college_outstanding'] = $college_stats['due_amount'];
        $data['uninvoiced_amount'] = $this->payment->getUninvoicedAmount($application_id);
        $data['client'] = $this->client->getDetails($application->client_id);
        return view("Tenant::Client/Application/show", $data);
    }

    public function details($tenant_id, $application_id)
    {
        $client_id = CourseApplication::find($application_id)->client_id;
        $app = new \stdClass();
        $app->application_id = $application_id;
        $data['application'] = $app;
        $data['client'] = $this->client->getDetails($client_id);
        $data['timelines'] = $this->timeline->getDetails($application_id, true);
        return view("Tenant::Client/Application/details", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($tenant_id, $application_id)
    {
        $data['institutes'] = $this->institute->getList();
        $data['courses'] = ['' => 'Select Course'];
        $data['intakes'] = ['' => 'Select Intake'];
        $data['agents'] = $this->agent->getAgents();
        $data['application'] = $this->application->getDetails($application_id);
        $data['client'] = $this->client->getDetails($data['application']->client_id);
        return view('Tenant::Client/Application/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $client_id
     * @return Response
     */
    public function update($tenant_id, $application_id)
    {
        $created = $this->application->edit($this->request->all(), $application_id);
        if ($created) {
            Flash::success('Application has been updated successfully.');
        }
        return redirect()->route('tenant.client.application', [$tenant_id, $application_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    // Directly From Application Dashboard
    public function createSubAgent($tenant_id, $application_id, Request $request)
    {
        $application = CourseApplication::find($application_id);
        $application->sub_agent_id = $request->agent_id;
        $application->save();

        Flash::success('Sub Agent has been added successfully.');
        return redirect()->route('tenant.application.show', [$tenant_id, $application_id]);
    }

    public function addSuperAgent($tenant_id, $application_id, Request $request)
    {
        $application = CourseApplication::find($application_id);
        $application->super_agent_id = $request->agent_id;
        $application->save();

        Flash::success('Super Agent has been added successfully.');
        return redirect()->route('tenant.application.show', [$tenant_id, $application_id]);
    }

    function notes($tenant_id, $application_id)
    {
        $client_id = CourseApplication::find($application_id)->client_id;
        $app = new \stdClass();
        $app->application_id = $application_id;
        $data['application'] = $app;
        $data['client'] = $this->client->getDetails($client_id);
        $data['notes'] = $this->notes->getAll($application_id);
        return view("Tenant::Application/notes", $data);
    }

    function saveNote($tenant_id, $application_id)
    {
        $created = $this->notes->add($this->request->all(), $application_id);
        if($created)
            Flash::success('Note has been added successfully.');
        return redirect()->route('tenant.application.notes', [$tenant_id, $application_id]);
    }



    /**
     * Attach document to the client.
     *
     * @param  int $client_id
     * @return Response
     */
    function document($tenant_id, $application_id)
    {
        $client_id = CourseApplication::find($application_id)->client_id;
        $app = new \stdClass();
        $app->application_id = $application_id;
        $data['application'] = $app;
        $data['client'] = $this->client->getDetails($client_id);
        $data['documents'] = $this->document->getApplicationDocuments($application_id);
        return view("Tenant::Client/Application/document", $data);
    }

    function uploadDocument($tenant_id, $application_id)
    {
        $upload_rules = ['document' => 'required|mimes:jpeg,bmp,png,doc,docx,pdf,txt,xls,xlsx',
            'type' => 'required',
        ];
        $this->validate($this->request, $upload_rules);

        $folder = 'document';
        $file = $this->request->input('document');
        $file = ($file == '') ? 'document' : $file;

        if ($file_info = tenant()->folder($folder, true)->upload($file)) {
            $document_id = $this->document->uploadDocument($application_id, $file_info, $this->request->all());
            $document = Document::find($document_id);
            $client_id = CourseApplication::find($application_id)->client_id;
            $this->client->addLog($client_id, 3, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => $document->description, '{{TYPE}}' => $document->type, '{{FILE_NAME}}' => $document->name, '{{VIEW_LINK}}' => $document->shelf_location, '{{DOWNLOAD_LINK}}' => route('tenant.application.document.download', [$tenant_id, $document_id])]);
            \Flash::success('File uploaded successfully!');
            return redirect()->route('tenant.application.document', [$tenant_id, $application_id]);
        }

        \Flash::danger('Uploaded file is not valid!');
        return redirect()->back();
    }

    function downloadDocument($tenant_id, $id)
    {
        $document = Document::find($id);
        if (empty($document))
            abort(404);
        //dd($document->shelf_location);
        return tenant()->folder('document')->download($document->name);
    }

    function deleteDocument($tenant_id, $id)
    {
        $deleted = $this->document->deleteDocument($id);
        if ($deleted)
            tenant()->folder('document')->delete($deleted);
        \Flash::success('Document deleted successfully!');
        return redirect()->back();
    }

}
