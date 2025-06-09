<?php

use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

function uniqueId($model, $column)
{
    do {
        $code = random_int(100000, 999999);
    } while ($model::where($column, $code)->first());
    return $code;
}

function getInventory($item, $item_id, $company)
{
    $inventory = [];
    if ($item == 'material'):
        $inventory = DB::select("SELECT tbl1.*, IFNULL(SUM(CASE WHEN t.to_company_id=? AND t.deleted_at IS NULL AND td.deleted_at IS NULL AND t.approved_status = 'approved' THEN td.qty ELSE 0 END), 0) AS transferIn, IFNULL(SUM(CASE WHEN t.from_company_id=? AND t.deleted_at IS NULL AND td.deleted_at IS NULL AND t.approved_status = 'approved' THEN td.qty ELSE 0 END), 0) AS transferOut FROM (SELECT m.id AS pid, m.name AS pname, IFNULL(SUM(CASE WHEN p.company_id=? AND p.deleted_at IS NULL AND pd.deleted_at IS NULL THEN pd.qty ELSE 0 END), 0) AS purchasedQty FROM materials AS m LEFT JOIN purchase_details AS pd ON m.id = pd.material_id LEFT JOIN purchases AS p ON p.id = pd.purchase_id WHERE IF(? > 0, m.id = ?, 1) GROUP BY pid, pname) AS tbl1 LEFT JOIN transfer_details AS td ON td.item = tbl1.pid LEFT JOIN transfers AS t ON t.id = td.transfer_id GROUP BY pid, pname, purchasedQty", [$company, $company, $company, $item_id, $item_id]);
    endif;
    return collect($inventory);
}
