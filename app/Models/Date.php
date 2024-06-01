<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Date extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function products(){
        return $this->hasMany(Product_day::class);
    }

    public function stockProducts($date){
        return DB::select(
            "
select p.*, (COALESCE(x.total_product,0)-COALESCE(s.sale,0)) as stock
from products p
left join
(select product_id,sum(quantity) as sale from detail_products
left join transactions t on t.id=transaction_id
where date(t.created_at)=date('$date')
GROUP by product_id) s on p.id=s.product_id
left join (select q.product_id, sum(q.quantity) as total_product
from product_days q
left join dates da on da.id=q.date_id
where da.event_day=date('$date')
GROUP BY q.product_id) x on p.id=x.product_id
where (COALESCE(x.total_product,0)-COALESCE(s.sale,0))>0

            "
        );

    }
}



// SELECT p.*
// FROM products p
// LEFT JOIN product_days d ON p.id = d.product_id
// LEFT JOIN (
//     SELECT q.product_id, SUM(quantity) AS total_sale, q.transaction_id
//     FROM detail_products q
//     GROUP BY q.product_id
// ) s ON p.id = s.product_id
// JOIN dates da ON da.id = d.date_id
// JOIN transactions t ON t.id = s.transaction_id
// WHERE (d.quantity - COALESCE(s.total_sale, 0)) > 0
//     AND da.event_day = CURDATE()
//     AND DATE(t.created_at) = CURDATE()
