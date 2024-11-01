<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class UserModel extends Authenticatable
{
    use Notifiable;

    public function createStaff($data)
    {
        $this->username = $data['username'];
        $this->password = Hash::make($data['password']);
        $this->email = $data['email'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->phone = $data['phone'];
        $this->proficiency = !empty($data['proficiency']) ? $data['proficiency'] : '';
        $this->consultation_price = !empty($data['consultation_price']) ? $data['consultation_price'] : '';
        $this->role = $data['role'];
        $this->save();
    }

    public function updateStaff($data)
    {
        $update = UserModel::find($data['user_id']);
        $update->username = $data['username'];

        if( filled($data['password']) ){
            $update->password = Hash::make($data['password']);
        }

        $update->email = $data['email'];
        $update->first_name = $data['first_name'];
        $update->last_name = $data['last_name'];
        $update->phone = $data['phone'];
        $update->proficiency = !empty($data['proficiency']) ? $data['proficiency'] : '';
        $update->consultation_price = !empty($data['consultation_price']) ? $data['consultation_price'] : '';
        $update->role = $data['role'];
        $update->save();
    }

    public function createUser($data)
    {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->personal_number = $data['personal_number'];
        $this->birth_date = $data['birth_date'];
        $this->gender = $data['gender'];
        $this->citizenship = !empty($data['citizenship']) ? $data['citizenship'] : '';
        $this->insurance = !empty($data['insurance']) ? $data['insurance'] : '';
        $this->parent_first_name = !empty($data['parent_first_name']) ? $data['parent_first_name'] : '';
        $this->parent_last_name = !empty($data['parent_last_name']) ? $data['parent_last_name'] : '';
        $this->parent_personal_number = !empty($data['parent_personal_number']) ? $data['parent_personal_number'] : '';
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->email = $data['email'];
        $this->referral_source = $data['referral_source'];
        $this->role = 'user';
        $this->save();
    }

    public function updateUser($data)
    {
        $user = UserModel::find($data['user_id']);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->personal_number = $data['personal_number'];
        $user->birth_date = $data['birth_date'];
        $user->gender = $data['gender'];
        $user->citizenship = !empty($data['citizenship']) ? $data['citizenship'] : '';
        $user->insurance = !empty($data['insurance']) ? $data['insurance'] : '';
        $user->parent_first_name = !empty($data['parent_first_name']) ? $data['parent_first_name'] : '';
        $user->parent_last_name = !empty($data['parent_last_name']) ? $data['parent_last_name'] : '';
        $user->parent_personal_number = !empty($data['parent_personal_number']) ? $data['parent_personal_number'] : '';
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->email = $data['email'];
        $user->referral_source = $data['referral_source'];
        $user->save();
    }

    public function remove($data)
    {
        $this->destroy($data);
    }

    protected $table = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
