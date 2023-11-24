<?php



namespace App\Http\Controllers;

use App\Business;
use App\BusinessLocation;
use App\Contact;
use App\Product;
use App\System;
use App\User;
use App\inventory;
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
                    @can("user.inventory_reprts")
                        <a href="{{action(\'InventoryController@inventory_reprts\', [$id])}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></i> @lang("التقارير")</a>
                        &nbsp;
                    @endcan
                    @can("user.more")
                        <a href="{{action(\'InventoryController@inventory_more\', [$id])}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></i> @lang("تقارير الزياده")</a>
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





    public function inventory_more($id)
    {

        $inventory = Inventory::with('product', 'location')->where('location_id', $id)->where('difference_quantity', ">", 0)->get();

        return view('inventories.more', compact('inventory'));
    }
    public function inventory_reprts($id)
    {

        $inventory = Inventory::with('product', 'location')->where('location_id', $id)->get();

        return view('inventories.inventory', compact('inventory'));
    }



    public function inventory_less($id)
    {
        $inventory = Inventory::with('product', 'location')->where('location_id', $id)->where('difference_quantity', "<", 0)->get();

        return view('inventories.less', compact('inventory'));
    }
    public function inventoryByLocation($id)
    {

        $session_inventories = session()->get('inventory');
        return view('inventories.inventory-by-location', compact('session_inventories'));
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



    public function searchForProducts(Request $request)
    {
        $search_word = $request->search_word;
        $search_word_length = strlen($search_word);
        $id = substr(url()->previous(), -1);

        if ($search_word) {
            // $products = Product::with('product_locations')
            // ->join('product_locations', 'products.id', '=', 'product_locations.product_id')
            // ->where('location_id', $id)
            // ->whereRaw("SUBSTRING(name, 1, $search_word_length) = ?", $search_word)
            // ->get();

            $products = Product::with('product_locations')
                ->join('product_locations', 'products.id', '=', 'product_locations.product_id')
                ->where('location_id', $id)
                ->where('products.name', 'LIKE', '%' . $search_word . '%')
                ->select('id', 'name')
                ->get();


            return response()->json($products);
        }
    }

    public function getProducts(Request $request)
    {
        $product = Product::find($request->id);

        $product = Product::with('product_locations')->find($request->id);

        return response()->json($product);
    }


    public function makeInventory(Request $request)
    {


        $inventory = [
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'current_quantity' => $request->current_quantity,
            'finded_quantity' => $request->finded_quantity,
            'difference_quantity' => $request->difference_quantity,
        ];

        if (session()->has('inventory')) {
            $inventories = collect(session()->get('inventory'));
            $inventories->push($inventory);
            session()->put('inventory', $inventories->all());
        } else {
            session()->put('inventory', [$inventory]);
        }

        $session_inventories = session()->get('inventory');

        return response()->json($session_inventories);
    }

    public function storeInventory(Request $request)
    {

        $session_inventories = session()->get('inventory');

        $location_id = substr(url()->previous(), -1);

        foreach ($session_inventories as $inventory) {
            //check if product_id exist

            Inventory::create([
                "product_id" => $inventory["product_id"],
                "location_id" => $location_id,
                "current_quantity" => $inventory["current_quantity"],
                "finded_quantity" => $inventory["finded_quantity"],
                "difference_quantity" => $inventory["difference_quantity"],
            ]);
        }

        session()->forget('inventory');

        return response()->json('success');
    }


    public function removeInventory(Request $request)
    {
        session()->forget('inventory');
        return response()->json('success');
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
        $product = inventory::find($id);
        $product->destroy($id);
        return back();
    }
}
