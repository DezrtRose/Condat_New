<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Client\ActiveClient;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Client\ClientDocument;
use App\Modules\Tenant\Models\Client\ClientEmail;
use App\Modules\Tenant\Models\Country;
use App\Modules\Tenant\Models\Document;
use App\Modules\Tenant\Models\Notes;
use App\Modules\Tenant\Models\Client\ClientNotes;
use App\Modules\Tenant\Models\Client\ApplicationNotes;
use App\Modules\Tenant\Models\Photo;
use App\Modules\Tenant\Models\Timeline\ClientTimeline;
use Flash;
use Illuminate\Support\Facades\Validator;
use Mail;
use DB;

use Illuminate\Http\Request;

class ClientController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'first_name' => 'required|min:2|max:145',
        'last_name' => 'required|min:2|max:55',
        'middle_name' => 'alpha|min:2|max:145',
        'number' => 'required'
    ];

    function __construct(Client $client, Request $request, ClientDocument $document, notes $notes, ClientNotes $client_notes, ApplicationNotes $application_notes, ClientTimeline $timeline, ClientEmail $email)
    {
        $this->client = $client;
        $this->request = $request;
        $this->notes = $notes;
        $this->document = $document;
        $this->client_notes = $client_notes;
        $this->application_notes = $application_notes;
        $this->timeline = $timeline;
        $this->email = $email;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Tenant::Client/index");
    }

    /**
     * Get all the users through ajax request.
     *
     * @return JSON response
     */
    function getData($tenant_id)
    {
        $clients = Client::leftJoin('persons', 'clients.person_id', '=', 'persons.person_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftJoin('person_addresses', 'person_addresses.person_id', '=', 'persons.person_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'person_addresses.address_id')
            ->join('users', 'clients.added_by', '=', 'users.user_id')
            ->join('persons as user_profile', 'user_profile.person_id', '=', 'users.person_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('active_clients', function($q) {
                $q->on('active_clients.client_id', '=', 'clients.client_id');
                $q->where('active_clients.user_id', '=', current_tenant_id());
            })
            ->select(['clients.client_id', 'clients.added_by', 'clients.added_by', 'emails.email', 'phones.number', 'clients.created_at', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), DB::raw('CONCAT(user_profile.first_name, " ", user_profile.last_name) AS added_by'), 'active_clients.id as active_id', 'addresses.country_id']);

        $datatable = \Datatables::of($clients)
            ->addColumn('action', function ($data) use($tenant_id) {
               return '<a data-toggle="tooltip" title="View Client" class="btn btn-action-box" href ="'.route('tenant.client.show', [$tenant_id, $data->client_id]) .'"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Client Documents" class="btn btn-action-box" href ="'.route('tenant.client.document', [$tenant_id, $data->client_id]) .'"><i class="fa fa-file"></i></a> <a data-toggle="tooltip" title="Edit Client" class="btn btn-action-box" href ="'.route('tenant.client.edit', [$tenant_id, $data->client_id]) .'"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('active', function ($data) {
                return ($data->active_id != null)? '<input type="checkbox" value=1 class="icheck active" id="'.$data->client_id.'" checked = "checked" />' : '<input type="checkbox" value=0 class="icheck active" id="'.$data->client_id.'"/>';
            })
            ->editColumn('created_at', function ($data) {
                return format_datetime($data->created_at);
            })
            ->editColumn('country_id', function ($data) {
                if(!empty($data->country_id))
                    return Country::find($data->country_id)->name;
                else
                    return '';
            })
            ->editColumn('client_id', function ($data) {
                return format_id($data->client_id, 'C');
            })
            /*->editColumn('added_by', function ($data) {
                return get_tenant_name($data->added_by);
            })*/;
        //->editColumn('referred_by', function($data){return get_user_name($data->referred_by); })
        // Global search function
        if ($keyword = $this->request->get('search')['value']) {
            $datatable->filterColumn('fullname', 'whereRaw', "CONCAT(persons.first_name, ' ', persons.last_name) like ?", ["%$keyword%"]);
            $datatable->filterColumn('added_by', 'whereRaw', "CONCAT(user_profile.first_name, ' ', user_profile.last_name) like ?", ["%$keyword%"]);
        }
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Tenant::Client/add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($tenant_id)
    {
        /* Additional validations for creating user */
        $this->rules['email'] = 'email|min:5|max:55|unique:emails';
        $messages = [
            'email.unique' => 'Client with the same email address already exists.',
        ];

        $this->validate($this->request, $this->rules, $messages);

        // if validates
        $created = $this->client->add($this->request->all());

        if ($created) {
            Flash::success('Client has been created successfully.');
            $this->client->addLog($created, 1);
        }

        return redirect()->route('tenant.client.index', $tenant_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $client_id
     * @return Response
     */
    public function show($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        $data['remainders'] = $this->client_notes->getAll($client_id, true);
        $data['timelines'] = $this->timeline->getDetails($client_id);

        $data['timeline_list'] = $this->timeline->getTimeline($client_id);
        return view("Tenant::Client/show", $data);
    }

    public function personal_details($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/personal_details", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($tenant_id, $client_id)
    {
        /* Getting the client details*/
        $data['client'] = $this->client->getDetails($client_id);
        if ($data['client'] != null) {
            if(!session()->has('from')){
                session()->put('from', url()->previous());
            }
            $data['client']->dob = format_date($data['client']->dob);
            return view('Tenant::Client/edit', $data);
        } else
            return show_404();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $client_id
     * @return Response
     */
    public function update($tenant_id, $client_id)
    {
        $email_id = $this->request->get('email_id');
        /* Additional validation rules checking for uniqueness */
        $this->rules['email'] = 'email|min:5|max:55|unique:emails,email,'.$email_id.',email_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $updated = $this->client->edit($this->request->all(), $client_id);
        if ($updated)
            Flash::success('Client has been updated successfully.');
        return redirect(session()->pull('from'));
        //return redirect()->route('tenant.client.index');
        //return redirect()->back();
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

    /**
     * Attach document to the client.
     *
     * @param  int $client_id
     * @return Response
     */
    function document($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        $data['documents'] = $this->document->getClientDocuments($client_id);
        return view("Tenant::Client/document", $data);
    }

    function uploadDocument($tenant_id, $client_id)
    {
        $upload_rules = ['document' => 'required|mimes:jpeg,bmp,png,doc,docx,pdf,txt,xls,xlsx',
            'type' => 'required',
        ];
        $this->validate($this->request, $upload_rules);

        $folder = 'document';
        $file = $this->request->input('document');
        $file = ($file == '') ? 'document' : $file;

        if ($file_info = tenant()->folder($folder, true)->upload($file)) {
            $document_id = $this->document->uploadDocument($client_id, $file_info, $this->request->all());
            $document = Document::find($document_id);
            $this->client->addLog($client_id, 3, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => $document->description, '{{TYPE}}' => $document->type, '{{FILE_NAME}}' => $document->name, '{{VIEW_LINK}}' => $document->shelf_location, '{{DOWNLOAD_LINK}}' => route('tenant.client.document.download', [$tenant_id, $document_id])]);
            \Flash::success('File uploaded successfully!');
            return redirect()->route('tenant.client.document', [$tenant_id, $client_id]);
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

    function notes($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        $data['notes'] = $this->client_notes->getAll($client_id);
        return view("Tenant::Client/notes", $data);
    }

    function payment_dashboard($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/payments", $data);
    }

    function uploadClientNotes($tenant_id, $client_id)
    {
        $upload_rules = ['description' => 'required'];

        $request = $this->request->all();
        if (isset($request['remind']) && $request['remind'] == 1)
            $upload_rules['reminder_date'] = 'required';

        $this->validate($this->request, $upload_rules);

        $note_id = $this->client_notes->add($client_id, $request);
        if($note_id) {
            \Flash::success('Notes uploaded successfully!');
            $this->client->addLog($client_id, 2, ['{{DESCRIPTION}}' => $this->getNoteFormat($note_id), '{{NAME}}' => get_tenant_name()]);
        }
        if($this->request->get('timeline') == 1)
            return redirect()->route('tenant.client.show', [$tenant_id, $client_id]);
        else
            return redirect()->route('tenant.client.notes', [$tenant_id, $client_id]);
    }


    function getNoteFormat($note_id)
    {
        $note = Notes::find($note_id);
        $format = $note->description. "<br/>";
        if($note->remind == 1)
            $format .= "<strong>Reminder Date : </strong>". format_date($note->reminder_date);
        return $format;
    }

    function deleteNote($tenant_id, $note_id)
    {
        $client_id = $this->client_notes->deleteNote($note_id);

        \Flash::success('Note deleted successfully!');
        return redirect()->route('tenant.client.notes', [$tenant_id, $client_id]);
    }

    /* Krita */
    function setActive($tenant_id, $client_id)
    {
        ActiveClient::create([
            'client_id' => $client_id,
            'user_id' => current_tenant_id(),
            'created_at' => get_today_datetime()
        ]);
    }

    function removeActive($tenant_id, $client_id)
    {
        $active = ActiveClient::where('client_id', $client_id)->where('user_id', current_tenant_id())->first();
        if(!empty($active)) $active->delete();
    }

    function compose($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/Email/compose", $data);
    }

    function sent($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        $data['emails'] = $this->email->getEmails($client_id);
        return view("Tenant::Client/Email/sent", $data);
    }

    function readMail($tenant_id, $client_id, $mail_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        $data['mail'] = ClientEmail::find($mail_id);
        return view("Tenant::Client/Email/read", $data);
    }

    function sendMail($tenant_id, $client_id)
    {
        $upload_rules = ['subject' => 'required|max:255', 'body' => 'required'];
        $client = $this->client->getDetails($client_id);

        $this->validate($this->request, $upload_rules);

        $request = $this->request->all();
        $request['email'] = $client->email;

        if($request['email'] != '') {
            $param = ['content' => $request['body'],
                'subject' => $request['subject'],
                'heading' => 'Condat Solutions',
                'subheading' => 'All your business in one space',
            ];

            $data = ['to_email' => $client->email,
                'to_name' => $client->first_name . ' ' . $client->last_name,
                'subject' => $request['subject'],
                'from_email' => env('MAIL_USERNAME'),
                'from_name' => 'Condat Solutions', //change this later
            ];

            $sent = Mail::send('template.master', $param, function ($message) use ($data) {
                $message->to($data['to_email'], $data['to_name'])
                    ->subject($data['subject'])
                    ->from($data['from_email'], $data['from_name']);
            });

            if ($sent) {
                $this->email->storeMail($client_id, $request);
                \Flash::success('Email sent successfully!');
                $this->client->addLog($client_id, 8, ['{{CLIENT_NAME}}' => $client->first_name . ' ' . $client->last_name, '{{CLIENT_EMAIL}}' => $client->email, '{{SUBJECT}}' => $request['subject'], '{{BODY}}' => limit_char($request['body'], 100), '{{NAME}}' => get_tenant_name()]);
            }
        } else {
            \Flash::error('Email not set!');
        }

        return redirect()->back();
    }

    function urlUpload($tenant_id, $client_id)
    {
        $url = $this->request->get('url');
        $title = $this->request->get('title');

        $rules['url'] = 'required|url';
        $rules['title'] = 'required';

        $this->validate($this->request, $rules);

        if(is_array(getimagesize($url))) {
            //$extension =
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            //remove get request
            $extension = strtok($extension, '?');
            $filename = str_random(4).'-'.str_slug($title).'.'. $extension;
            //get file content from url
            $file = file_get_contents($url);

            $location = tenant()->folder('customer', true)->path();
            //dd($location);
            $file_info = array();
            $file_info['fileName'] = $filename;
            $file_info['pathName'] = $location;
            $file = file_put_contents($location.$filename, $file);
            $photo_id = $this->client->uploadImage($client_id, $file_info, $this->request->all());
            \Flash::success('Photo uploaded successfully!');
        } else {
            \Flash::error('Unable to upload. Please try another image');
        }
        return redirect()->back();
    }

}
