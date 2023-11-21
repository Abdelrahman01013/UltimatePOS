<?php



namespace App\Http\Controllers;

use App\BusinessLocation;
use App\Contact;
use App\Product;
use App\System;
use App\User;
use App\Utils\ModuleUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;



class InventoryController extends Controller
{


    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('user.view') && !auth()->user()->can('user.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            $bussness_locations = BusinessLocation::all();

            return Datatables::of($bussness_locations)
                ->addColumn(
                    'action',
                    '
                    @can("user.update")
                        <a href="{{action(\'InventoryController@inventoryByLocation\', [$id])}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> @lang("lang_v1.inventory")</a>
                        &nbsp;
                    @endcan
                    @can("user.more")
                        <a href="{{action(\'InventoryController@inventory_more\', [$id])}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></i> @lang("تقارير الزياده")</a>
                        &nbsp;
                    @endcan
                    @can("user.less")
                        <a href="{{action(\'InventoryController@inventory_less\', [$id])}}" class="btn btn-xs btn-danger"><i class="fa fa-eye"></i></i> @lang("تقارير العجز")</a>
                        &nbsp;
                    @endcan
                   
                    @can("user.delete")
                        <button data-href="{{action(\'ManageUserController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_user_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
                )
                ->removeColumn('id')
                ->rawColumns(['action', 'name'])
                ->make(true);
        }

        return view('inventories.index');
    }

    public function inventoryByLocation($id)
    {

        $products = Product::with('product_locations')
            ->join('product_locations', 'products.id', '=', 'product_locations.product_id')
            ->where('location_id', $id)
            ->get();

        return view('inventories.inventory-by-location')->with('products', $products);
    }


    public function inventory_more($id)
    {

        $products = Product::with('product_locations')
            ->join('product_locations', 'products.id', '=', 'product_locations.product_id')
            ->where('location_id', $id)
            ->get();

        return view('inventories.more')->with('products', $products);
    }



    public function inventory_less($id)
    {

        $products = Product::with('product_locations')
            ->join('product_locations', 'products.id', '=', 'product_locations.product_id')
            ->where('location_id', $id)
            ->get();

        return view('inventories.less')->with('products', $products);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
