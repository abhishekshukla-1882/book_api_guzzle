<?php
// session_start();
require '../vendor/autoload.php';
use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use GuzzleHttp\Client;


class IndexController extends Controller
{
    public function indexAction()
    {
        $request = new Request();
        if(isset($_POST['submit'])){
            $val = $this->request->getPost('val');
        
            $val = urlencode($val);
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://openlibrary.org',
                // You can set any number of default request options.
                // 'timeout'  => 2.0,
            ]);
            $url="/search.json?q=".$val."&mode=ebooks&has_fulltext=true";

            $response = $client->request('GET', $url);
            $body = $response->getBody();
            $body = json_decode($body,1);
            $book = $body['docs'];
            // echo "<pre>";
            // // echo $body;
            // print_r($body['docs'][0]['title']);
            // die;
            $this->view->book = $book;
    }
        

    }
    public function detailAction(){
        $client = new Client();
        if(isset($_POST['sub'])){
            $val =urlencode($this->request->getPost('title'));
            // echo $val;
            // print_r( $val->full_title);
            // die;
            // https://openlibrary.org/api/books?bibkeys=ISBN:9780980200447&jscmd=details&format=json
            $url = "https://openlibrary.org/api/books?bibkeys=ISBN:$val&jscmd=details&format=json";
            //    $url ="https://openlibrary.org/search.json?q=$val&mode=ebooks&has_fulltext=true";
            $response = $client->request('GET', $url);
            $body = $response->getBody();
            $body = json_decode($body,1);
            // $book = $body['docs'];
        //     // $book = ((array)json_decode($response));
        //    echo "<pre>";
        //    print_r($body);
        //    die;
            $this->view->book = $body["ISBN:$val"];
            $this->view->val = $val;

        }
        
    }
}