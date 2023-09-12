<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'order_id' => $this->order_id,
      'intent' => $this->intent,
      'payer_id' => $this->payer_id,
      'name' => $this->name,
      'country_code' => $this->country_code,
      'email' => $this->email,
      'purchase_units' => json_decode($this->purchase_units),
      'status' => $this->status,
      'date' => $this->created_at,
    ];
  }
}