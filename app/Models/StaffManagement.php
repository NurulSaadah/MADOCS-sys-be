<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffManagement extends Model
{
    use HasFactory;

    const CREATED_BY = 'added_by';

    // const UPDATED_BY = 'driverstarrating_upd_by';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff_management';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nric_no', 'contact_no',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'staff_id' => '',
        'name'=>'',
        'nric_no'=>'',
        'contact_no'=>'',
        'added_by' => '',
        'created_at' => '0',
        'updated_at' => '0',
    ];


    /**
     * The model's map.
     *
     * @var array
     */
    protected $aliases = [
        'staff_id' => 'staff_id',
        'name'=>'name',
        'nric_no'=>'nric_no',
        'contact_no'=>'contact_no',
        'added_by' => 'added_by',
        'created_at' => 'crated_at',
        'updated_at' => 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($record) {
            $record->touchCreatedBy(self::CREATED_BY);
        });

        // static::updating(function ($record) {
        //     $record->touchUpdatedBy(self::UPDATED_BY);
        // });
    }
}
