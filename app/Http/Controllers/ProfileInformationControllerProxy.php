<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
Use  \Laravel\Fortify\Contracts\UpdatesUserProfileInformation  ;

use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;

class ProfileInformationControllerProxy extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(Request $request,
    UpdatesUserProfileInformation $updater)
    {
        $updater = (new UpdateUserProfileInformation);
        (new ProfileInformationController)->update($request, $updater);

        Alert::success('User Updated Successfully', 'We have effected the requested changes on your details.');
        return redirect()->route('profile');
    }

}
