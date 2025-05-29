<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    public $status = true;
    public $message = '';

    /**
     * Buat instance resource dengan status dan message opsional
     */
    public static function withStatusMessage($resource, $status = true, $message = '')
    {
        $instance = new static($resource);
        $instance->status = $status;
        $instance->message = $message;
        return $instance;
    }

    public function toArray($request): array
    {
        if ($this->resource instanceof \Illuminate\Support\Collection) {
            return [
                'success' => $this->status,
                'message' => $this->message,
                'data' => $this->resource->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'nim' => $item->nim,
                        'jurusan' => $item->jurusan,
                        'fakultas' => $item->fakultas,
                        'foto_profil' => $item->foto_profil ? url('storage/foto_profil/' . $item->foto_profil) : null,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                    ];
                }),
            ];
        }

        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'nama' => $this->nama,
                'nim' => $this->nim,
                'jurusan' => $this->jurusan,
                'fakultas' => $this->fakultas,
                'foto_profil' => $this->foto_profil ? url('storage/foto_profil/' . $this->foto_profil) : null,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}

