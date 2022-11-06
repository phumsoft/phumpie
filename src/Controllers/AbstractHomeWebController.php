<?php

namespace Phumsoft\Phumpie\Core\Controllers;

use App\Http\Controllers\Core\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class AbstractHomeWebController extends Controller
{
    protected $data = [];

    /**
     * @var string
     */
    protected string $name = '';

    public function __construct()
    {
    }

    abstract protected function companyInfo(int $company_id);

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

        return $this->render_view('home');
    }

    protected function render_view($name)
    {
        return view($name, $this->data);
    }
}
