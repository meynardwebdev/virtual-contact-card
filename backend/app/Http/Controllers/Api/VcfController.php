<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use JeroenDesloovere\VCard\VCard;

class VcfController extends Controller
{
    protected $api_endpoint = 'https://api.canzell.com/__public__/user-service';

    /**
     * @param Request $request
     * @return Response|mixed
     */
    public function download(Request $request)
    {
        // get request parameters
        $user_id = $request->id;

        // Retrieve data from the API endpoint
        $api_endpoint = $this->api_endpoint . '/users?key=id';
        $data = (Http::get($api_endpoint))->json();
        $user = isset($data[$user_id]) ? $data[$user_id] : false;

        if (!$user) {
            return response('User not found')->setStatusCode(400);
        }

        // Create the VCF
        $vcard = new VCard();
        $vcard->addName($user['last_name'], $user['first_name']);
        $vcard->addEmail($user['email']);
        $vcard->addPhoneNumber($user['phone'], 'PREF;WORK');
        $vcard->addRole(implode(', ', $user['roles']));
        // Commenting out photo since it returns an error due to redirect issues with photo link
        //$vcard->addPhoto($user['mug']);

        // Get vcard content
        $content = $vcard->getOutput();
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $filename = $user['first_name'] . '-' . $user['last_name'];

        // Serve VCF file to user
        return response($content)
            ->header('Content-Type', $iPhone ? 'text/vcard' : 'text/x-vcard')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.vcf"')
            ->header('Content-Length', mb_strlen($content, 'utf-8'))
            ->setStatusCode(200);
    }
}
