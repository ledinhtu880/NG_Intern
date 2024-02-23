<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSimple extends Model
{
  use HasFactory;
  protected $table = 'ContentSimple';
  protected $primaryKey = "Id_ContentSimple";
  public $timestamps = false;
  public function material()
  {
    return $this->belongsTo(RawMaterial::class, 'FK_Id_RawMaterial', 'Id_RawMaterial');
  }
  public function type()
  {
    return $this->belongsTo(ContainerType::class, 'FK_Id_ContainerType', 'Id_ContainerType');
  }
  public function order()
  {
    return $this->belongsTo(Order::class, 'FK_Id_Order', 'Id_Order');
  }
}
