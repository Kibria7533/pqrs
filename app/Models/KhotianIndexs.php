<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhotianIndexs extends Model
{
    public static $surveyType = [
        'cs'     => 1,
        'rs'     => 2,
        'sa'     => 3,
        'bs'    => 4,
        'diara' => 5,
        'pety'     => 6,
        'ct'     => 7,
        'brs' => 8,
        'muted'=>10
    ];

    public static $surveyTypeLabel = [
        'cs'     => 'সি.এস',
        'rs'     => 'আর.এস',
        'sa'     => 'এস.এ',
        'bs'    => 'বি.এস',
        'pety'     => 'পেটি',
        'ct'     => 'সিটি',
        'brs'   => 'বি.আর.এস',
        'diara' => 'দিয়ারা',
        'muted'=>'নামজারি',
    ];

    public const SURVEY_TYPE = [
        1 => 'সি.এস',
        2 => 'আর.এস',
        3 => 'এস.এ',
        4 => 'বি.এস',
        5 => 'পেটি',
        6 => 'সিটি',
        7 => 'বি.আর.এস',
        8 => 'দিয়ারা',
        10 => 'নামজারি',
    ];

    public static $applicationTypeLabel = [
        '1'     => 'খতিয়ান',
        '4'     => ' ম্যাপ'
    ];

    public $timestamps = false;
    protected $table = '';
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function setTableName($tableName = ''){
        if(!empty($tableName))
            $this->table = $tableName;
    }

}
