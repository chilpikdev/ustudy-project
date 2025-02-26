<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\v1\File\DeleteAction;
use App\Actions\Admin\v1\File\DownloadAction;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController
{
    /**
     * Summary of download
     * @param string $id
     * @param \App\Actions\Admin\v1\File\DownloadAction $action
     * @return BinaryFileResponse
     */
    public function download(string $id, DownloadAction $action): BinaryFileResponse
    {
        return $action($id);
    }

    /**
     * Summary of delete
     * @param string $id
     * @param \App\Actions\Admin\v1\File\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(string $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }
}
