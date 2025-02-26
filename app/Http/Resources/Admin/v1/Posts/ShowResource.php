<?php

namespace App\Http\Resources\Admin\v1\Posts;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'view' => $this->view,
            'shared' => $this->shared,
            'recommended' => $this->recommended,
            'files' => FileResource::collection($this->files)
        ];
    }
}
