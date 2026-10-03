<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentsPanel extends Component
{
    use WithFileUploads;

    public Model $documentable;

    public string $title = '';

    public $file;

    public bool $canManage = false;

    public function mount(Model $documentable): void
    {
        abort_unless(Document::userCanView(Auth::user(), $documentable), 403);

        $this->documentable = $documentable;
        $this->canManage = Document::userCanManage(Auth::user(), $documentable);
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240'],
        ];
    }

    public function upload(): void
    {
        abort_unless($this->canManage, 403);

        $validated = $this->validate();

        $path = $this->file->store('documents/'.class_basename($this->documentable).'/'.$this->documentable->id, 'local');

        $this->documentable->documents()->create([
            'title' => $validated['title'],
            'file_path' => $path,
            'original_filename' => $this->file->getClientOriginalName(),
            'mime_type' => $this->file->getMimeType(),
            'file_size' => $this->file->getSize(),
            'uploaded_by' => Auth::id(),
        ]);

        \App\Models\ActivityLog::record(
            action: strtolower(class_basename($this->documentable)).'.document_uploaded',
            description: "Uploaded \"{$validated['title']}\" for {$this->subjectLabel()}.",
            subject: $this->documentable,
            properties: ['title' => $validated['title'], 'filename' => $this->file->getClientOriginalName()],
        );

        $this->reset(['title', 'file']);
        session()->flash('status', 'Document uploaded.');
    }

    public function delete(int $documentId): void
    {
        abort_unless($this->canManage, 403);

        $document = $this->documentable->documents()->findOrFail($documentId);
        $title = $document->title;
        $document->deleteWithFile();

        \App\Models\ActivityLog::record(
            action: strtolower(class_basename($this->documentable)).'.document_deleted',
            description: "Deleted document \"{$title}\" from {$this->subjectLabel()}.",
            subject: $this->documentable,
            properties: ['title' => $title],
        );

        session()->flash('status', 'Document deleted.');
    }

    protected function subjectLabel(): string
    {
        if ($this->documentable instanceof \App\Models\Member) {
            return $this->documentable->full_name;
        }

        if ($this->documentable instanceof \App\Models\Loan) {
            return "loan {$this->documentable->loan_no}";
        }

        if ($this->documentable instanceof \App\Models\WelfareClaim) {
            return "welfare claim {$this->documentable->claim_no}";
        }

        return class_basename($this->documentable)." #{$this->documentable->id}";
    }

    public function render()
    {
        return view('livewire.documents.documents-panel', [
            'documents' => $this->documentable->documents,
        ]);
    }
}
