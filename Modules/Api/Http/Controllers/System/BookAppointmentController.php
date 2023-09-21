<?php
namespace Modules\Api\Http\Controllers\System;
use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
use Illuminate\Http\Request;

class BookAppointmentController extends Controller{
    public function store(Request $request){
        $data = request()->validate([
            'name' => 'required',
            'phone_or_email' => 'required',
            'date' => 'required',
        ]);
        $bookAppointment = BookAppointment::create($data);
        return response()->json([
            'message' => 'Book Appointment created successfully',
            'data' => $bookAppointment,
        ]);
    }
}
