<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InstagramAPI\Exception\ChallengeRequiredException;
use InstagramAPI\Instagram;
use InstagramAPI\Exception\IncorrectPasswordException;
use InstagramAPI\Exception\AccountDisabledException;
use InstagramAPI\Exception\EmptyResponseException;
use InstagramAPI\Response\ChallengeResponse;
use GuzzleHttp\Psr7\Request as HttpRequest;

/**
 * Class LoginController
 */
class LoginController extends Controller
{
    /**
     * @int
     */
    private $_debug = false;

    /**
     * @int
     */
    private $_truncatedDebug = false;

    /**
     * Endereço do socket de conexão com o Tor
     * @string
     */
    private $_torProxy = 'socks5h://127.0.0.1:9150';

    /**
     * @Instagram
     */
    private $_instagram;

    public function __construct()
    {
        $sessionsdir = storage_path('instagram');

        // Instancia a classe do Instagram
        $this->_instagram = new Instagram($this->_debug, $this->_truncatedDebug, [
            'storage'    => 'file',
            'basefolder' => $sessionsdir
        ]);

        // Configurações
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        $this->_instagram->setVerifySSL(false);
        $this->_instagram->setProxy($this->_torProxy);
    }

    /**
     * Exibe a página de login
     */
    public function index(Request $request)
    {
        if ($request->session()->has('loggedin')) {
            return redirect()->action('HomeController@index');
        }

        return view('login');
    }

    /**
     * Faz login no instagram
     */
    public function login(Request $request)
    {
        $username = $request->get('usuario');
        $password = $request->get('senha');

        $result = ['error' => false];

        // Se o usuário já tiver feito login antes
//        if ($instagram->settings->hasUser($username)) {
//
//            $instagram->settings->setActiveUser($username);
//            $instagram->client->loadCookieJar();
//            $instagram->isLoggedIn = true;
//
//        } else {

            // Tenta realizar o login pelo proxy
            try {
                $this->_instagram->login($username, $password);
            } catch (IncorrectPasswordException $error) {

                $result = [
                    'error'   => true,
                    'message' => 'Nome de usuário ou senha incorretos.'
                ];

            } catch (AccountDisabledException $error) {

                $result = [
                    'error'   => true,
                    'message' => 'Sua conta do Instagram está desativada, por favor tente usar uma conta diferente.'
                ];

            } catch (EmptyResponseException $error) {

                $result = [
                    'error'   => true,
                    'message' => 'O servidor não retornou o resultado conforme o esperado, por favor tente novamente.'
                ];

            } catch (ChallengeRequiredException $error) {

                $challenge_url = $error->getResponse()->challenge->url;


                $this->_instagram->client->api(new HttpRequest('GET', $challenge_url));

                echo $challenge_url;
                $request->session()->put('challenge_url', $challenge_url);

                die;

                $result = [
                    'error' => true,
                    'response' => $error->getResponse(),
                    'message' => $error->getMessage()
                ];

            } catch (Exception $error) {

                $result = [
                    'error'   => true,
                    'message' => $error->getMessage()
                ];

                Log::error($error->getMessage(), ['username' => $username, 'password' => $password]);

            }
        //}

        if (!$result['error']) {

            $user = $this->_instagram->account->getCurrentUser()->getUser();

            $result['cookies'] = $this->_instagram->settings->getCookies();

            echo '<pre>';
            print_r($user);
            die;

            if (empty($city = $user->getCityName())) {
                $ddd = substr($user->getNationalNumber(), 0, 2);

            }

            $result['user'] = [
                'id'              => $user->getId(),
                'name'            => $user->getFullName(),
                'email'           => $user->getEmail(),
                'picture'         => $user->getProfilePicUrl(),
                'gender'          => $user->getGender(),
                'city'            => $city,
                'device'          => $this->_instagram->device->getDevice(),
                'followers_count' => $user->getFollowerCount(),
                'following_count' => $user->getFollowingCount()
            ];

            $request->session()->put('loggedin', true);
            $request->session()->put('user', $result['user']);
        }

        return response()->json($result);
    }

    public function sendcode(Request $request)
    {
        $challenge_url = $request->session()->get('challenge_url');

        $body = ['choice' => 1];
        $headers = [];

        $requestInstance = new HttpRequest('POST', $challenge_url, $headers, http_build_query($body));

        print_r($this->_instagram->client->api($requestInstance)->getHeaders());
    }

    public function challenge(Request $request)
    {
        $challenge_url = $request->session()->get('challenge_url');
        $code = $request->get('security_code');

        $body = ['security_code' => $code];
        $headers = [];

        $requestInstance = new HttpRequest('POST', $challenge_url, $headers, $body);

        print_r($this->_instagram->client->api($requestInstance)->getHeaders());
    }
}
