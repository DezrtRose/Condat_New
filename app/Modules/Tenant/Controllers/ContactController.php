<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Company\CompanyContact;
use App\Modules\Tenant\Models\Institute\Institute;
use Flash;
use DB;

use Illuminate\Http\Request;

class ContactController extends BaseController
{

    protected $request;

    function __construct(Request $request, Institute $institute)
    {
        $this->request = $request;
        $this->institute = $institute;
        parent::__construct();
    }

    /**
     * Get all the contacts through ajax request.
     *
     * @return JSON response
     */
    function getData($tenant_id, $institute_id)
    {
        $institutes = Institute::join('company_contacts', 'institutes.company_id', '=', 'company_contacts.company_id')
            ->leftJoin('persons', 'persons.person_id', '=', 'company_contacts.person_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->select(['company_contacts.company_contact_id', 'company_contacts.position', 'phones.number', 'emails.email', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS name')])
            ->where('institutes.institution_id', $institute_id);

        $datatable = \Datatables::of($institutes)
            ->addColumn('action', function ($data) use($tenant_id) {
                return '<div class="btn-group">
                  <button type="button" class="btn btn-primary">Action</button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                  <li><a data-toggle="modal" data-target="#condat-modal" data-url="' . route('tenant.contact.edit', [$tenant_id, $data->company_contact_id]) . '">Edit</a></li>
                    <li><a href="'.route( 'tenant.contact.destroy', [$tenant_id, $data->company_contact_id]) .'" onclick="return confirm(\'Are You Sure? \')">Delete</a></li>
                  </ul>
                </div>';
            });
        return $datatable->make(true);
    }

    /*
     * Edit contact
     */
    function edit($tenant_id, $contact_id)
    {
        // check if from institute...
        if($this->request->ajax())
        {
            $data['contact'] = $this->institute->getContactDetails($contact_id);
            return view("Tenant::Contact/edit", $data);
        }
    }

    function update($tenant_id, $contact_id)
    {
        if($this->request->ajax()) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'position' => 'required',
                'number' => 'required',
                'email' => 'required|email',
            ];
            $validator = \Validator::make($this->request->all(), $rules);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
            // if validates
            $contact_id = $this->institute->editContact($contact_id, $this->request->all());
            if ($contact_id)
                Flash::success('Contact Updated Successfully!');
            return $this->success(['message' => 'Contact Updated Successfully!']);
        }
    }

    function destroy($tenant_id, $contact_id)
    {
        $this->institute->deleteContact($contact_id);
        \Flash::success('Address Deleted Successfully!');
        return redirect()->back();
    }
}
