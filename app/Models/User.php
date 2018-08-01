<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;



/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lastname', 'id_estado', 'cedula'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }



    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'PK_ESD_Id');
    }

    public function procesos()
    {
        return $this->belongsToMany(Proceso::class, 'TBL_Procesos_Usuarios', 'FK_PCU_Usuario', 'FK_PCU_Proceso');
    }
    public function programa()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'id_programa', 'PK_PAC_Id');
    }

}
