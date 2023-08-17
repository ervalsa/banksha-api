<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Melihovv\Base64ImageDecoder\Base64ImageDecoder;
use Illuminate\Support\Str;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'pin' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status_code' => 400,
                    'errors' => $validator->messages(), 
                ], 400
            );
        }

        $user = User::where('email', $request->email)->exists();

        if ($user) {
            return response()->json(
                [
                    'status_code' => 409,
                    'message' => 'Email already taken'
                ], 409
            );
        }

        DB::beginTransaction();

        try {
            $profilePhoto = null;
            $ktpPhoto = null;

            if ($request->profile_photo) {
                $profilePhoto = $this->uploadBase64Image($request->profile_photo);
            }

            if ($request->ktp_photo) {
                $ktpPhoto = $this->uploadBase64Image($request->ktp_photo);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->email,
                'password' => bcrypt($request->password),
                'profile_photo' => $profilePhoto,
                'ktp_photo' => $ktpPhoto,
                'verified' => ($ktpPhoto) ? true : false
            ]);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'pin' => $request->pin,
                'card_number' => $this->generateCardNumber(16)
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            
            return response()->json(
                [
                    'status_code' => 500,
                    'message' => $th->getMessage()
                ], 500
            );
        }
    }

    private function generateCardNumber($length) 
    {
        $result = '';
        for ($i=0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        $wallet = Wallet::where('card_number', $result)->exists();

        if ($wallet) {
            return $this->generateCardNumber($length);
        }

        return $result;
    }

    private function uploadBase64Image($base64Image)
    {
        $decoder = new Base64ImageDecoder($base64Image, $allowedFormats = ['jpeg', 'png', 'jpg']);
        $decodedContent = $decoder->getDecodedContent();

        $format = $decoder->getFormat();
        $image = Str::random(10).'.'.$format;
        Storage::disk('public')->put($image, $decodedContent);

        return $image;
    }
}
