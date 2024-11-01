<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServicesRequest;

use Illuminate\Support\Facades\Auth;

use App\Models\ServiceModel;

class ServiceController extends Controller
{
    private function getUserData()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return redirect('/');
        }
    }

    public function index(){
        return view('services', [
            'title' => 'სერვისები',
            'user' => $this->getUserData(),
            'services' => ServiceModel::orderBy('service_name')->simplePaginate(30)]
        );
    }

    public function search(Request $request)
    {
        $search = $request->validate([
            'service_search' => 'required|string'
        ]);

        return view('services', [
                'title' => 'სერვისები',
                'user' => $this->getUserData(),
                'services' => ServiceModel::where('service_name', 'like', '%'.$search['service_search'].'%')
                    ->orWhere('service_price', 'like', '%'.$search['service_search'].'%')
                    ->orWhere('service_description', 'like', '%'.$search['service_search'].'%')->simplePaginate(30)
            ]
        );

    }

    public function create(ServicesRequest $request) {
        $service = new ServiceModel();
        $service->create( $request->validated() );

        return redirect('/dashboard/services');
    }

    public function updateView(Request $request){
        $validated = $request->validate([
            'service_id' => 'required|numeric|exists:services,id'
        ]);

        return view('services', [
                'title' => 'სერვისები',
                'user' => $this->getUserData(),
                'services' => ServiceModel::where('id', $validated['service_id'])->simplePaginate(30),
                'update' => true
            ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|numeric|exists:services,id',
            'service_name' => 'string|required',
            'service_price' => 'numeric|required',
            'service_description' => 'string|nullable',
        ]);

        $service = new ServiceModel();
        $service->updateService($validated);

        return redirect('/dashboard/services');
    }

    public function delete(Request $request){
        $delete = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
        ]);
        $service = new ServiceModel();
        $service->remove($delete['service_id']);

        return redirect('/dashboard/services');
    }

}
