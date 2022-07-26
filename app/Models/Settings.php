<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $table = 'settings';
    protected $primaryKey = 'settings_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['settings_id'];
    const CREATED_AT = 'settings_created';
    const UPDATED_AT = 'settings_updated';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'key',
        'value'
    ];

    /**
     * 
     * setting value by key
     * @param: String|setting-key
     * @return: Object| setting value
     */
    public function get_key($key)
    {   
        $value = self::where('key',$key)->first();
        
        return $value;
            
    }
}
