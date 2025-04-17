<?php

namespace App\Http\Controllers;

class DeepLinkController extends Controller
{
    public function apple()
    {
        return response()->json([
            'applinks' => [
                'apps' => [],
                'details' => [
                    [
                        'appID' => 'TEAM_ID.com.empat.tech.toyvalley',
                        'paths' => ['/wishlist/*', '/product/*']
                    ]
                ]
            ]
        ]);
    }

    public function android()
    {
        return response()->json([
            [
                'relation' => ['delegate_permission/common.handle_all_urls'],
                'target' => [
                    'namespace' => 'android_app',
                    'package_name' => 'com.empat.tech.toyvalley',
                    'sha256_cert_fingerprints' => [
                        'YOUR:SHA256:FINGERPRINT'
                    ]
                ]
            ]
        ]);
    }
}