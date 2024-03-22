<?php

namespace App\Services;
use App\Repositories\Interfaces\Attachments\AttachmentRepositoryInterface;
use App\Traits\ApiResponse;
use Validator;
use Illuminate\Http\Request;
class AttachmentService
{

    use ApiResponse;
    /**
     * @var $attachmentRepository
     */

    /**
     * order constructor.
     *
     * @param Repository $attachmentRepository
     */

    public function __construct(protected AttachmentRepositoryInterface $attachmentRepository){}

    
    public function storeAttachment(Request $request,$attachments)
    {
        $request->request->add(['attachments' => $attachments]); //add attachement in requrest
        $destinationPath = public_path('uploads');
        $pulicUrlPath = url('/') . '/uploads/';
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true); // Create the directory recursively
        }
        $file = $request->attachments;
        $fileExtension = time() . '.' . $file->getClientOriginalExtension();
        $realFname = $file->getClientOriginalName();
        $uniqueFname = rand() . time() . "_" . $fileExtension;
        $file->move($destinationPath, $uniqueFname);
        $url = $pulicUrlPath . $uniqueFname;
        $attachmentData = [
            'original_name' => $realFname,
            'temp_name' => $uniqueFname,
            'url' => $url
        ];
        $attachment = $this->attachmentRepository->storeAttachment($attachmentData);
        return $attachment;
    }

    
}
