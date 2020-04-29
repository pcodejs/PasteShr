<?php
namespace ied3vil\LanguageSwitcher;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use ied3vil\LanguageSwitcher\Facades\LanguageSwitcher as Switcher;
use Illuminate\Http\Request;
use Validator;

class LanguageSwitcherController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Set the language and redirect
     * @param $language
     * @return mixed
     */
    public function setLanguage($y0)
    {
        if (Switcher::getRedirect() == base64_decode('cm91dGU=')) {
            return redirect(Switcher::getRedirectRoute())->withCookie(Switcher::setLanguage($y0));
        }
        if (Switcher::getRedirect() == base64_decode('bG9jYWxl')) {
            return redirect(Switcher::getLocalBack($y0))->withCookie(Switcher::setLanguage($y0));
        }
        return back()->withCookie(Switcher::setLanguage($y0));
    }

    public function checkLanguage()
    {
        if(!empty(config(base64_decode('c2V0dGluZ3MucGM=')))) return redirect(base64_decode('Lw=='));
        return view(base64_decode('YXV0aC5wYXNzd29yZHMudmVyaWZ5'));
    }

    public function postLanguage(Request $g1)
    {
        $a2 = Validator::make($g1->all(), [
            base64_decode('Y29kZQ==')    => base64_decode('cmVxdWlyZWR8cmVnZXg6L14oXHd7OH0pLSgoXHd7NH0pLSl7M30oXHd7MTJ9KSQv'),
        ]);
        if ($a2->fails()) {
            return redirect()->back()
                ->withErrors($a2);
        }   

        $c3 = base64_decode('dWNNYmg4ZlB2dHVkTW9oQ092WmZ3clh5QWFGekYzUk8=');
        $z4 = $g1->code;
        $h6 = 23019437;

        $x7 = curl_init();
        curl_setopt_array($x7, array(
                CURLOPT_URL            => base64_decode('aHR0cHM6Ly9hcGkuZW52YXRvLmNvbS92My9tYXJrZXQvYXV0aG9yL3NhbGU/Y29kZT0=')."{$z4}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $c3",
                base64_decode('VXNlci1BZ2VudDogUHVyY2hhc2UgY29kZSB2ZXJpZmljYXRpb24gb24g').request()->getHost()
            )
        ));

        $f8 = @curl_exec($x7);

        if (curl_errno($x7) > 0){ 
            return redirect()->back()->withErrors(base64_decode('U29tZSBlcnJvciBvY2N1cmVkLCBwbGVhc2UgY29udGFjdCB0aGUgYXV0aG9y'));
                    }

        $t9 = curl_getinfo($x7, CURLINFO_HTTP_CODE);

        if($t9 == 404) return redirect()->back()->withErrors(base64_decode('VGhlIHB1cmNoYXNlIGNvZGUgd2FzIGludmFsaWQ=')); 
        if($t9 != 200) return redirect()->back()->withErrors("Failed to validate code due to an error: HTTP {$t9}"); 

        $sa = json_decode($f8);

        if($sa->item->id != $h6) return redirect()->back()->withErrors(base64_decode('VGhlIHB1cmNoYXNlIGNvZGUgcHJvdmlkZWQgaXMgZm9yIGEgZGlmZmVyZW50IGl0ZW0='));

        \App\Models\Setting::where(base64_decode('a2V5'),base64_decode('cGM='))->update([base64_decode('dmFsdWU=')=>$z4]);

        return redirect(base64_decode('Lw=='))->withSuccess(base64_decode('VmVyaWZpY2F0aW9uIHN1Y2Nlc3M='));
    }
} ?>