<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class Comments extends Component
{
    public $newComment;
    public $image;
    use WithPagination;
    use WithFileUploads;

    protected $listeners = [
        'delete' => 'remove'
    ];

    protected $rules = [
        'newComment' => 'required',
        'image' => 'image|max:10240',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();

        session()->flash("message", "댓글이 성공적으로 삭제 되었습니다.");
    }

    public function mount()
    {
        // $this->newComment = "default world";
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::latest()->paginate(5),
        ]);
    }

    public function addComment()
    {
        $this->validateOnly('newComment');
        // $comment = new Comment();
        // $comment->user_id = Auth::user()->id;
        // $comment->save();

        // 이미지가 있으면 원하는 폴더에 저장하고 저장된 파일의 이름을 기억한다. $imageFileName
        $imageFileName = null;
        if ($this->image) $imageFileName = $this->storeImage();

        Comment::create(
            [
                'user_id' => auth()->user()->id,
                'content' => $this->newComment,
                'image' => $imageFileName,
            ]
        );

        $this->newComment = '';
        $this->image = '';
        session()->flash("message", "댓글이 성공적으로 등록 되었습니다.");
    }

    protected function storeImage()
    {
        $this->image = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = Str::random() . '.png';
        $this->image->storeAs('public/images', $name);

        return $name;
    }
}
