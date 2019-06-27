<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\InquiryDetail;
use App\Models\Project;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user')
            ->only(['update', 'destroy']);
    }


    public function index()
    {
        return Inquiry::orderBy('id', 'desc')
            ->withCount('details')
            ->paginate();
    }


    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'comment' => 'required|string',
        ],[],[
            'nickname' => 'ニックネーム',
            'comment' => 'ご質問・ご感想・ご要望など'
        ]);

        $inquiry = new Inquiry();
        $inquiry->nickname = $request->nickname;
        $inquiry->comment = $request->comment;
        if(auth('user')->check()) {
            $inquiry->user_id = auth('user')->user()->id;
        }
        $inquiry->save();

        return $inquiry;
    }


    public function show(Inquiry $inquiry)
    {
        return $inquiry->load('details');
    }

    public function postDetail(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'comment' => 'required|string',
        ],[],[
            'nickname' => 'ニックネーム',
            'comment' => '回答など'
        ]);

        $detail = new InquiryDetail();
        $detail->inquiry_id = $inquiry->id;
        $detail->nickname = $request->nickname;
        $detail->comment = $request->comment;
        if(auth('user')->check()) {
            $detail->user_id = auth('user')->user()->id;
        }
        $detail->save();

        return $detail;
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'comment' => 'required|string',
        ],[],[
            'nickname' => 'ニックネーム',
            'comment' => 'ご質問・ご感想・ご要望など'
        ]);

        $inquiry->nickname = $request->nickname;
        $inquiry->comment = $request->comment;
        $inquiry->save();

        return $inquiry;
    }


    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return;
    }
}
