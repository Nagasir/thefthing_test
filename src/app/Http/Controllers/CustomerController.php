<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\CustomFilter\EmailFilter;
use App\Http\CustomFilter\GenderFilter;
use App\Http\CustomFilter\NameFilter;
use App\Http\CustomFilter\AddressFilter;
use App\Http\CustomFilter\MarriageFilter;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = QueryBuilder::for(Customer::class)
            ->allowedFilters([
                AllowedFilter::custom('name', new NameFilter),
                AllowedFilter::custom('email', new EmailFilter),
                AllowedFilter::custom('gender', new GenderFilter),
                AllowedFilter::custom('is_married', new MarriageFilter),
                AllowedFilter::custom('address', new AddressFilter)
            ])
            ->defaultSort('-created_at')
            ->allowedSorts('name', 'email', 'gender', 'is_married', 'address')
            ->paginate(\request()->get('size') ?? 5);

        return response()->json([
            'status' => [
                'code' => 200,
                'response' => "success",
                'message' => ""
            ],
            'result' => $customer
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newCustomer = new Customer;
        $newCustomer->name = $request->customer['name'];
        $newCustomer->email = $request->customer['email'];
        $newCustomer->password = Hash::make($request->customer['password']);
        $newCustomer->gender = $request->customer['gender'];
        $newCustomer->is_married = $request->customer['isMarried'];
        $newCustomer->address = $request->customer['address'];
        $newCustomer->save();

        return response()->json([
            'status' => [
                'code' => 201,
                'response' => "success",
                'message' => "Customer Created Successfully"
            ],
            'result' => []
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if(!is_null($customer)){
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => "success",
                    'message' => ""
                ],
                'result' => $customer
            ]);
        }

        return response()->json([
            'status' => [
                'code' => 404,
                'response' => "error",
                'message' => "Data Not Found"
            ],
            'result' => []
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if(!is_null($customer)){
            $customer->name = $request->customer['name'];
            $customer->email = $request->customer['email'];
            if($request->filled('customer.password')){
                $customer->password = Hash::make($request->customer['password']);
            }
            $customer->gender = $request->customer['gender'];
            $customer->is_married = $request->customer['isMarried'];
            $customer->address = $request->customer['address'];

            $customer->save();

            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => "success",
                    'message' => "Customer Has Been Updated."
                ],
                'result' => []
            ]);

        }

        return response()->json([
            'status' => [
                'code' => 404,
                'response' => "error",
                'message' => "Data Not Found"
            ],
            'result' => []
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if(!is_null($customer)){
            $customer->delete();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => "success",
                    'message' => "Customer Has Been Deleted."
                ],
                'result' => []
            ]);
        }

        return response()->json([
            'status' => [
                'code' => 404,
                'response' => "error",
                'message' => "Data Not Found"
            ],
            'result' => []
        ], 404);
    }
}
