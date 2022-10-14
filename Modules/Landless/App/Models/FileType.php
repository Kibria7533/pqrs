<?php

namespace Modules\Landless\App\Models;

/**
 * App\Models\Role
 *
 * @property int $id
 */
class FileType extends BaseModel
{
    protected $guarded = [];
    //protected $table = "file_types";

    public const FILE_EXTENSIONS = [
        1 => 'jpg',
        2 => 'png',
        3 => 'jpeg',
        4 => 'pdf',
    ];

}
