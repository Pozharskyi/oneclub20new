<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.08.2016
 * Time: 22:12
 */

namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Auth\UsersBonusesController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;

class SocialStepsContinueController extends Controller
{
    /**
     * Index position to collect data
     * from Social provider
     * @param $provider
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProviderData( $provider ) {

        $this->collectDataFromProvider( $provider );

        return view( 'auth\social\index' );
    }

    /**
     * Collecting data from social provider
     * Including it's all dependencies
     * @param $provider
     * @return int
     */
    private function collectDataFromProvider( $provider )
    {

        if( isset( $_GET['code'] ) )
        {
            // OAuth2.0 token named by param code
            $code = $_GET['code'];
            $params = SocialConfigDataController::getProviderConfig( $provider, $code );

            switch( $provider ) {

                /**
                 * If provider
                 * @is facebook ...
                 */
                case 'facebook':

                    $url = 'https://graph.facebook.com/oauth/access_token';

                    $tokenInfo = null;
                    parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);

                    if (count($tokenInfo) > 0 && isset($tokenInfo['access_token']))
                    {
                        $params = array('access_token' => $tokenInfo['access_token']);

                        $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params)) . '&fields=id,email,name,link,gender,picture,locale'), true);

                        if (isset($userInfo['id']))
                        {
                            $result = true;
                        } else
                        {
                            $result = false;
                        }

                        if( $result === true )
                        {
                            $full_name = $userInfo['name'];

                            $name_array = explode( " ", $full_name );

                            $id = $userInfo['id'];
                            $first_name = $name_array[0];
                            $last_name = $name_array[1];
                            $email = isset( $userInfo['email'] ) ? $userInfo['email'] : null;

                            $gender = isset( $userInfo['gender'] ) ? $userInfo['gender'] : null;
                            $gender == 'male' ? $gender = 'Male' : $gender = 'Female';

                            $cell = isset( $userInfo['cell'] ) ? $userInfo['cell'] : null;
                            $birth = isset( $userInfo['birth'] ) ? $userInfo['birth'] : null;

                        } else
                        {
                            die('Invalid social login. Please, try again later.');
                        }
                    } else
                    {
                        die('Invalid social login. Please, try again later.');
                    }

                    break;

                /**
                 * If provider
                 * @is google ...
                 */
                case 'google':

                    $url = 'https://accounts.google.com/o/oauth2/token';

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    $result = curl_exec($curl);
                    curl_close($curl);

                    $tokenInfo = json_decode($result, true);

                    if (isset($tokenInfo['access_token'])) {
                        $params['access_token'] = $tokenInfo['access_token'];

                        $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);

                        if (isset($userInfo['id'])) {
                            //$userInfo = $userInfo;
                            $result = true;
                        } else
                        {
                            $result = false;
                        }

                        if( $result === true )
                        {
                            $id = $userInfo['id'];
                            $first_name = $userInfo['given_name'];
                            $last_name = $userInfo['family_name'];
                            $email = isset( $userInfo['email'] ) ? $userInfo['email'] : null;
                            $gender = isset( $userInfo['gender'] ) ? $userInfo['gender'] : null;
                            $cell = isset( $userInfo['cell'] ) ? $userInfo['cell'] : null;
                            $birth = isset( $userInfo['birth'] ) ? $userInfo['birth'] : null;

                        } else
                        {
                            die('Invalid social login. Please, try again later.');
                        }
                    } else
                    {
                        die('Invalid social login. Please, try again later.');
                    }

                    break;

                default:
                    die('Invalid or incorrect social login. Please, try again later.');
            }

            $person = $this->actionSearchIfUserIsRegistered( $provider, $id );

            if( $person === false ) {

                $emailExists = $this->actionSearchEmailForExistance($email);

                if ($emailExists) {
                    User::where('email', $email)
                        ->update([
                            'provider' => $provider,
                            'social_id' => $id,
                        ]);
                } else {
                    User::create([
                        'name' => $first_name . ' ' . $last_name,
                        'email' => $email,
                        'password' => bcrypt( $provider . '_' . $id ),
                        'provider' => $provider,
                        'social_id' => $id,
                        'f_name' => $first_name,
                        'l_name' => $last_name,
                        'phone' => $cell,
                        'gender' => $gender,
                        'date_of_birth' => $birth,
                    ]);
                }

                $new_person = $this->actionSearchIfUserIsRegistered( $provider, $id );

                UsersBonusesController::actionInsertIntoBonuses( $new_person->id );
                Auth::loginUsingId( $new_person->id );
            } else
            {
                Auth::loginUsingId( $person->id );
            }
        }

        return 0;
    }

    /**
     * Validating if user is registered
     * in our shop
     * @param $provider
     * @param $social_id
     * @return bool
     */
    private function actionSearchIfUserIsRegistered( $provider, $social_id ) {

        $person = User::where('provider', '=', $provider)
                ->where('social_id', '=', $social_id)
                ->first(['id']);

        if( $person !== NULL ) {

            return $person;
        } else
        {
            return false;
        }
    }

    private function actionSearchEmailForExistance($email)
    {
        $person = User::where('email', $email)
            ->first(['id']);

        if (!is_null($person)) {
            return $person;
        } else {
            return false;
        }
    }
}