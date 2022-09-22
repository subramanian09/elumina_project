<?php
    
namespace App\Http\Controllers;
    
use App\Models\Form;
use Illuminate\Http\Request;

    
class FormsController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:forms-list|forms-edit', ['only' => ['index','show']]);
         $this->middleware('permission:forms-edit', ['only' => ['approve','reject']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::latest()->paginate(5);
        return view('forms.index',compact('forms'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        return view('forms.edit',compact('form'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'status' => 'required'
        ]);
    
        $forms->update($request->all());
    
        return redirect()->route('forms.index')
                        ->with('success','Form updated successfully');
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        $form->update(['status'=>'In review']);
        return view('forms.show',compact('form'));
    }

    public function approve(Request $request)
    {
        $id = $request->route('id');
        Form::where('id',$id)->update(['status'=>'Approved']);
        $form = Form::where('id',$id)->first();

        $details = [
            'first_name' => $form->first_name,
            'last_name' => $form->last_name,
            'status' => $form->status,
            "email" =>$form->email
        ];
       
        \Mail::to($details['email'])->send(new \App\Mail\MyMail($details));

        return view('forms.approve',compact('form'));
    }

    public function reject(Request $request)
    {
        $id = $request->route('id');
        Form::where('id',$id)->update(['status'=>'Rejected']);
        $form = Form::where('id',$id)->first();
        $details = [
            'first_name' => $form->first_name,
            'last_name' => $form->last_name,
            'status' => $form->status,
            "email" =>$form->email
        ];
       
        \Mail::to($details['email'])->send(new \App\Mail\MyMail($details));
        return view('forms.reject',compact('form'));
    }
}