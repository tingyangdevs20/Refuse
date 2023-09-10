<?php

namespace App\Http\Controllers;


use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\StorePermissionsRequest;
use App\Http\Requests\Admin\UpdatePermissionsRequest;
use RealRashid\SweetAlert\Facades\Alert;
class PermissionController extends Controller
{

    public function index()
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }


         // List the tables to export
//     $tablesToExport = [
//         'admins',
//         'groups',
//         'migrations',
//         'model_has_permissions',
//         'model_has_roles',
//         'permissions',
//         'roles',
//         'role_has_permissions',
//         'scraping_source_lists',
//         'task_lists',
//         'users',
//         // Add more table names as needed
//     ];

//  // Create a zip archive to store all the SQL backup files
//  $zipFileName = 'backup.zip';
//  $zip = new \ZipArchive();
//  if ($zip->open($zipFileName, \ZipArchive::CREATE) !== true) {
//      return response()->json(['message' => 'Unable to create a ZIP archive'], 500);
//  }

//  // Loop through the table names and export each one
//  foreach ($tablesToExport as $table) {
//      $outputFile = $table . '_backup.sql';

//      // Use the mysqldump command to export the table to an SQL file
//      $command = "mysqldump -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " $table > $outputFile";
//      shell_exec($command);

//      // Add the SQL file to the zip archive
//      $zip->addFile($outputFile, $outputFile);
//  }

//  // Close the zip archive
//  $zip->close();

//  // Delete individual SQL files if needed
//  foreach ($tablesToExport as $table) {
//      $outputFile = $table . '_backup.sql';
//      unlink($outputFile);
//  }

//  // Create a response with the ZIP file and set headers for download
//  return response()->download($zipFileName)->deleteFileAfterSend(true);

        $permissions = Permission::all();

        return view('back.pages.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating new Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        return view('back.pages.permissions.create');
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \App\Http\Requests\StorePermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionsRequest $request)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        Permission::create($request->all());
        session()->flash('success', 'Permission has been created !!');
        return redirect()->route('admin.permissions.create');
    }


    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }

        $permission = Permission::find($id);

        return view('back.pages.permissions.edit', compact('permission'));
    }

    /**
     * Update Permission in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionsRequest $request,  $id)
    {

        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $permission = Permission::find($id);
        $permission->update($request->all());
        session()->flash('success', 'Permission has been updated !!');
        return redirect()->route('admin.permissions.index');
    }


    /**
     * Remove Permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $permission = Permission::find($id);
        $permission->delete();
        session()->flash('success', 'Permission has been deleted !!');
        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Permission::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
