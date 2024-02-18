<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\requestTicket;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    // Dashboard All Data
    
    public function index(){
        if(auth()->user()->role == 'Warehouse'){
            return view('dashboard', [
                'data' => requestTicket::all()
            ]);
        }else{
            return view('dashboard', [
                'data' => requestTicket::where('account_id', auth()->user()->id)->get()
            ]);
        }
    }

    public function approved(){
        return view('dashboard', [
            'data' => requestTicket::where('status', 'Approved')->get()
        ]);
    }

    
    public function pending(){
        return view('dashboard', [
            'data' => requestTicket::where('status', 'Pending')->get()
        ]);
    }

    public function rejected(){
        return view('dashboard', [
            'data' => requestTicket::where('status', 'Rejected')->get()
        ]);
    }



    public function index2(){
        return view('dashboard2', [
            'data' => requestTicket::all()
        ]);
    }

    // New Material Store / Add
    public function store(Request $request)
    {
      
        try {
            // Your validation and data creation code
            $request->validate([
                'request_name' => 'required',
                'materials.*.material_name' => 'required',
                'materials.*.quantity' => 'required|numeric|min:1',
                'materials.*.usage' => 'required',
            ]);

            // Create new ticket
            $newRequest = requestTicket::create([
                'request_name' => $request->request_name,
                'status' => 'Pending',
                'account_id' => auth()->user()->id
            ]);

            // Fetch data from array
            foreach ($request->materials as $materialData) {
                $material = new Material($materialData);
                $newRequest->materials()->save($material);
            }

            Session::flash('success', 'Request saved successfully');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to save request');
        }

        return redirect()->back();
    }
    

    
    // Update Material
    public function update(Request $request)
    {
        try {
            
            foreach ($request->materials as $materialData) {
                $material = Material::find($materialData['id']);
                $material->update([
                    'material_name' => $materialData['material_name'],
                    'quantity' => $materialData['quantity'],
                    'usage' => $materialData['usage']
                ]);
                $revised = requestTicket::findOrFail($materialData['request_ticket_id']);
                $revised->revised = 'Revised';
                $revised->save();
            }
            return response()->json(['message' => 'Material data updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update material data'], 500);
        }
    }

    // Show Material data details by ID
    public function show($id)
    {
        $material = Material::where('request_ticket_id', $id)->get();
        // dd($material);
        return response()->json($material);
    }

    // Approve Status
    public function approve(Request $request, $id)
    {
        $request = requestTicket::findOrFail($id);
        $request->status = 'Approved'; 
        $request->save();

        return response()->json(['message' => 'Request approved successfully']);
    }

    // Reject Status
    public function reject(Request $request, $id)
    {
        $request = requestTicket::findOrFail($id);
        $request->status = 'Rejected';
        $request->save();

        return response()->json(['message' => 'Success Rejected materials']);
    }
    
    // Delete Ticket
    public function destroy($id)
    {
        $item = requestTicket::findOrFail($id);
        $item->delete();
    }
}
