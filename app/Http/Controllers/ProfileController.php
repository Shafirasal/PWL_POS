<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $activeMenu = 'profil';
        $breadcrumb = (object) [
            'title' => 'Edit Profil',
            'list' => ['Home', 'Edit Profil']
        ];
        $page = (object) [
            'title' => 'Upload foto'
        ];
        return view('profil', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    
    // Menampilkan halaman untuk mengubah avatar
public function editAvatar()
{
    $breadcrumb = (object) [
        'title' => 'Edit Avatar',
        'list' => ['Home', 'Edit Avatar']
    ];

    $activeMenu = 'avatar'; // Menandai menu 'avatar' sebagai aktif

    return view('profile.avatar', compact('breadcrumb', 'activeMenu'));
}

    // Memproses perubahan avatar

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $avatarName = Auth::user()->id . '_avatar' . time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('avatars'), $avatarName);
             /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->avatar = $avatarName;
        $user->save();

        return redirect()->back()->with('success', 'Avatar updated successfully');
    }

// Menampilkan halaman untuk mengubah profil
public function editProfile()
{
    $breadcrumb = (object) [
        'title' => 'Edit Profil',
        'list' => ['Home', 'Edit Profil']
    ];

    $activeMenu = 'profile'; // Menandai menu 'profile' sebagai aktif

    // Ambil data user yang sedang login
    $user = Auth::user();

    // Mengirim data ke view
    return view('profile.profile', compact('breadcrumb', 'activeMenu', 'user'));
}


// // Memproses perubahan profil
// Memproses perubahan profil
public function updateProfile(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'nama' => 'required|string|max:255',
        'username' => ['required', 'string', 'max:255', Rule::unique('m_user')->ignore(Auth::user()->user_id, 'user_id')],
        'old_password' => 'required',
        'new_password' => 'required|min:5',
        'confirm_password' => 'required|same:new_password',
    ]);
 // Cek apakah password lama sesuai dengan password user yang sedang login
 $currentPassword = Auth::user()->password;
 if (!Hash::check($request->old_password, $currentPassword)) {
     return redirect()->back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
 }
 /** @var \App\Models\User $user */
 // Update password baru
 $user = Auth::user();
 $user->password = Hash::make($request->new_password);
 $user->save();
 return redirect()->back()->with('success', 'Password berhasil diubah');
}






//public function updateProfile(Request $request)
// {
//     // Validate input from the form
//     $request->validate([
//         'nama' => 'required|string|max:255',
//         'username' => [
//             'required',
//             'string',
//             'max:255',
//             Rule::unique('m_user')->ignore(Auth::user()->user_id, 'user_id')
//         ],
//         'old_password' => 'required_with:new_password', // Old password is required only if new password is being set
//         'new_password' => 'nullable|min:5|confirmed', // New password is optional, but if set, must be confirmed
//     ]);

//     // Get the currently authenticated user
//     /** @var \App\Models\User $user */
//     $user = Auth::user();

//     // Check if the old password is provided and verify it if a new password is being set
//     if ($request->new_password) {
//         // Check if the old password matches
//         if (!Hash::check($request->old_password, $user->password)) {
//             return redirect()->back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
//         }

//         // Update the new password
//         $user->password = Hash::make($request->new_password);
//     }

//     // Update the name and username
//     $user->nama = $request->nama;
//     $user->username = $request->username;

//     // Save changes to the user
//     $user->save();

//     return redirect()->back()->with('success', 'Profil berhasil diperbarui');
// }









// public function updateProfile(Request $request)
// {
//     $request->validate([
//         'nama' => 'required|string|max:255',
//         'password' => 'nullable|string|min:8|confirmed',
//     ]);

//     /** @var \App\Models\User $user **/
//     $user = Auth::user();
//     $user->update([
//         'nama' => $request->nama,
//         'password' => $request->password ? bcrypt($request->password) : $user->password,
//     ]);

//     // Redirect kembali ke halaman edit profil
//     return redirect()->back()->with('success', 'Profil berhasil diperbarui');
// }

}
