<?php

namespace Phumsoft\Phumpie\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class AbstractHomeWebController extends Controller implements AbstractHomeWebControllerInterface
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var string
     */
    protected string $name = '';

    /**
     * Show the loan dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $company_id = 0)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $user = $request->user();
        if ($company_id === 0 && $user->last_selected_id !== null) {
            return redirect('/' . $user->last_selected_id . '/home');
        } else {
            $user_company = $request->user()->companies()
                ->wherePivot('is_confirm', true)->first();
            if ($user_company === null && $request->path() !== '/') {
                return redirect('/');
            } elseif ($user_company !== null && (!is_numeric($company_id) || $company_id === 0)) {
                return redirect('/' . $user_company->id . '/home');
            }
        }
        $user->last_selected_id = $company_id;
        $this->companyInfo($user->last_selected_id);

        return $this->renderView('home');
    }

    protected function renderView($name)
    {
        return view($name, $this->data);
    }
}
