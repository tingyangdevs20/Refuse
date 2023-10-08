<?php

namespace App\Http\Controllers;

use App\Model\Contact;
use App\Model\Settings;
use Illuminate\Http\Request;
use App\User;
use Google\Service\Drive\Drive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Google\Service\Drive as DriveService;
use Illuminate\Support\Facades\Log;

class GoogleDriveController extends Controller
{
    public $gClient;

    public function __construct()
    {
        // Fetch Google Drive Credentials
        $settings = Settings::first()->toArray();

        $GOOGLE_DRIVE_CLIENT_ID = $settings['google_drive_client_id'];
        $GOOGLE_DRIVE_CLIENT_SECRET = $settings['google_drive_client_secret'];
        $GOOGLE_DRIVE_DEVELOPER_KEY = $settings['google_drive_developer_key'];

        $this->gClient = new \Google_Client();

        $this->gClient->setApplicationName('Web client 1'); // ADD YOUR AUTH2 APPLICATION NAME (WHEN YOUR GENERATE SECRATE KEY)
        $this->gClient->setClientId($GOOGLE_DRIVE_CLIENT_ID);
        $this->gClient->setClientSecret($GOOGLE_DRIVE_CLIENT_SECRET);
        $this->gClient->setRedirectUri(route('admin.google-drive-callback'));
        $this->gClient->setDeveloperKey('AIzaSyB0JsRitCEiYehLDllpu7v5ULPwJZUpbcw');
        $this->gClient->setScopes([
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive',
        ]);

        $this->gClient->setAccessType("offline");
        $this->gClient->setApprovalPrompt("auto");
    }

    public function googleLogin(Request $request)
    {
        
        // dd($request->all());
        $rules = [
            'file' => 'required', // Adjust the allowed file types and size limit as needed
        ];
        
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'File filed is required');
        }
        
        if (!$this->checkGoogleCredentials()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'Google Drive credentials missing!');
        }
        
        // $google_oauthV2 = new \Google_Service_Oauth2($this->gClient);
        
        
        if ($request->get('code')) {

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
        if ($request->session()->get('token')) {
            
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
        if ($this->gClient->getAccessToken()) {
            // return redirect()->back()->with('notupload', 'File filed is required');
            
            // FOR LOGGED IN USER, GET DETAILS FROM GOOGLE USING ACCESS TOKEN
            $user = User::find(1);
            
            $user->access_token = json_encode($request->session()->get('token'));
            
            $user->refresh_token = json_encode($request->session()->get('refreshtoken')); // Store the refresh token
            
            $user->save();
            
            
            
            
            return $this->googleDriveFileUpload($request);
        } else {
            // FOR GUEST USER, GET GOOGLE LOGIN URL
            $authUrl = $this->gClient->createAuthUrl([
                'scope' => 'https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive',
            ]);
            return redirect()->to($authUrl);
        }
    }
    
    
    // Add a method to display the file upload form
    public function showUploadForm()
    {
        return view('google');
    }

    public function fetchFilesByFolderName()
    {
        if (!$this->hasGoogleDriveAccess()) {
            return null;
        }

        $folderName = 'REIFuze';
        if (!$this->checkGoogleCredentials()) {
            return redirect()->back()->with('notupload', 'Google Drive credentials missing!');
        }

        $service = new \Google_Service_Drive($this->gClient);

        // Get the user's access token
        $user = User::find(1);
        $this->gClient->setAccessToken(json_decode($user->access_token, true));

        // Check if the access token is expired and refresh if needed
        if ($this->gClient->isAccessTokenExpired()) {
            $user = User::find(1);
            $refreshToken = $user->refresh_token;
            $this->gClient->fetchAccessTokenWithRefreshToken($refreshToken);
            $accessToken = $this->gClient->getAccessToken();
            $user->access_token = json_encode($accessToken);
            $user->save();
        }

        // Get the folder ID by name
        $folderId = $this->getFolderIdByName($service, $folderName);
        
        if (!$folderId) {
            return redirect()->back();
        }
        // List files in the specified folder
        $files = $service->files->listFiles([
            'q' => "'$folderId' in parents",
        ]);

        
        // Process the files, you can display them or do further actions
        $googleDrivefile = [];
        foreach ($files as $folder) {
            if ($folder->mimeType == 'application/vnd.google-apps.folder') {
                $googleDrivefile['folder'][] = $folder->name;
                $subfiles = $service->files->listFiles([
                    'q' => "'$folder->id' in parents",
                ]);    

                foreach ($subfiles as $file) {
                    if ($file->mimeType != 'application/vnd.google-apps.folder') {
                        // It's a subfolder, skip processing
                        $file->directory = $folder->name;
                        $googleDrivefile['files'][] = $file;
                    }
                }
            }
        }
        // dd($googleDrivefile ['folder']);
        return $googleDrivefile;
        // You can pass the $files data to a view or use it as needed

        // return view('files.index', compact('files'));
    }

    private function getFolderIdByName(DriveService $driveService, $folderName, $parentFolderId = null)
    {

        // Check if google credentials exist
        if (!$this->checkGoogleCredentials()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'Google Drive credentials missing!');
        }

        if (!$this->hasGoogleDriveAccess()) {
            return null;
        }

        $pageToken = null;
        $query = "mimeType='application/vnd.google-apps.folder' and name='$folderName'";

        if ($parentFolderId) {
            $query .= " and '$parentFolderId' in parents";
        }

        do {
            try {
                $response = $driveService->files->listFiles([
                    'q'          => $query,
                    'spaces'     => 'drive',
                    'pageToken'  => $pageToken,
                ]);

                foreach ($response->files as $folder) {
                    return $folder->id;
                }

                $pageToken = $response->nextPageToken;
            } catch (\Google\Service\Exception $e) {
                // Handle the exception and log the error for debugging.
                // You can inspect $e to get more details about the error.
                Log::error('Google Drive API Error: ' . $e->getMessage());
                return null;
            }
        } while ($pageToken != null);

        // If the folder is not found
        return null;
    }


    public function handleGoogleCallback(Request $request)
    {
        // https://brian-bagnall.com/bulk/bulk_sms_new/public/admin/google-drive-callback?code=4%2F0AfJohXm8CHuZ4ZSpgcffenxi6qNH8n3seTJ1I4LodGtCBpCMiJu4XQtXxyzCYjOti6K5mA&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file
        // Check if google credentials exist
        if (!$this->checkGoogleCredentials()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'Google Drive credentials missing!');
        }
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

    public function googleDriveFileUpload(Request $request)
    {
        $rules = [
            'file' => 'required', // Adjust the allowed file types and size limit as needed
        ];

        $directory = $request->lead_status;
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'Purchase agreement file is required');
        }

        if (!$this->checkGoogleCredentials()) {
            // Validation failed, redirect back with errors
            return redirect()->back()->with('notupload', 'Google Drive credentials missing!');
        }
        $agreement_file = $request->file;
        $contact = Contact::findOrFail($request->contact_id);
        
        $agreement_fileName = $agreement_file->getClientOriginalName();
        $extension = $agreement_file->getClientOriginalExtension();
        // Valid File Extensions
        // $valid_extension = array("pdf");
        // $directory ='miscellaneous';
        
        if($directory == 'miscellaneous') {
            
        } else if($directory == 'photo'){
            $valid_extension = array("jpg", "jpeg", "png", "gif");
            if (!in_array(strtolower($extension), $valid_extension)) {
                Alert::error('Oops!', "Please enter only photo file");
                return redirect()->back();
            }
        } else {
            $valid_extension = array("pdf");
            if (!in_array(strtolower($extension), $valid_extension)) {
                
                Alert::error('Oops!', "Please enter only pdf file");
                return redirect()->back();
            }
            
        }
        
        // Check file extension
        $agreement_filenameNew = time() . '.' . $agreement_fileName;
            $service = new \Google_Service_Drive($this->gClient);

            $user = User::find(1);

            $this->gClient->setAccessToken(json_decode($user->access_token, true));

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

            $parentFolderName = 'REIFuze';
            
            // Check if the parent folder exists
            $parentFolderId = $this->getFolderIdByName($service, $parentFolderName, null);
            // If the parent folder doesn't exist, create it
            if (!$parentFolderId) {
                $parentFolderMetadata = new \Google_Service_Drive_DriveFile([
                    'name' => $parentFolderName,
                    'mimeType' => 'application/vnd.google-apps.folder'
                ]);

                $parentFolder = $service->files->create($parentFolderMetadata, ['fields' => 'id']);
                $parentFolderId = $parentFolder->id;
            }

            $subFolderId = $this->getFolderIdByName($service, $directory, $parentFolderId);
            
            if (!$subFolderId) {
                // Now create the subfolder within the parent folder
                $fileMetadata = new \Google_Service_Drive_DriveFile([
                    'name' => $directory,
                    'parents' => [$parentFolderId],
                    'mimeType' => 'application/vnd.google-apps.folder'
                ]);

                $subfolder = $service->files->create($fileMetadata, ['fields' => 'id']);
                $subFolderId = $subfolder->id;
            }
            // Now upload the file into the subfolder
            $file = new \Google_Service_Drive_DriveFile([
                'name' => $request->file('file')->getClientOriginalName(),
                'parents' => [$subFolderId]
            ]);
            
            // printf("Folder ID: %s\n", $folder->id);
            
            // $file = new \Google_Service_Drive_DriveFile(array('name' => $request->file('purchase_agreement')->getClientOriginalName(), 'parents' => array($subfolder->id)));
            
            $result = $service->files->create($file, array(
                'data' => file_get_contents($request->file('file')), // ADD YOUR FILE PATH WHICH YOU WANT TO UPLOAD ON GOOGLE DRIVE
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'media'
            ));
            $url = 'https://drive.google.com/open?id=' . $result->id;
            $contact->purchase_agreement_name = $agreement_filenameNew;
            $contact->save();
            return response()->json('Purchase Agreement uploaded to Google Drive. URL: ' . $url);
            return redirect()->back()->with('upload', 'Purchase Agreement uploaded to Google Drive. URL: ' . $url);
            
    }

    // Check Google Credentials
    public function checkGoogleCredentials()
    {
        // Fetch Google Drive Credentials
        $settings = Settings::first()->toArray();

        $GOOGLE_DRIVE_CLIENT_ID = $settings['google_drive_client_id'];
        $GOOGLE_DRIVE_CLIENT_SECRET = $settings['google_drive_client_secret'];
        $GOOGLE_DRIVE_DEVELOPER_KEY = $settings['google_drive_developer_key'];

        // Check if required credentials are missing
        if (!$GOOGLE_DRIVE_CLIENT_ID || !$GOOGLE_DRIVE_CLIENT_SECRET) {
            return false;
        } else {
            return true;
        }
    }

    // Add this function to your GoogleDriveController class
    public function hasGoogleDriveAccess()
    {
        // Check if Google Drive credentials exist
        if (!$this->checkGoogleCredentials()) {
            return false; // Google Drive credentials are missing
        }

        $user = User::find(1);

        // Check if the user has an access token
        if (!$user || empty($user->access_token)) {
            return false; // User does not have access token
        }

        $accessToken = json_decode($user->access_token, true);

        // Check if the access token is valid and not expired
        if (empty($accessToken) && $this->gClient->isAccessTokenExpired()) {
            return false; // Access token is invalid or expired
        }

        return true; // User has valid Google Drive access
    }
}
