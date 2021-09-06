<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    public $newComment;
    use WithPagination;

    protected $listeners = [
        'delete' => 'remove'
    ];

    protected $rules = [
        'newComment' => 'required',
    ];

    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();

        session()->flash("message", "댓글이 성공적으로 삭제 되었습니다.");
    }

    public function mount()
    {
        $this->newComment = "default world";
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::latest()->paginate(5),
        ]);
    }

    public function addComment()
    {
        $this->validate();
        // $comment = new Comment();
        // $comment->user_id = Auth::user()->id;
        // $comment->save();

        Comment::create(
            [
                'user_id' => auth()->user()->id,
                'content' => $this->newComment,
            ]
        );

        session()->flash("message", "댓글이 성공적으로 등록 되었습니다.");
    }
}
