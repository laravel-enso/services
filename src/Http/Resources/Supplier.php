<?php

namespace LaravelEnso\Services\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Products\Models\Product;

class Supplier extends JsonResource
{
    protected ?Product $product;

    public function toArray($request)
    {
        $format = Config::get('enso.config.dateFormat');
        $params = json_decode($request->get('customParams'), true);
        $id = $params['product'] ?? $this->cost?->product_id;

        $this->product = $id ? Product::find($id) : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'cost' => [
                'acquisitionPrice' => $this->acquisitionPrice(),
                'createdAt' => $this->createdAt()->format($format),
                'updatedAt' => $this->updatedAt()->format($format),
            ],
        ];
    }

    public function product(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    protected function acquisitionPrice(): ?string
    {
        return $this->cost?->acquisition_price
            ?? $this->product?->list_price;
    }

    private function createdAt(): Carbon
    {
        return $this->cost?->created_at ?? Carbon::now();
    }

    private function updatedAt(): Carbon
    {
        return $this->cost?->updated_at ?? Carbon::now();
    }
}
