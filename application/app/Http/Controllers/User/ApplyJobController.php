<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use App\Models\User;
use App\Models\ApplyJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplyJobController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->user()) {
            $notify[] = ['error', 'Пожалуйста, войдите в свою учетную запись'];
            return back()->withNotify($notify);
        }
        $applyJob = new ApplyJob();
        $exist_apply = $applyJob->where('post_id', $request->post_id)->where('user_id', auth()->id())->first();
        if ($exist_apply) {
            $notify[] = ['error', 'Вы уже подали заявку на эту вакансию.'];
            return back()->withNotify($notify);
        }
        $request->validate([
            'post_id' => 'required|numeric',
            'expect_salary' => 'required|numeric',
            'file' => 'mimes:doc,pdf,docx'

        ]);
        $applyJob->post_id = $request->post_id;
        $applyJob->user_id = auth()->id();
        $applyJob->expect_salary = $request->expect_salary;
        if ($request->hasFile('file')) {
            try {
                $applyJob->file = fileUploader($request->file, getFilePath('applyJob'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Не удалось загрузить ваше изображение'];
                return back()->withNotify($notify);
            }
        }

        $applyJob->save();
        $notify[] = ['success', 'Вакансия успешно принята'];
        return back()->withNotify($notify);

    }

    public function all_candidate(Request $request, $id)
    {

        $pageTitle = 'вакансии';
        $emptyMessage = 'Кандидатов не найдено';
        $candidates = ApplyJob::with('user', 'post')->where('post_id', $id)->orderBy('id','desc')->paginate(getPaginate());
        $user = User::where('id', auth()->user()->id)->with('posts.comments')->first();

        if ($request->search) {

            $candidates = ApplyJob::where('post_id',$id)->with(['user','post'])->whereHas('user',function ($q) use ($request) {
                $q->where('firstname', 'like', "%$request->search%")->orWhere('lastname', 'like', "%$request->search%");
            })->orderBy('id','desc')->paginate(getPaginate());
        }

        return view($this->activeTemplate . 'user.job-post.job-candidate', compact('pageTitle', 'candidates', 'emptyMessage', 'user'));
    }

    public function download_file($id)
    {
        $applyJob = ApplyJob::with('user', 'post')->where('id', $id)->first();
        $path = getFilePath('applyJob') . '/' . $applyJob->file;
        if (file_exists($path)) {
              $headers = array(
              'Content-Type: application/pdf',
            );
            return response()->download($path, $applyJob->file, $headers);
        }
        $notify[] = ['error', 'file is missing'];
        return back()->withNotify($notify);
    }
}
