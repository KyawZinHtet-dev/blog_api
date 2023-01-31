<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'post_id' => $this->id,
            'user_name' => optional($this->user)->name ?? 'Unknown User Name',
            'title' => $this->title,
            'description' => $this->description,
            'category_name' => optional($this->category)->name ?? 'Unknown Category',
            'created_at' => Carbon::parse($this->created_at)->format('d-M-Y h:mA'),
            'created_at_readable' => Carbon::parse($this->created_at)->diffForHumans(),
            'image_path' => $this->image ? asset('storage/media/' . $this->image->file_name ) : null,
        ];
    }
}
