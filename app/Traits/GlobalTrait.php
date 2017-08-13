<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Auth;
use Storage;
use Image;
use App\Models\Media;

trait GlobalTrait
{
    public function saveMedia($id, $model, $folder, $filename, $file)
    {
        $size = Storage::size($folder.$filename);
        $mime = Storage::mimeType($folder.$filename);
        $ext = pathinfo(storage_path().$folder.$filename, PATHINFO_EXTENSION);
        
        $data = [
          'mediable_id' => $id,
          'mediable_type' => $model,
          'folder' => $folder,
          'filename' => $filename,
          'extension' => $ext,
          'mime' => $mime,
          'size' => $size,
          'caption' => $filename
        ];

        $media = Media::where('mediable_id', $id)->where('mediable_type', $model)->first();
        if (!$media) {
            $media = Media::create($data);
        } else {
            $media->update($data);
        }

        return $media;
    }

    public function deletePhotoIfExists($path, $filename)
    {
        if (Storage::disk('local')->exists($path.$filename)) {
            Storage::delete($path.$filename);
        }
    }

    public function deleteMedia($db, $model)
    {
        $media = Media::where('mediable_id', $db->id)->where('mediable_type', $model)->first();
        if (count($media) > 0) {
            $this->deletePhotoIfExists($media->folder, $media->filename);
            $media->delete();
        }
    }
}
