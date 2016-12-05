<?php

namespace App\Modules\Tenant\Controllers;

use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Application\ApplicationStatusDocument;
use App\Modules\Tenant\Models\Application\Status;
use App\Modules\Tenant\Models\Client\ApplicationNotes;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Institute\InstituteDocument;
use App\Modules\Tenant\Models\Intake\Intake;
use App\Modules\Tenant\Models\User;
use Illuminate\Http\Request;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Application\ApplicationStatus;
use App\Modules\Tenant\Models\Notes;
use Session;
use Flash;

class ApplicationStatusController extends BaseController
{
    function __construct(CourseApplication $application, Request $request, ApplicationNotes $note, ApplicationStatus $application_status, ApplicationStatusDocument $document, Intake $intake, Client $client, Institute $institute, User $user, Agent $agent, InstituteDocument $instituteDocument)
    {
        $this->application = $application;
        $this->application_status = $application_status;
        $this->note = $note;
        $this->document = $document;
        $this->request = $request;
        $this->intake = $intake;
        $this->client = $client;
        $this->institute = $institute;
        $this->user = $user;
        $this->agent = $agent;
        $this->instituteDocument = $instituteDocument;
        parent::__construct();
    }

    //Information for Enquiry page
    public function index()
    {
        $applications = $this->application_status->getApplications(1);
        return view('Tenant::ApplicationStatus/enquiry', ['applications' => $applications]);
    }

    public function apply_offer($tenant_id, $course_application_id)
    {
        $data['application'] = $this->application->getDetails($course_application_id);
        $data['documents'] = $this->instituteDocument->getInstituteDocuments($data['application']->institute_id);
        $data['client_name'] = $this->application->getClientName($course_application_id);
        $data['intakes'] = $this->intake->getIntakes($data['application']->institute_id);

        return view('Tenant::ApplicationStatus/action/apply_offer', $data);

    }

    //updates for apply_offer
    public function update($tenant_id, $course_application_id)
    {
        $this->application_status->apply_offer($tenant_id, $this->request->all(), $course_application_id);
        Flash::success('Offer Applied Successfully.');
        return redirect()->route('tenant.application.show', [$tenant_id, $course_application_id]);
        //return redirect()->route('applications.offer_letter_processing.index', $tenant_id);
    }


    //Information for cancel/quarantine action page whose parent page is Enquiry
    public function cancel_application($tenant_id, $course_application_id)
    {
        $applications = CourseApplication::leftjoin('users', 'users.user_id', '=', 'course_application.user_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'users.person_id')
            ->leftjoin('institute_courses', 'institute_courses.institute_course_id', '=', 'course_application.institution_course_id')
            ->leftjoin('courses', 'courses.course_id', '=', 'institute_courses.course_id')
            ->leftjoin('institutes', 'institutes.institution_id', '=', 'institute_courses.institute_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'institutes.company_id')
            ->leftjoin('intakes', 'intakes.intake_id', '=', 'course_application.intake_id')
            ->leftjoin('application_notes', 'course_application.course_application_id', '=', 'application_notes.application_id')
            ->leftjoin('notes', 'application_notes.note_id', '=', 'notes.notes_id')
            ->where('course_application.course_application_id', $course_application_id)
            ->select(['persons.first_name', 'companies.name as company', 'courses.name', 'intakes.intake_date', 'course_application.tuition_fee', 'course_application.course_application_id'])
            ->orderBy('course_application.course_application_id', 'desc')
            ->find($course_application_id);

        return view('Tenant::ApplicationStatus/action/cancel_application', ['applications' => $applications]);
    }

    //cancel/quarantine actions
    public function cancel($tenant_id, $application_id)
    {
        $created = $this->application_status->cancel($tenant_id, $this->request->all(), $application_id);
        if ($created)
            Session::flash('success', 'Application Cancelled Successfully');
        return redirect()->route('applications.cancelled.index', $tenant_id);
    }

    //Information for offer letter processing page
    public function offerLetterProcessing($tenant_id)
    {
        $applications = $this->application_status->getApplications(2);
        return view('Tenant::ApplicationStatus/offer_letter_processing', compact('applications'));
    }

    //Information for offer_received action page whose parent page is Offer Letter Processing
    public function offer_letter_received($tenant_id, $course_application_id)
    {
        $data['application'] = $this->application->getDetails($course_application_id);
        $data['client_name'] = $this->application->getClientName($course_application_id);
        $data['intakes'] = $this->intake->getIntakes($data['application']->institute_id);

        return view('Tenant::ApplicationStatus/action/offer_letter_received', $data);
    }


    //updates for offer_received
    public function offer_received_update($tenant_id, $course_application_id)
    {
        $upload_rules = ['document' => 'required|mimes:jpg,jpeg,bmp,png,doc,docx,pdf,txt,xls,xlsx',
            'description' => 'required',
            'tuition_fee' => 'required',
        ]; //$file = $this->request->file('document'); dd($file);
        $this->validate($this->request, $upload_rules);
        $this->application_status->offer_received($this->request->all(), $course_application_id);
        Flash::success('Offer letter received.');
        return redirect()->route('applications.offer_letter_issued.index', $tenant_id);
    }

    //information for offer letter issued
    public function offerLetterIssued()
    {
        $applications = $this->application_status->getApplications(3);
        return view('Tenant::ApplicationStatus/offer_letter_issued', compact('applications'));
    }

    public function apply_coe($tenant_id, $course_application_id)
    {
        $data['application'] = $this->application->getDetails($course_application_id);
        $data['offer_letter'] = $this->document->getDocument($course_application_id, 2);
        return view('Tenant::ApplicationStatus/action/apply_coe', $data);
    }

    //updates for applied_offer
    public function update_applied_coe($tenant_id, $course_application_id)
    {
        $this->application_status->coe_update($this->request->all(), $course_application_id);
        Flash::success('Status Updated Successfully.');
        return redirect()->route('applications.coe_processing.index');
    }

    //Information for coe processing page
    public function coeProcessing()
    {
        $applications = $this->application_status->getApplications(4);
        return view('Tenant::ApplicationStatus/coe_processing', compact('applications'));
    }

    //Information for action of coe processing page
    public function action_coe_issued($tenant_id, $course_application_id)
    {
        $data['application'] = $this->application->getDetails($course_application_id);
        $data['intakes'] = $this->intake->getIntakes($data['application']->institute_id);
        return view('Tenant::ApplicationStatus/action/coe_issued', $data);
    }

    //updates for action_coe_issued
    public function update_coe_issued($tenant_id, $course_application_id)
    {
        $updated = $this->application_status->coe_issued_update($this->request->all(), $course_application_id);
        if ($updated)
            $updated = $this->document->document_create($this->request->all());

        if ($updated)
            $updated = $this->application_status->coe_issued_create($this->request->all(), $course_application_id);

        Session::flash('success', 'Updated Successfully');
        return redirect()->route('applications.coe_issued.index', $tenant_id);
    }


    //Information for coe issued page
    public function coeIssued()
    {
        $applications = $this->application_status->getApplications(5);
        return view('Tenant::ApplicationStatus/coe_issued', compact('applications'));
    }

    public function statusRecord($status_id)
    {
        $statusRecord = $this->application_status->statusRecord($status_id);
        return $statusRecord;
    }

    public function advancedSearch()
    {
        $data['status'] = Status::lists('name', 'status_id')->toArray();
        array_unshift($data['status'], 'All');

        $data['colleges'] = $this->institute->getList()->toArray();

        $data['users'] = $this->user->getList()->toArray();
        array_unshift($data['users'], 'All');

        $data['agents'] = $this->agent->getAgents();;
        unset($data['agents'][0]);

        $data['search_attributes'] = array();

        if ($this->request->isMethod('post')) {
            $data['applications'] = $this->application->getFilterResults($this->request->all());
            $data['search_attributes'] =$this-> request->all();
            Flash::success(count($data['applications']).' record(s) found.');
        }
        return view('Tenant::ApplicationStatus/search', $data);
    }

    public function cancelled($tenant_id)
    {
        $applications = $this->application_status->getApplications(8);
        return view('Tenant::ApplicationStatus/cancel', compact('applications'));
    }


} //controller ends here