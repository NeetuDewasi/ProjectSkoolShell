<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryIssueItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'login_user_id',
        'inventory_item_category_id',
        'inventory_add_item_id',
        'inventory_item_department_id',
        'inventory_item_employee_id',
        'quantity',
        'return_date',
        'description'
    ];
    public function inventoryItemCategory()
    {
        return $this->belongsTo(InventoryItemCategory::class);
    }
    public function inventoryAddItem()
    {
        return $this->belongsTo(InventoryAddItem::class);
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'inventory_item_department_id', 'id');
    }
    public function employees()
    {
        return $this->belongsTo(Employee::class, 'inventory_item_employee_id', 'id');
    }
}
