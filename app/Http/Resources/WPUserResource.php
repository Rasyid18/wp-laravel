<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WPUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $metaKeys = ['nickname', 'first_name', 'last_name', 'description', 'wp_capabilities'];
        $meta = $this->meta->whereIn('meta_key', $metaKeys)->mapWithKeys(function ($item) {
            if ($item->meta_key === 'wp_capabilities') {
                $caps = @unserialize($item->meta_value);
                $item->meta_value = $caps ? array_key_first($caps) : 'subscriber';
            }
            return [$item->meta_key => $item->meta_value];
        });

        return [
            'ID' => $this->ID,
            'user_login' => $this->user_login,
            'display_name' => $this->display_name,
            'user_email' => $this->user_email,
            'user_url' => $this->user_url,
            'user_registered' => $this->user_registered,
            'meta' => $meta,
        ];
    }
}
