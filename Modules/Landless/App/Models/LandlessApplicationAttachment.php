<?php

namespace Modules\Landless\App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Role
 *
 * @property int $id
 */
class LandlessApplicationAttachment extends BaseModel
{
    protected $guarded = [];
    //protected $table = "landless_application_attachments";


    public function fileType(): BelongsTo
    {
        /** @var Model $this */
        return $this->belongsTo(FileType::class, 'file_type_id');
    }

}
