<?php
namespace App\Repositories\Attachments;

use App\Models\Attachment;
use App\Repositories\Interfaces\Attachments\AttachmentRepositoryInterface;

class AttachmentRepository implements AttachmentRepositoryInterface
{

    /**
     * stor task details.
     *  @param array of $attachmentData
     *  @return object of $attachment
     */
    public function storeAttachment($attachmentData)
    {
        $attachment = Attachment::create($attachmentData);
        return $attachment;
    }
}
