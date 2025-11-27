<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $showDeleted = $request->query("deleted") == 1;

        $users = $showDeleted
            ? User::onlyTrashed()->paginate(15)
            : User::paginate(15);

        return view("admin.users.index", compact("users", "showDeleted"));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()
            ->route("users.index")
            ->with("success", "User deleted");
    }

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
        return redirect()
            ->route("users.index", ["deleted" => 1])
            ->with("success", "User restored");
    }
}
