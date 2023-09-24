<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class GoogleDriveController extends Controller
{
    public $gClient;

    public function __construct()
    {
        $this->gClient = new \Google_Client();

        $this->gClient->setApplicationName('Web client 1'); // ADD YOUR AUTH2 APPLICATION NAME (WHEN YOUR GENERATE SECRATE KEY)
        $this->gClient->setClientId('356520419540-q0a594dh2vq0igohtslbi7sgudg0iqhm.apps.googleusercontent.com');
        $this->gClient->setClientSecret('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');
        $this->gClient->setRedirectUri(route('admin.google-drive-callback'));
        $this->gClient->setDeveloperKey('AIzaSyB0JsRitCEiYehLDllpu7v5ULPwJZUpbcw');
        $this->gClient->setScopes([
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive',
        ]);

        $this->gClient->setAccessType("offline");
        $this->gClient->setApprovalPrompt("force");
    }

    public function googleLogin(Request $request)  {
      
        $rules = [
            'file' => 'required', // Adjust the allowed file types and size limit as needed
        ];
    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'File filed is required');
        }
        $google_oauthV2 = new \Google_Service_Oauth2($this->gClient);

        if ($request->get('code')){

            $this->gClient->authenticate($request->get('code'));
            $accessToken = $this->gClient->getAccessToken();
          
            // Store the refresh token securely (e.g., in your database)
            $refreshToken = $this->gClient->getRefreshToken();

            // Save the access token and refresh token in the user's record
            $user = User::find(1);
            $user->access_token = json_encode($accessToken);
            $user->refresh_token = json_encode($refreshToken);
            $user->save();

            $request->session()->put('token', $accessToken);
            $request->session()->put('refreshtoken', $refreshToken);
        }
       
        if ($request->session()->get('token')){

            $this->gClient->setAccessToken($request->session()->get('token'));
        }

        if ($request->hasFile('file')) {
            // Store the uploaded file information in the session
            $fileInfo = [
                'name' => $request->file('file')->getClientOriginalName(),
                'mime' => $request->file('file')->getMimeType(),
                'path' => $request->file('file')->getRealPath(),
            ];
            $request->session()->put('uploaded_file_info', $fileInfo);
        }

        if ($this->gClient->getAccessToken()){

            // FOR LOGGED IN USER, GET DETAILS FROM GOOGLE USING ACCESS TOKEN
            $user = User::find(1);

            $user->access_token = json_encode($request->session()->get('token'));
        
            $user->refresh_token = json_encode($request->session()->get('refreshtoken')); // Store the refresh token

            $user->save();       
            
          
            return $this->googleDriveFileUpload($request);
        
        } else{
            
            // FOR GUEST USER, GET GOOGLE LOGIN URL
            $authUrl = $this->gClient->createAuthUrl();

            return redirect()->to($authUrl);
        }
    }
    

    public function googleDriveFileUpload(Request $request)
    {
        $rules = [
            'file' => 'required', // Adjust the allowed file types and size limit as needed
        ];
    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'File filed is required');
        }
       $service = new \Google_Service_Drive($this->gClient);

        $user = User::find(1);

        $this->gClient->setAccessToken(json_decode($user->access_token,true));

        if ($this->gClient->isAccessTokenExpired()) {
           
            // Get the stored refresh token from your user record
            $user = User::find(1);
            $refreshToken = $user->refresh_token;

            // Use the refresh token to fetch a new access token
            $this->gClient->fetchAccessTokenWithRefreshToken($refreshToken);
            
            // Get the updated access token
            $accessToken = $this->gClient->getAccessToken();

            // Update the user's access token in the database
            $user->access_token = json_encode($accessToken);
            $user->save();                
        }
        
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => 'BULK SMS',             // ADD YOUR GOOGLE DRIVE FOLDER NAME
            'mimeType' => 'application/vnd.google-apps.folder'));

        $folder = $service->files->create($fileMetadata, array('fields' => 'id'));

        // printf("Folder ID: %s\n", $folder->id);
        
        $file = new \Google_Service_Drive_DriveFile(array('name' => $request->file('file')->getClientOriginalName(),'parents' => array($folder->id)));

        $result = $service->files->create($file, array(
            'data' => file_get_contents($request->file('file')), // ADD YOUR FILE PATH WHICH YOU WANT TO UPLOAD ON GOOGLE DRIVE
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media'
        ));
        $url = 'https://drive.google.com/open?id=' . $result->id;
        return redirect()->back()->with('upload', 'File uploaded to Google Drive. URL: ' . $url);
    }

    // Add a method to display the file upload form
    public function showUploadForm()
    {
        return view('google');
    }


    public function handleGoogleCallback(Request $request)
    {
        // Check if the user denied access
        if ($request->has('error')) {
            return redirect()->back()->with('notupload', 'Access to Google Drive was denied by the user.');
        }

        // Check if the 'code' parameter is present in the callback request
        if (!$request->has('code')) {
            return redirect()->back()->with('notupload', 'Authorization code is missing.');
        }

        // Exchange the authorization code for an access token
        $authorizationCode = $request->get('code');
        $this->gClient->authenticate($authorizationCode);
        $accessToken = $this->gClient->getAccessToken();

        // Check if the access token is valid
        if (!$accessToken) {
            return redirect()->back()->with('notupload', 'Failed to obtain access token.');
        }

        // Store the access token in the session
        $request->session()->put('token', $accessToken);

        // Redirect to the file upload form
        return redirect()->back()->with('upload', 'Authorization successful. You can now upload a file to Google Drive.');
    }

}
