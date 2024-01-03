<?php

namespace App\Http\Controllers\School\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventorySupplierInfo;
use App\Http\Resources\School\Inventory\SupplierInfoResource;
use Illuminate\Http\Request;

class ItemSupplierController extends Controller
{
    public function getData()
    {
        $InventorySupplierInfos = InventorySupplierInfo::where('school_id', 1)->get();
        if(count($InventorySupplierInfos) > 0) return response([
                'status' => 'success',
                'status_code' => 200,
                'supplier_name' => $InventorySupplierInfos,
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'supplier_name' => null,
            'message' => 'No income head created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $InventorySupplierInfos = InventorySupplierInfo::where('supplier_name', $request->supplier_name)->where('school_id', 1)->first();

        if($InventorySupplierInfos) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Supplier is already exist'
        ]);

        $created = InventorySupplierInfo::create([
            'school_id' => 1,
            'supplier_name'=> $request->supplier_name,
            'email'=> $request->email,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'contact_person_name'=> $request->contact_person_name,
            'contact_person_phone'=> $request->contact_person_phone,
            'contact_person_email'=> $request->contact_person_email,
            'description'=> $request->description
        ]);

        if($created) {
            $supplier=InventorySupplierInfo::find($created->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Supplier created successfully',
                'supplier_name' => new SupplierInfoResource($supplier),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Supplier',
        ]);
    }

    public function getEditData(InventorySupplierInfo $inventorySupplierInfo)
    {
        return response([
            'status' => 'success',
            'supplier' => $inventorySupplierInfo,
        ]);
    }

    public function updateData(Request $request, InventorySupplierInfo $InventorySupplierInfo)
    {
        $updated = $InventorySupplierInfo->update([
            'school_id' => 1,
            'supplier_name'=> $request->supplier_name,
            'email'=> $request->email,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'contact_person_name'=> $request->contact_person_name,
            'contact_person_phone'=> $request->contact_person_phone,
            'contact_person_email'=> $request->contact_person_email,
            'description'=> $request->description

        ]);
        if($updated) { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Store Supplier updated successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Supplier',
        ]);
    }

    public function deleteData(InventorySupplierInfo $InventorySupplierInfo)
    {
        $deleted = $InventorySupplierInfo->delete();
        if($deleted)
        { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Supplier deleted successfully'
            ]);
        }else{
            return response([
                'status' => 'error',
                'status_code' => 400,
                'message' => 'Something went wrong, unable to create Supplier',
            ]);
        }

    }
}
