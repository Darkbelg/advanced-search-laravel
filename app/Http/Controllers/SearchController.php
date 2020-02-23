<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_SearchResult;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function index(Request $request)
    {
        request()->validate(
            [
                'search' => 'required',
                'maxResults' => 'required',
//                'type' => 'required',
                'videoDefinition' => 'required',
                'order' => 'required'
            ]
        );


//        dd(request()->all());
//        require_once '../../../vendor/autoload.php';

//        /**
//         * Sample PHP code for youtube.search.list
//         * See instructions for running these code samples locally:
//         * https://developers.google.com/explorer-help/guides/code_samples#php
//         */
//
//        if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
//            throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
//        }
//        require_once __DIR__ . '/vendor/autoload.php';
//
//        $client = new Google_Client();
//        $client->setApplicationName('API code samples');
//        $client->setScopes(
//            [
//                'https://www.googleapis.com/auth/youtube.force-ssl',
//            ]
//        );
//
//// TODO: For this request to work, you must replace
////       "YOUR_CLIENT_SECRET_FILE.json" with a pointer to your
////       client_secret.json file. For more information, see
////       https://cloud.google.com/iam/docs/creating-managing-service-account-keys
//        $client->setAuthConfig('YOUR_CLIENT_SECRET_FILE.json');
//        $client->setAccessType('offline');
//
//// Request authorization from the user.
//        $authUrl = $client->createAuthUrl();
//        printf("Open this link in your browser:\n%s\n", $authUrl);
//        print('Enter verification code: ');
//        $authCode = trim(fgets(STDIN));
//
//// Exchange authorization code for an access token.
//        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
//        $client->setAccessToken($accessToken);
//
//// Define service object for making API requests.
//        $service = new Google_Service_YouTube($client);
//
//        $queryParams = [
//            'q' => 'sunmi'
//        ];
//
//        $response = $service->search->listSearch('snippet', $queryParams);
//        print_r($response);

        $client = new Google_Client();
        $client->setApplicationName("advanced-search-laravel");
        $client->setDeveloperKey(env('YOUTUBE_API_KEY'));
        $service = new Google_Service_YouTube($client);

        $searchOptions = [
            'q' => request('search'),
            'maxResults' => request('maxResults'),
            'type' => 'video',
//            'type' => implode(',', request('type')),
            'order' => request('order')
        ];

        if (in_array('video', request('type'), false) && count(request('type')) === 1) {
            $searchOptions['videoDefinition'] = request('videoDefinition');
        }

        $searchResults = $service->search->listSearch('id,snippet', $searchOptions);

//        dd($searchResults->getItems());

        // Google_Service_YouTube_SearchResult $item
        /* @var $item Google_Service_YouTube_SearchResult */
//        $images = [];
//        foreach ($searchResults->getItems() as $item){
//            echo '<pre>';
//            print($item->getSnippet()->title);
//            echo '</pre>';
//            $images[] = $item->getSnippet()->getThumbnails()->getMedium()  ->getUrl();
//        }

//        die();

        $dataSet = [];
        $videoIds = [];
        $dataSetResultCount = [];

        foreach ($searchResults as $key => $searchResult) {
//            dump($searchResult);
//            $dataSet[] = '"' . $searchResult['snippet']['publishedAt'] . '"';

            if ($searchResult['id']['kind'] === 'youtube#video') {
                $videoIds[] = $searchResult['id']['videoId'];
            }
        }
//        sort($dataSet);
//        $dataSet = implode(',', $dataSet);

        $videoId['id'] = implode(',', $videoIds);

        $videosDetail = $service->videos->listVideos('statistics,contentDetails,snippet,id', $videoId);

        foreach ($videosDetail as $key => $videoDetail){
            $dataSet[] = '"' .  $videoDetail['statistics']['viewCount'] . '"';
            $dataSetResultCount[] = '"' . $videoDetail['snippet']['publishedAt'] . '"';
        }

//        sort($dataSet);
        $dataSet = implode(',', $dataSet);
        $dataSetResultCount = implode(',', $dataSetResultCount);



//        dd($videosDetail);

        $urlPath = $this->getUrlPathOnLambda();
        return view(
            'result',
            [
                'results' => $searchResults->getItems(),
                'request' => $request,
                'urlPath' => $urlPath,
                'dataSet' => $dataSet,
                'dataSetResultCount' => $dataSetResultCount
            ]
        );
    }

    private function getUrlPathOnLambda()
    {
        return isset(request()->server()['LAMBDA_CONTEXT']) ? json_decode(
            request()->server()['LAMBDA_CONTEXT']
        )->path : '';
    }

    public function show()
    {
        $urlPath = $this->getUrlPathOnLambda();

        return view('search', ['urlPath' => $urlPath]);
    }
}
