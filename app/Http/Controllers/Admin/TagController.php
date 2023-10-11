<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Tag;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        // Calculate the contact counts for each tag
        foreach ($tags as $tag) {
            $tag->contactCount = $this->getContactCountForTag($tag);
        }

        return view('back.pages.tag.index', compact('tags'));
    }

    // Helper method to get the contact count for a specific tag
    private function getContactCountForTag(Tag $tag)
    {
        // Get all groups associated with the tag
        $groups = $tag->groups;

        // Initialize a variable to store the total contact count
        $totalContactCount = 0;

        // Iterate through the groups and sum up the contact counts
        foreach ($groups as $group) {
            $totalContactCount += $group->contacts()->count();
        }

        return $totalContactCount;
    }

    // Show Tags' Contacts
    public function showTagContacts(Tag $tag)
    {
        // Get all groups associated with the tag
        $groups = $tag->groups;

        // Initialize an array to store the results
        $tagContacts = [];

        // Iterate through the groups and merge contacts for each group into the results array
        foreach ($groups as $group) {
            $contacts = $group->contacts;

            // Merge contacts into the results array
            $tagContacts = array_merge($tagContacts, $contacts->all());
        }

        // You can return the results or pass them to a view
        return view('back.pages.tag.contacts', compact('tagContacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Tag::create($request->all());
        Alert::success('Success', 'Tag Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tag = Tag::find($request->id);
        $tag->name = $request->tag_name;
        $tag->save();
        Alert::success('Success', 'Tag Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Tag::find($request->tag_id)->delete();
        Alert::success('Success', 'Tag Removed!');
        return redirect()->back();
    }
}
