<?php

namespace App\Http\Controllers;

use App\Models\ConsultationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use App\Models\InvoiceModel;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private function getUserData()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return redirect('/');
        }
    }
    public function index()
    {
        return view('users', [
            'title' => 'პაციენტები',
            'user' => $this->getUserData(),
            'users' => UserModel::where('role', 'user')->simplePaginate(15)
        ]);
    }

    public function create(UserRequest $request)
    {
        $validated = $request->validated();

        $user = new UserModel();
        $user->createUser($validated);

        return redirect('/dashboard/users');
    }

    public function delete(Request $request)
    {
        $delete = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $user = new UserModel();
        $user->remove($delete['user_id']);

        return redirect('/dashboard/users');
    }

    public function search(Request $request)
    {
        $search = $request->validate([
            'user_search' => 'required|string'
        ]);

        return view('users', [
            'title' => 'პაციენტები',
            'user' => $this->getUserData(),
            'users' => UserModel::where('role', 'user')
                ->where( function ($query) use ($search) {
                    $query->orWhere('first_name', 'like', '%'.$search['user_search'].'%')
                        ->orWhere('last_name', 'like', '%'.$search['user_search'].'%')
                        ->orWhere('personal_number', 'like', '%'.$search['user_search'].'%')
                        ->orWhere('phone', 'like', '%'.$search['user_search'].'%')
                        ->orWhere('email', 'like', '%'.$search['user_search'].'%');
                })->simplePaginate(15)
        ]);
    }

    public function updateView(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        return view('users', [
            'title' => 'პაციენტები',
            'user' => $this->getUserData(),
            'users' => UserModel::where('id', $validated['user_id'])->where('role', 'user')->simplePaginate(15),
            'update' => true
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'personal_number' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|in:მამრობითი,მდედრობითი,სხვა',
            'citizenship' => 'string|nullable',
            'insurance' => 'string|nullable',
            'parent_first_name' => 'string|nullable',
            'parent_last_name' => 'string|nullable',
            'parent_personal_number' => 'string|nullable',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'email' => 'email|nullable',
            'referral_source' => 'required|in:პასუხის გარეშე,სოციალური მედია,საძიებო სისტემა,მეგობარი / ოჯახი,რეკლამიდან,ღონისძიებიდან'
        ]);

        $user = new UserModel();
        $user->updateUser($validated);

        return redirect('/dashboard/users');
    }

    public function profileView(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        return view('profile', [
            'title' => 'პაციენტი',
            'user' => $this->getUserData(),
            'user_data' => UserModel::where('id', $request->user_id)->first(),
            'invoices' => InvoiceModel::where('user_id', $request->user_id)->simplePaginate(15, '*', 'invoices')->withQueryString(),
            'consultations' => ConsultationModel::select('consultations.created_at as created_at', 'users.*', 'consultations.*')->
            join('users', 'users.id', '=', 'consultations.doctor_id')
                ->where('user_id', $request->user_id)->simplePaginate(15),
            'user_id' => $validated['user_id'],
            'files' => DB::table('users_files')
                ->join('users', 'users.id', '=', 'users_files.doctor_id')
                ->select('users_files.*', 'users.first_name as first_name', 'users.last_name as last_name')
                ->where('users_files.type', '=', 'user')
                ->where('users_files.user_id', '=', $validated['user_id'])
                ->simplePaginate(15, '*', 'files')->withQueryString()
        ]);
    }

    public function consultation(Request $request){

        $user_session = Auth::user();

        $validated = $request->validate([
            'user_id' => 'required|numeric|exists:users,id',

            'patient_complaints' => 'nullable|string',
            'examination_description' => 'nullable|string',
            'saturation' => 'required|string',
            'pressure' => 'required|string',
            'temperature' => 'required|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
            'icd_code' => 'string|nullable',
            'additional_information' => 'nullable|string',
            'final_prescription' => 'required|string',
            'recommendations_prescription' => 'required|string',

            'conducted_studies' => 'nullable|array',
            'studies' => 'nullable|array',
        ]);

        $consultation = new ConsultationModel();
        $consultation_id = $consultation->createConsultation($validated, $user_session);

        if($request->hasFile('conducted_studies')){

            $files = $request->file('conducted_studies');
            $uploads = array();

            $count = 0;
            foreach ($files as $file) {
                $count++;
                $path = str_replace('public', '/storage', $file->store('public/users_files'));
                $uploads[$count]['file_path'] = $path;
                $uploads[$count]['file_name'] = $file->getClientOriginalName();
                $uploads[$count]['type'] = 'conducted_studies';
                $uploads[$count]['consultation_id'] = $consultation_id;
                $uploads[$count]['user_id'] = $validated['user_id'];
                $uploads[$count]['doctor_id'] = $user_session->id;
                $uploads[$count]['created_at'] = date('Y-m-d H:i:s');
                $uploads[$count]['updated_at'] = date('Y-m-d H:i:s');
            }
            DB::table('users_files')->insert($uploads);

        }

        if($request->hasFile('studies')){

            $files = $request->file('studies');
            $uploads = array();

            $count = 0;
            foreach ($files as $file) {
                $count++;
                $path = str_replace('public', '/storage', $file->store('public/users_files'));
                $uploads[$count]['file_path'] = $path;
                $uploads[$count]['file_name'] = $file->getClientOriginalName();
                $uploads[$count]['type'] = 'studies';
                $uploads[$count]['consultation_id'] = $consultation_id;
                $uploads[$count]['user_id'] = $validated['user_id'];
                $uploads[$count]['doctor_id'] = $user_session->id;
                $uploads[$count]['created_at'] = date('Y-m-d H:i:s');
                $uploads[$count]['updated_at'] = date('Y-m-d H:i:s');
            }
            DB::table('users_files')->insert($uploads);

        }

        return redirect('/dashboard/users/profile?user_id='.$validated['user_id']);
    }

    public function consultationView(Request $request)
    {
        $validated = $request->validate([
            'consultation_id' => 'required|numeric|exists:consultations,id',
        ]);

        $consultation = ConsultationModel::select('consultations.created_at as consultation_created_at', 'users.*', 'consultations.*')->where('consultations.id', $validated['consultation_id'])->join('users', 'consultations.user_id', '=', 'users.id')->first();

        return view('consultation_view', [
            'title' => 'პაციენტი',
            'user' => $this->getUserData(),
            'logo' => DB::table('options')->where('option_name', '=','portal_logo')->first(),
            'consultation' => $consultation,
            'doctor' => UserModel::where('id', $consultation->doctor_id)->first(),
            'conducted_studies' => DB::table('users_files')
                ->join('users', 'users.id', '=', 'users_files.doctor_id')
                ->select('users_files.*', 'users.first_name as first_name', 'users.last_name as last_name')
                ->where('users_files.type', '=', 'conducted_studies')
                ->where('users_files.user_id', '=', $consultation->user_id)
                ->where('users_files.consultation_id', '=', $consultation->id)
                ->get(),
            'studies' => DB::table('users_files')
                ->join('users', 'users.id', '=', 'users_files.doctor_id')
                ->select('users_files.*', 'users.first_name as first_name', 'users.last_name as last_name')
                ->where('users_files.type', '=', 'studies')
                ->where('users_files.user_id', '=', $consultation->user_id)
                ->where('users_files.consultation_id', '=', $consultation->id)
                ->get()
        ]);
    }

    public function consultation_delete(Request $request)
    {
        $validated = $request->validate([
            'consultation_id' => 'required|numeric|exists:consultations,id',
            'user_id' => 'required|numeric|exists:users,id',
        ]);

        consultationModel::destroy($validated['consultation_id']);

        return redirect('/dashboard/users/profile?user_id='.$validated['user_id']);
    }
    public function files(Request $request)
    {
        $validated = $request->validate([
            'user_files' => 'required|array',
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        if($request->hasFile('user_files')){

            $user_session = Auth::user();

            $files = $request->file('user_files');
            $uploads = array();

            $count = 0;
            foreach ($files as $file) {
                $count++;
                $path = str_replace('public', '/storage', $file->store('public/users_files'));
                $uploads[$count]['file_path'] = $path;
                $uploads[$count]['file_name'] = $file->getClientOriginalName();
                $uploads[$count]['type'] = 'user';
                $uploads[$count]['user_id'] = $validated['user_id'];
                $uploads[$count]['doctor_id'] = $user_session->id;
                $uploads[$count]['created_at'] = date('Y-m-d H:i:s');
                $uploads[$count]['updated_at'] = date('Y-m-d H:i:s');
            }
            DB::table('users_files')->insert($uploads);

            return redirect ('/dashboard/users/profile?user_id='.$validated['user_id']);
        }
    }

    public function fileDelete(Request $request){
        $validated = $request->validate([
            'file_id' => 'required|numeric|exists:users_files,id',
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        $path = DB::table('users_files')->where('id', $validated['file_id'])->value('file_path');
        $path = str_replace('/storage', '', $path);

        if(Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
            DB::table('users_files')->where('id', $validated['file_id'])->delete();
        }

        return redirect('/dashboard/users/profile?user_id='.$validated['user_id']);
    }
}
