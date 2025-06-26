<?php

use App\Models\Branch;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

function uniqueId($model, $column)
{
    do {
        $code = random_int(100000, 999999);
    } while ($model::where($column, $code)->first());
    return $code;
}

function branches()
{
    return Branch::all();
}

function decomFormula()
{
    return array('powder1' => 0.40, 'powder2' => 0.40, 'cocopeat' => 0.92, 'qty' => 1);
}

function mixingFormula()
{
    return array('liquid' => 0.01, 'powder' => 0.07, 'cocopeat' => 0.92, 'qty' => 1);
}

function defaultProductIds()
{
    return array('ppcp' => 1, 'color' => 2, 'powder1' => 16, 'powder2' => 17, 'liquid' => 15, 'mixing_powder' => 20, '3kg_decom' => 18, '5kg_decom' => 19);
}

function materialTypes()
{
    return array('material' => 'material', 'parts' => 'parts', 'bin' => 'bin', 'powder' => 'powder', 'liquid' => 'liquid', 'bag' => 'bag', 'decom' => 'decom');
}

function getInventory($item, $item_id, $company)
{
    $inventory = [];
    $inventory = DB::select("SELECT tbl3.*, (tbl3.purchasedQty + transferIn + productionQtyIn) - (productionQtyOut + transferOut) AS balanceQty FROM (SELECT tbl2.*, IFNULL(SUM(CASE WHEN prod.company_id = ? AND prod.deleted_at IS NULL AND prode.deleted_at IS NULL AND prode.type = 'in' THEN prode.qty ELSE 0 END), 0) AS productionQtyIn, IFNULL(SUM(CASE WHEN prod.company_id = ? AND prod.deleted_at IS NULL AND prode.deleted_at IS NULL AND prode.type = 'out' THEN prode.qty ELSE 0 END), 0) AS productionQtyOut FROM (SELECT tbl1.*, IFNULL(SUM(CASE WHEN t.to_company_id=? AND t.deleted_at IS NULL AND td.deleted_at IS NULL AND t.approved_status = 'approved' THEN td.qty ELSE 0 END), 0) AS transferIn, IFNULL(SUM(CASE WHEN t.from_company_id=? AND t.deleted_at IS NULL AND td.deleted_at IS NULL AND t.approved_status = 'approved' THEN td.qty ELSE 0 END), 0) AS transferOut FROM (SELECT m.id AS pid, m.name AS pname, IFNULL(SUM(CASE WHEN p.company_id=? AND p.deleted_at IS NULL AND pd.deleted_at IS NULL THEN pd.qty ELSE 0 END), 0) AS purchasedQty FROM materials AS m LEFT JOIN purchase_details AS pd ON m.id = pd.material_id LEFT JOIN purchases AS p ON p.id = pd.purchase_id WHERE IF(? > 0, m.id = ?, 1) GROUP BY pid, pname) AS tbl1 LEFT JOIN transfer_details AS td ON td.item = tbl1.pid LEFT JOIN transfers AS t ON t.id = td.transfer_id GROUP BY pid, pname, purchasedQty) AS tbl2 LEFT JOIN production_details AS prode ON prode.material_id = tbl2.pid LEFT JOIN productions AS prod ON prod.id = prode.production_id GROUP BY pid, pname, purchasedQty, transferIn, transferOut) AS tbl3", [$company, $company, $company, $company, $company, $item_id, $item_id]);
    return collect($inventory);
}
