<?php

use App\Models\Categorie;
use App\Models\InfosSystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Vimeo;
use Vimeo\Exceptions\VimeoUploadException;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notification;


function redirectAuth () {


    if (Auth::check()) {

        if (Auth::user()->role->slug === 'admin') {
            return '/admin';
        } elseif (Auth::user()->role->slug === 'student') {
            return '/mon-compte';
        } elseif (Auth::user()->role->slug === 'teacher') {
            return '/formateurs';
        } elseif (Auth::user()->role->slug === 'educational-admin') {
            return '/admin-pedagogique';
        }

    }

    return 'null';

}

function uploadVideoToVimeo ($path, $title, $description) {

    $config = [
        'client_secret' => env('VIMEO_SECRET'),
        'client_id' => env('VIMEO_CLIENT'),
        'access_token' => env('VIMEO_ACCESS'),
    ];

    if (empty($config['access_token'])) {
        throw new Exception(
            'You can not upload a file without an access token. You can find this token on your app page, or generate ' .
            'one using `auth.php`.'
        );
    }

    // Instantiate the library with your client id, secret and access token (pulled from dev site)
    $lib = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);

    // Create a variable with a hard coded path to your file system
    $file_name = $path;

    // echo 'Uploading: ' . $file_name . "\n";

    try {
        // Upload the file and include the video title and description.
        $uri = $lib->upload($file_name, array(
            'name' => $title,
            'description' => $description,
            'privacy' => [
                'view' => 'unlisted'
            ],
            'embed' => [
                'buttons' => [
                    'embed' => false,
                    'like' => false,
                    'share' => false,
                    'watchlater' => false,
                ],
                'logos' => [
                    'custom' => [
                        'active' => false,
                    ],
                    'vimeo' => false,
                ],
                'title' => [
                    'name' => 'hide',
                    'owner' => 'hide',
                    'portrait' => 'hide',
                ]
            ]
        ));

        // Get the metadata response from the upload and log out the Vimeo.com url
        // $video_data = $lib->request($uri . '?fields=link');
        // // echo '"' . $file_name . ' has been uploaded to ' . $video_data['body']['link'] . "\n";

        // // Make an API call to edit the title and description of the video.
        // $lib->request($uri, array(
        //     'name' => 'Vimeo API SDK test edit',
        //     'description' => "This video was edited through the Vimeo API's PHP SDK.",
        // ), 'PATCH');

        // echo 'The title and description for ' . $uri . ' has been edited.' . "\n";

        // // Make an API call to see if the video is finished transcoding.
        // $video_data = $lib->request($uri . '?fields=transcode.status');
        // echo 'The transcode status for ' . $uri . ' is: ' . $video_data['body']['transcode']['status'] . "\n";
        return str_replace('/videos/', '', $uri);
    } catch (VimeoUploadException $e) {
        // We may have had an error. We can't resolve it here necessarily, so report it to the user.
        echo 'Error uploading ' . $file_name . "\n";
        echo 'Server reported: ' . $e->getMessage() . "\n";
    } catch (VimeoRequestException $e) {
        echo 'There was an error making the request.' . "\n";
        echo 'Server reported: ' . $e->getMessage() . "\n";
    }
}

function createVimeoFolder($name)
{
    return Http::withHeaders([

        'Authorization' => 'bearer '.env('VIMEO_ACCESS'),
        'Content-Type' => 'application/json',
        'Accept' => '	application/vnd.vimeo.*+json;version=3.4',

    ])->post('https://api.vimeo.com/me/projects', [

        'name' => $name,
    ]);

    // dd($response);
}

function moveVideoToFolder($uri_folder, $id_video)
{
    return Http::withHeaders([

        'Authorization' => 'bearer '.env('VIMEO_ACCESS'),
        'Content-Type' => 'application/json',
        'Accept' => '	application/vnd.vimeo.*+json;version=3.4',

    ])->put("https://api.vimeo.com$uri_folder/videos/$id_video");

    // dd($response);
}


function deleteVimeoVideo($id_video)
{
    try {
        return Http::withHeaders([

            'Authorization' => 'bearer '.env('VIMEO_ACCESS'),
            'Content-Type' => 'application/json',
            'Accept' => '	application/vnd.vimeo.*+json;version=3.4',

        ])->delete("https://api.vimeo.com/videos/$id_video");

    } catch (\Throwable $th) {
        dd($th);
    }

    // dd($response);
}

function getVimeoVideo($id_video)
{
    try {
        return Http::withHeaders([

            'Authorization' => 'bearer '.env('VIMEO_ACCESS'),
            'Content-Type' => 'application/json',
            'Accept' => '	application/vnd.vimeo.*+json;version=3.4',

        ])->get("https://api.vimeo.com/videos/$id_video");

    } catch (\Throwable $th) {
        dd($th);
    }

    // dd($response);
}

function paginate($items, $perPage = 5, $page = null, $options = [])
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}

function getCategories() {
    return Categorie::orderBy('title')->get();
}

function getInfoSystem() {
    return InfosSystem::find(1);
}





function paydunya_config($cancel_url, $success_url) {

    \Paydunya\Setup::setMasterKey(env('PAYDUNYA_MASTER_KEY'));

    if(env('PAYDUNYA_MODE') == 'test') {
        \Paydunya\Setup::setPublicKey(env('PAYDUNYA_PUBLIC_KEY_TEST'));
        \Paydunya\Setup::setPrivateKey(env('PAYDUNYA_PRIVATE_KEY_TEST'));
        \Paydunya\Setup::setToken(env('PAYDUNYA_TOKEN_TEST'));
        \Paydunya\Setup::setMode('test');
    }
    else{
        \Paydunya\Setup::setPublicKey(env('PAYDUNYA_PUBLIC_KEY'));
        \Paydunya\Setup::setPrivateKey(env('PAYDUNYA_PRIVATE_KEY'));
        \Paydunya\Setup::setToken(env('PAYDUNYA_TOKEN'));
        \Paydunya\Setup::setMode('live');
    }

    //Configuration des informations de votre service/entreprise
    \Paydunya\Checkout\Store::setName("Carapaces"); // Seul le nom est requis
    \Paydunya\Checkout\Store::setTagline("Elearning");
    \Paydunya\Checkout\Store::setPhoneNumber("776795274");
    \Paydunya\Checkout\Store::setPostalAddress("Mermoz, Dakar, Sénégal");
    \Paydunya\Checkout\Store::setWebsiteUrl("http://www.fc.sn");
    \Paydunya\Checkout\Store::setLogoUrl("https://z-p3-scontent.fdkr5-1.fna.fbcdn.net/v/t1.0-9/120535813_104144604792956_3289157610939903970_o.jpg?_nc_cat=106&ccb=2&_nc_sid=e3f864&_nc_eui2=AeFhCRPNMQR5tj-BYiBYJQsQ8H_WyMik1Qfwf9bIyKTVB00h5gDx6ME7VG2vkq4N6qrn4I20kND7hJd5HsBuYBXH&_nc_ohc=TllBIY3v6toAX-_KFiV&_nc_ht=z-p3-scontent.fdkr5-1.fna&oh=45f47f55ccc5a0e987cc81b37fd3cee0&oe=6020E9A4");

    \Paydunya\Checkout\Store::setCancelUrl($cancel_url);
    \Paydunya\Checkout\Store::setReturnUrl($success_url);

}

function check_paydunya_invoice() {

//A insérer dans le fichier du code source qui doit effectuer l'action

// PayDunya rajoutera automatiquement le token de la facture sous forme de QUERYSTRING "token"
// si vous avez configuré un "return_url" ou "cancel_url".
// Récupérez donc le token en pur PHP via $_GET['token']
$token = $_GET['token'];
paydunya_config('', '');

$invoice = new \Paydunya\Checkout\CheckoutInvoice();
    if ($invoice->confirm($token)) {

        // Récupérer le statut du paiement
        // Le statut du paiement peut être soit completed, pending, cancelled

        // Récupérer l'URL du reçu PDF électronique pour téléchargement

        return ['status' => $invoice->getStatus(), 'receipt_link' => $invoice->getReceiptUrl()];
    }else{

        session()->flash('error','Vous venez d\'annuler votre commande!');
        return ['status' => null, 'receipt_link' => null];
    }
}


// 😍😍❤️❤️🤓
function sendNotificationMail(String $email, String $username, String $message) {
    try {
        Mail::to($email)
            ->send(new Notification($username, $message));
    } catch (\Throwable $th) {
        dd($th);
    }
}
